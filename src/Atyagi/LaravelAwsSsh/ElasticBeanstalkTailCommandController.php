<?php namespace Atyagi\LaravelAwsSsh;

use Atyagi\LaravelAwsSsh\ConnectionFactory;
use Illuminate\Foundation\Application;
use Illuminate\Console\Command;

class ElasticBeanstalkTailCommandController {

    /** @var Application  */
    protected $app;

    /** @var AWS */
    protected $aws;

    /** @var Command */
    protected $command;

    /** @var ConnectionFactory */
    protected $connectionFactory;

    public function __construct(Application $app, AWS $aws, Command $command,
                                ConnectionFactory $connectionFactory)
    {
        $this->app = $app;
        $this->aws = $aws;
        $this->command = $command;
        $this->connectionFactory = $connectionFactory;
    }

    public function fire($arguments, $options)
    {
        $envName = array_get($arguments, CommandRules::ENV);
        $logFile = array_get($arguments, CommandRules::LOGFILE);

        $user = array_get($options, CommandRules::USER);
        $keyFile = array_get($options, CommandRules::KEY_FILE);

        $hosts = $this->aws->getPublicDNSFromEBEnvironmentName($envName);

        if(count($hosts) === 0) {
            $this->command->error('Error: Could not find instances associated with environment');
        } else {
            $connections = array();
            foreach($hosts as $host) {
                $connections[] = $this->connectionFactory->
                    createConnection($host, $host, $user, $keyFile);
            }
            foreach($connections as $connection) {
                $connection->run(array(
                   'tail -f ' . $logFile
                ), function($line) {
                    $this->command->info($line);
                });
            }
        }

    }

} 