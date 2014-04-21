<?php namespace Atyagi\LaravelAwsSsh\Commands;

use Atyagi\LaravelAwsSsh\AWS;
use Illuminate\Console\Command;
use Illuminate\Foundation\Application;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Remote\Connection;

class EC2TailCommand extends Command {

    protected $name = 'ec2:tail';
    protected $description = 'Tails the logs of a specific EC2 Instance';

    const INSTANCE_ID = 'instanceId';
    const LOGFILE = 'logFile';
    const USER = 'user';
    const KEY_FILE = 'keyFile';

    /**
     * @var Application
     */
    protected $app;

    /**
     * @var AWS
     */
    protected $aws;

    public function __construct(Application $app, AWS $aws)
    {
        $this->app = $app;
        $this->aws = $aws;
        parent::__construct();
    }

    protected function getArguments()
    {
        return array(
            array(self::INSTANCE_ID, InputArgument::REQUIRED, 'The EC2 instance ID where log files exist'),
            array(self::LOGFILE, InputArgument::REQUIRED, 'The location of the log file'),
        );
    }

    protected function getOptions()
    {
        $defaults = $this->app->make('config')->get('laravel-aws-ssh::ssh_defaults');

        return array(
            array(self::USER, InputOption::VALUE_OPTIONAL, 'The user for SSH', $defaults['default_user']),
            array(self::KEY_FILE, InputOption::VALUE_OPTIONAL, 'The location of the key file', $defaults['default_key_path']),
        );
    }

    public function fire()
    {
        $instanceId = $this->argument(self::INSTANCE_ID);
        $logFile = $this->argument(self::LOGFILE);

        $user = $this->option(self::USER);
        $keyFile = $this->option(self::KEY_FILE);

        $host = $this->aws->getPublicDNSFromInstanceId($instanceId);

        if(is_null($host)) {
            $this->error('Error: Could not find Host from Instance ID. Please try again.');
        } else {
            $connection = new Connection($instanceId, $host, $user, array(
                'key' => $keyFile,
                'keyphrase' => '',
            ));

            $connection->run(array(
               'tail -f ' . $logFile
            ), function($line) {
                $this->info($line);
            });
        }
    }


} 