<?php namespace Atyagi\LaravelAwsSsh;

use TestCase;
use Mockery as m;

class ElasticBeanstalkTailCommandControllerTest extends TestCase {

    /** @var m\Mock */
    protected $mockAws;
    /** @var m\Mock */
    protected $mockCommand;
    /** @var m\Mock */
    protected $mockConnectionFactory;

    /** @var ElasticBeanstalkTailCommandController */
    protected $controller;

    public function setUp()
    {
        parent::setUp();
        $this->mockAws = m::mock('Atyagi\LaravelAwsSsh\Aws');
        $this->mockCommand = m::mock('Illuminate\Console\Command');
        $this->mockConnectionFactory = m::mock('Atyagi\LaravelAwsSsh\ConnectionFactory');

        $this->controller = new ElasticBeanstalkTailCommandController(
            $this->mockApp, $this->mockAws, $this->mockCommand, $this->mockConnectionFactory
        );
    }

    public function testFireWithEmptyHostsArrayCallsError()
    {
        list($arguments, $options) = $this->createArgumentsAndOptions();

        $this->setMockAwsExpectations($arguments, array());

        $this->mockCommand
            ->shouldReceive('error')
            ->with(m::type('string'))
            ->once();

        $this->controller->fire($arguments, $options);
    }

    public function testFireWithOneHostCallsInfoOnce()
    {
        list($arguments, $options) = $this->createArgumentsAndOptions();

        $mockConnection = m::mock('Illuminate\Remote\Connection');

        $mockConnection->shouldReceive('run')
            ->withAnyArgs()
            ->once();

        $this->setMockAwsExpectations($arguments, array('127.0.0.1'));

        $this->mockConnectionFactory
            ->shouldReceive('createConnection')
            ->withArgs(array(
                '127.0.0.1',
                '127.0.0.1',
                array_get($options, CommandRules::USER),
                array_get($options, CommandRules::KEY_FILE)
            ))
            ->andReturn($mockConnection)
            ->once();

        $this->controller->fire($arguments, $options);
    }

    public function testFireWithMultipleHostCallsInfoSameNumberOfTimes()
    {
        list($arguments, $options) = $this->createArgumentsAndOptions();

        $mockConnection = m::mock('Illuminate\Remote\Connection');
        $mockConnection->shouldReceive('run')
            ->withAnyArgs()
            ->twice();

        $this->setMockAwsExpectations($arguments, array('127.0.0.1', '127.0.0.2'));

        $this->mockConnectionFactory
            ->shouldReceive('createConnection')
            ->withAnyArgs()
            ->andReturn($mockConnection)
            ->twice();

        $this->controller->fire($arguments, $options);
    }


    /* ------ Private Test Helpers -------- */

    private function createArgumentsAndOptions()
    {
        return array(
            array(
                CommandRules::ENV => 'test-env',
                CommandRules::LOGFILE => 'test-file',
            ),
            array(
                CommandRules::USER => 'test-user',
                CommandRules::KEY_FILE => 'test-key',
            )
        );
    }

    private function setMockAwsExpectations($arguments, $returnArray)
    {
        $this->mockAws
            ->shouldReceive('getPublicDNSFromEBEnvironmentName')
            ->with(array_get($arguments, CommandRules::ENV))
            ->andReturn($returnArray)
            ->once();
    }

} 