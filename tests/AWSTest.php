<?php namespace Atyagi\LaravelAwsSsh;

use Guzzle\Service\Resource\Model as GuzzleModel;
use TestCase;
use Mockery as m;

class AWSTest extends TestCase {

    protected $mockProvidedAws;
    protected $mockEc2;

    /**
     * @var AWS
     */
    protected $aws;

    public function setUp()
    {
        parent::setUp();

        $this->mockEc2 = m::mock('Aws\Ec2\Ec2Client');

        $this->mockProvidedAws = m::mock('Aws\Common\Aws');
        $this->mockProvidedAws
            ->shouldReceive('get')
            ->with('ec2')
            ->andReturn($this->mockEc2);

        $this->aws = new AWS($this->mockProvidedAws);
    }

    public function testGetPublicDNSFromInstanceIdReturnsString()
    {
        $this->setExpectationsForMockEc2(array(
            'Reservations' => array(
                0 => array(
                    'Instances' => array(
                        0 => array(
                            'PublicDnsName' => '127.0.0.1'
                        )
                    )
                )
            )
        ));
        $dns = $this->aws->getPublicDNSFromInstanceId('test-id');
        $this->assertEquals('127.0.0.1', $dns);
    }

    public function testGetPublicDNSFromInstanceIdReturnsNullWithEmptyArray()
    {
        $this->setExpectationsForMockEc2(array());
        $dns = $this->aws->getPublicDNSFromInstanceId('test-id');
        $this->assertNull($dns);
    }

    public function testGetPublicDNSFromInstanceIdReturnsNullWithEmptyReservations()
    {
        $this->setExpectationsForMockEc2(array(
            'Reservations' => array()
        ));
        $dns = $this->aws->getPublicDNSFromInstanceId('test-id');
        $this->assertNull($dns);
    }

    public function testGetPublicDNSFromInstanceIdReturnsNullWithEmptyInstances()
    {
        $this->setExpectationsForMockEc2(array(
            'Reservations' => array(
                0 => array(
                   'Instances' => array()
                )
            )
        ));
        $dns = $this->aws->getPublicDNSFromInstanceId('test-id');
        $this->assertNull($dns);
    }

    private function setExpectationsForMockEc2($array)
    {
        $this->mockEc2->shouldReceive('describeInstances')
            ->withAnyArgs()
            ->andReturn(new GuzzleModel($array));
    }

} 