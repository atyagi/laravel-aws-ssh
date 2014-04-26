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
    protected $mockConnectionManager;

    /** @var EC2TailCommandController */
    protected $controller;

    public function setUp()
    {
        parent::setUp();
        $this->mockAws = m::mock('Atyagi\LaravelAwsSsh\Aws');
        $this->mockCommand = m::mock('Illuminate\Console\Command');
        $this->mockConnectionManager = m::mock('Atyagi\LaravelAwsSsh\ConnectionManager');

        $this->controller = new EC2TailCommandController($this->mockApp, $this->mockAws,
                $this->mockCommand, $this->mockConnectionManager);
    }

    public function testFireWithNullHostCallsError()
    {
        list($arguments, $options) = $this->createArgumentsAndOptions();

        $this->mockAws
            ->shouldReceive('getPublicDNSFromInstanceId')
            ->with(array_get($arguments, EC2TailCommand::INSTANCE_ID))
            ->andReturnNull();

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
            ->with(array_get($arguments, EC2TailCommand::INSTANCE_ID))
            ->andReturn('127.0.0.1');

        $this->mockConnectionManager
            ->shouldReceive('createConnection')
            ->withArgs(array(
                array_get($arguments, EC2TailCommand::INSTANCE_ID),
                '127.0.0.1',
                array_get($options, EC2TailCommand::USER),
                array_get($options, EC2TailCommand::KEY_FILE)
            ))
            ->andReturn($mockConnection);

        $this->controller->fire($arguments, $options);
    }

    private function createArgumentsAndOptions()
    {
        return array(
            array(
                EC2TailCommand::INSTANCE_ID => 'test-id',
                EC2TailCommand::LOGFILE => 'test-file',
            ),
            array(
                EC2TailCommand::USER => 'test-user',
                EC2TailCommand::KEY_FILE => 'test-key',
            )
        );
    }


} 