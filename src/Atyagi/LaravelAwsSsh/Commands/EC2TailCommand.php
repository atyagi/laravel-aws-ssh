<?php namespace Atyagi\LaravelAwsSsh\Commands;

use Atyagi\LaravelAwsSsh\AWS;
use Illuminate\Console\Command;
use Illuminate\Foundation\Application;

class EC2TailCommand extends Command {

    protected $name = 'ec2:tail';
    protected $description = 'Tails the logs of a specific EC2 Instance';

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
            array('instance', InputArgument::REQUIRED, 'The EC2 instance where log files exist'),
            array('logFile', InputArgument::REQUIRED, 'The location of the log file'),
        );
    }

    public function fire()
    {

    }


} 