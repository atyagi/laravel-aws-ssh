<?php namespace Atyagi\LaravelAwsSsh;

use Atyagi\LaravelAwsSsh\Commands\EC2TailCommand;
use Illuminate\Foundation\Application;
use Illuminate\Console\Command;

class EC2TailCommandController {

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

    public function fire($arguments, $options)
    {
        $instanceId = array_get($arguments, CommandRules::INSTANCE_ID);
        $logFile = array_get($arguments, CommandRules::LOGFILE);

        $user = array_get($options, CommandRules::USER);
        $keyFile = array_get($options, CommandRules::KEY_FILE);

        $host = $this->aws->getPublicDNSFromInstanceId($instanceId);

        if(is_null($host)) {
           $this->command->error('Error: Could not find Host from Instance ID. Please try again.');
        } else {
            $connection = $this->connectionManager->
                createConnection($instanceId, $host, $user, $keyFile);

            $connection->run(array(
                'tail -f ' . $logFile
            ), function($line) {
                $this->command->info($line);
            });
        }
    }

} 