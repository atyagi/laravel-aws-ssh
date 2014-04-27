<?php namespace Atyagi\LaravelAwsSsh\Commands;

use Atyagi\LaravelAwsSsh\AWS;
use Atyagi\LaravelAwsSsh\CommandRules;
use Atyagi\LaravelAwsSsh\ConnectionFactory;
use Atyagi\LaravelAwsSsh\EC2TailCommandController;
use Illuminate\Console\Command;
use Illuminate\Foundation\Application;

class EC2TailCommand extends Command {

    protected $name = 'ec2:tail';
    protected $description = 'Tails the logs of a specific EC2 Instance';

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
        return CommandRules::getEC2TailCommandArguments();
    }

    protected function getOptions()
    {
        $defaults = $this->app->make('config')->get('laravel-aws-ssh::ssh_defaults');
        return CommandRules::getEC2TailCommandOptions($defaults);
    }

    public function fire()
    {
        $controller = new EC2TailCommandController($this->app, $this->aws,
            $this, new ConnectionFactory());
        $controller->fire($this->argument(), $this->option());
    }


} 