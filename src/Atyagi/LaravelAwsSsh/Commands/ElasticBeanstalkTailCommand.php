<?php namespace Atyagi\LaravelAwsSsh\Commands;

use Atyagi\LaravelAwsSsh\AWS;
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
        return array(
            array('app', InputArgument::REQUIRED, 'The ElasticBeanstalk Application to tail'),
            array('env', InputArgument::REQUIRED, 'The application\'s environment to tail'),
        );
    }

    public function fire()
    {
        $arguments = $this->argument();

        if(isset($arguments['app']) && isset($arguments['env'])) {

        } else {
            $this->error('Error: app and env are not set. Please set them');
        }


    }




} 