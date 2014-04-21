<?php

use Mockery as m;

class TestCase extends PHPUnit_Framework_TestCase {

    protected $mockApp;

    public function setUp()
    {
        $this->mockApp = m::mock('Illuminate\Foundation\Application');
    }

    public function tearDown()
    {
        m::close();
    }

} 