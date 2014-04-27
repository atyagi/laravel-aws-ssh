<?php namespace Atyagi\LaravelAwsSsh;

use Atyagi\LaravelAwsSsh\Commands\EC2TailCommand;
use TestCase;
use Mockery as m;

class EC2TailCommandControllerTest extends TestCase {

    /** @var m\Mock */
    protected $mockAws;
    /** @var m\Mock */
    protected $mockCommand;
    /** @var m\Mock */
    protected $mockConnectionFactory;

    /** @var EC2TailCommandController */
    protected $controller;

    public function setUp()
    {
        parent::setUp();
        $this->mockAws = m::mock('Atyagi\LaravelAwsSsh\Aws');
        $this->mockCommand = m::mock('Illuminate\Console\Command');
        $this->mockConnectionFactory = m::mock('Atyagi\LaravelAwsSsh\ConnectionFactory');

        $this->controller = new EC2TailCommandController($this->mockApp, $this->mockAws,
                $this->mockCommand, $this->mockConnectionFactory);
    }

    public function testFireWithNullHostCallsError()
    {
        list($arguments, $options) = $this->createArgumentsAndOptions();

        $this->mockAws
            ->shouldReceive('getPublicDNSFromInstanceId')
            ->with(array_get($arguments, CommandRules::INSTANCE_ID))
            ->andReturnNull()
            ->once();

        $this->mockCommand
            ->shouldReceive('error')
            ->with(m::type('string'))
            ->once();

        $this->controller->fire($arguments, $options);
    }

    public function testFireWithValidHostCallsInfo()
    {
        list($arguments, $options) = $this->createArgumentsAndOptions();

        $mockConnection = m::mock('Illuminate\Remote\Connection');

        $mockConnection->shouldReceive('run')
            ->withAnyArgs()
            ->once();

        $this->mockAws
            ->shouldReceive('getPublicDNSFromInstanceId')
            ->with(array_get($arguments, CommandRules::INSTANCE_ID))
            ->andReturn('127.0.0.1')
            ->once();

        $this->mockConnectionFactory
            ->shouldReceive('createConnection')
            ->withArgs(array(
                array_get($arguments, CommandRules::INSTANCE_ID),
                '127.0.0.1',
                array_get($options, CommandRules::USER),
                array_get($options, CommandRules::KEY_FILE)
            ))
            ->andReturn($mockConnection)
            ->once();

        $this->controller->fire($arguments, $options);
    }


    /* ------ Private Test Helpers -------- */

    private function createArgumentsAndOptions()
    {
        return array(
            array(
                CommandRules::INSTANCE_ID => 'test-id',
                CommandRules::LOGFILE => 'test-file',
            ),
            array(
                CommandRules::USER => 'test-user',
                CommandRules::KEY_FILE => 'test-key',
            )
        );
    }


} 