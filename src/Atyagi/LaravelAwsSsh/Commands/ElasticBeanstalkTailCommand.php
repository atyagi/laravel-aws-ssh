<?php namespace Atyagi\LaravelAwsSsh\Commands;

use Atyagi\LaravelAwsSsh\AWS;
use Atyagi\LaravelAwsSsh\CommandRules;
use Atyagi\LaravelAwsSsh\ConnectionManager;
use Atyagi\LaravelAwsSsh\ElasticBeanstalkTailCommandController;
use Illuminate\Console\Command;
use Illuminate\Foundation\Application;
use Symfony\Component\Console\Input\InputArgument;

class ElasticBeanstalkTailCommand extends Command {

    protected $name = 'eb:tail';
    protected $description = 'Tails the logs of a specific Elastic Beanstalk environment';

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
        return CommandRules::getElasticBeanstalkTailCommandArguments();
    }

    protected function getOptions()
    {
        return CommandRules::getElasticBeanstalkTailCommandOptions();
    }

    public function fire()
    {
        $controller = new ElasticBeanstalkTailCommandController($this->app, $this->aws,
            $this, new ConnectionManager());
        $controller->fire($this->argument(), $this->option());
    }




} 