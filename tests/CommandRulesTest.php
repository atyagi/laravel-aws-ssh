<?php namespace Atyagi\LaravelAwsSsh;

use Atyagi\LaravelAwsSsh\Commands\EC2TailCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use TestCase;

class CommandRulesTest extends TestCase {

    public function testEC2TailCommandArguments()
    {
        $args = CommandRules::getEC2TailCommandArguments();

        $this->assertEquals(CommandRules::INSTANCE_ID, $args[0][0]);
        $this->assertEquals(InputArgument::REQUIRED, $args[0][1]);
        $this->assertEquals(CommandRules::LOGFILE, $args[1][0]);
        $this->assertEquals(InputArgument::REQUIRED, $args[1][1]);
    }

    public function testEC2TailCommandOptions()
    {
        $defaults = array(
            'default_user' => 'test-user',
            'default_key_path' => 'test-path',
        );

        $options = CommandRules::getEC2TailCommandOptions($defaults);

        $this->assertEquals(CommandRules::USER, $options[0][0]);
        $this->assertEquals('u', $options[0][1]);
        $this->assertEquals(InputOption::VALUE_OPTIONAL, $options[0][2]);
        $this->assertEquals($defaults['default_user'], $options[0][4]);

        $this->assertEquals(CommandRules::KEY_FILE, $options[1][0]);
        $this->assertNull($options[1][1]);
        $this->assertEquals(InputOption::VALUE_OPTIONAL, $options[1][2]);
        $this->assertEquals($defaults['default_key_path'], $options[1][4]);
    }

} 