<?php namespace Atyagi\LaravelAwsSsh;

use Atyagi\LaravelAwsSsh\Commands\EC2TailCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class CommandRules {

    const INSTANCE_ID = 'instanceId';
    const LOGFILE = 'logFile';
    const USER = 'user';
    const KEY_FILE = 'keyFile';

    const APP = 'app';
    const ENV = 'env';

    public static function getEC2TailCommandArguments()
    {
        return array(
            array(self::INSTANCE_ID, InputArgument::REQUIRED,
                'The EC2 instance ID where log files exist'),
            array(self::LOGFILE, InputArgument::REQUIRED,
                'The absolute path of the log file'),
        );
    }

    public static function getEC2TailCommandOptions(array $defaults)
    {
        return array(
            array(self::USER, 'u', InputOption::VALUE_OPTIONAL,
                'The user for SSH', array_get($defaults, 'default_user')),
            array(self::KEY_FILE, null, InputOption::VALUE_OPTIONAL,
                'The location of the key file', array_get($defaults, 'default_key_path')),
        );
    }

    public static function getElasticBeanstalkTailCommandArguments()
    {
        return array(
            array(self::ENV, InputArgument::REQUIRED,
                'The ElasticBeanstalk Application Environment to tail'),
            array(self::LOGFILE, InputArgument::REQUIRED,
                'The absolute path of the log file'),
        );
    }

    public static function getElasticBeanstalkTailCommandOptions(array $defaults)
    {
        return static::getEC2TailCommandOptions($defaults);
    }

} 