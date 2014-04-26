<?php namespace Atyagi\LaravelAwsSsh\Commands;

use Atyagi\LaravelAwsSsh\AWS;
use Atyagi\LaravelAwsSsh\ConnectionManager;
use Atyagi\LaravelAwsSsh\EC2TailCommandController;
use Illuminate\Console\Command;
use Illuminate\Foundation\Application;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;


class EC2TailCommand extends Command {

    protected $name = 'ec2:tail';
    protected $description = 'Tails the logs of a specific EC2 Instance';

    const INSTANCE_ID = 'instanceId';
    const LOGFILE = 'logFile';
    const USER = 'user';
    const KEY_FILE = 'keyFile';

    /** @var Application */
    protected $app;

    /** @var AWS */
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
            array(self::LOGFILE, InputArgument::REQUIRED, 'The absolute path of the log file'),
        );
    }

    protected function getOptions()
    {
        $defaults = $this->app->make('config')->get('laravel-aws-ssh::ssh_defaults');

        return array(
            array(self::USER, 'u' ,InputOption::VALUE_OPTIONAL, 'The user for SSH', $defaults['default_user']),
            array(self::KEY_FILE, null, InputOption::VALUE_OPTIONAL, 'The location of the key file', $defaults['default_key_path']),
        );
    }

    public function fire()
    {
        $controller = new EC2TailCommandController($this->app, $this->aws,
            $this, new ConnectionManager());
        $controller->fire($this->argument(), $this->option());
    }


} 