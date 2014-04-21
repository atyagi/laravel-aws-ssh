<?php namespace Atyagi\LaravelAwsSsh;

use Atyagi\LaravelAwsSsh\Commands\EC2TailCommand;
use TestCase;
use Mockery as m;

class EC2TailCommandTest extends TestCase {

    protected $ec2TailCommand;
    protected $mockAws;
    protected $mockConfig;

    public function setUp()
    {
        parent::setUp();
//        $this->mockConfig = m::mock('config');
//        $this->mockConfig->shouldReceive('get')
//            ->with('laravel-aws-ssh::ssh_defaults')
//            ->andReturn(array(
//                'default_user' => 'ec2-user',
//                'default_key_path' => '/usr/test'
//            ));
//
//        $this->mockApp->shouldReceive('make')
//            ->with('config')
//            ->andReturn($this->mockConfig);
//
//        $this->mockAws = m::mock('Atyagi\LaravelAwsSsh\AWS');
//        $this->ec2TailCommand = m::mock(new EC2TailCommand($this->mockApp, $this->mockAws));
    }

    public function testFireWithNullHostErrors()
    {
//        $this->mockAws->shouldReceive('getPublicDNSFromInstanceId')
//            ->withAnyArgs()
//            ->andReturnNull();
//        $this->ec2TailCommand->shouldExpect('error')->once();
    }


} 