<?php namespace Atyagi\LaravelAwsSsh;

use Illuminate\Foundation\Application;
use Illuminate\Console\Command;

class ElasticBeanstalkTailCommandController {

    /** @var Application  */
    protected $app;

    /** @var AWS */
    protected $aws;

    /** @var Command */
    protected $command;

    protected $connectionManager;

    public function __construct(Application $app, AWS $aws, Command $command, ConnectionManager $connectionManager)
    {
        $this->app = $app;
        $this->aws = $aws;
        $this->command = $command;
        $this->connectionManager = $connectionManager;
    }

} 