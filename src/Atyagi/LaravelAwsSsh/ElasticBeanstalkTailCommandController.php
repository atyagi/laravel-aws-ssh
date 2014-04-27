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

    public function __construct(Application $app, AWS $aws, Command $command,
                                ConnectionManager $connectionManager)
    {
        $this->app = $app;
        $this->aws = $aws;
        $this->command = $command;
        $this->connectionManager = $connectionManager;
    }

    public function fire($arguments, $options)
    {
        $envName = array_get($arguments, CommandRules::ENV);
        $logFile = array_get($arguments, CommandRules::LOGFILE);

        $user = array_get($options, CommandRules::USER);
        $keyFile = array_get($options, CommandRules::KEY_FILE);

        $host = $this->aws->getPublicDNSFromEBEnvironmentName($envName);

        if(is_null($host)) {
            $this->command->error('Error: Could not find instances associated with environment');
        } else {

        }

    }

} 