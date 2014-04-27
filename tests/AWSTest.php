<?php namespace Atyagi\LaravelAwsSsh;

use Guzzle\Service\Resource\Model as GuzzleModel;
use TestCase;
use Mockery as m;

class AWSTest extends TestCase {

    /** @var m\Mock */
    protected $mockProvidedAws;
    /** @var m\Mock */
    protected $mockEc2;

    /** @var AWS */
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

    public function testGetPublicDNSFromEBNameReturnsOneInstance()
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
        $dnsArray = $this->aws->getPublicDNSFromEBEnvironmentName('test-id');
        $this->assertCount(1, $dnsArray);
        $this->assertEquals('127.0.0.1', $dnsArray[0]);
    }

    public function testGetPublicDNSFromEBNameReturnsMultipleInstances()
    {
        $this->setExpectationsForMockEc2(array(
            'Reservations' => array(
                0 => array(
                    'Instances' => array(
                        0 => array(
                            'PublicDnsName' => '127.0.0.1'
                        )
                    )
                ),
                1 => array(
                    'Instances' => array(
                        0 => array(
                            'PublicDnsName' => '127.0.0.2'
                        )
                    )
                ),
            )
        ));
        $dnsArray = $this->aws->getPublicDNSFromEBEnvironmentName('test-id');
        $this->assertCount(2, $dnsArray);
        $this->assertEquals('127.0.0.1', $dnsArray[0]);
        $this->assertEquals('127.0.0.2', $dnsArray[1]);
    }

    public function testGetPublicDNSFromEBNameReturnsNullWithEmptyArray()
    {
        $this->setExpectationsForMockEc2(array());
        $dnsArray = $this->aws->getPublicDNSFromEBEnvironmentName('test-id');
        $this->assertEmpty($dnsArray);
    }

    public function testGetPublicDNSFromEBNameReturnsNullWithEmptyReservations()
    {
        $this->setExpectationsForMockEc2(array(
            'Reservations' => array()
        ));
        $dnsArray = $this->aws->getPublicDNSFromEBEnvironmentName('test-id');
        $this->assertEmpty($dnsArray);
    }

    public function testGetPublicDNSFromEBNameReturnsNullWithEmptyInstances()
    {
        $this->setExpectationsForMockEc2(array(
            'Reservations' => array(
                0 => array(
                    'Instances' => array()
                )
            )
        ));
        $dnsArray = $this->aws->getPublicDNSFromEBEnvironmentName('test-id');
        $this->assertEmpty($dnsArray);
    }

    /* ------ Private Test Helpers -------- */

    private function setExpectationsForMockEc2($array)
    {
        $this->mockEc2->shouldReceive('describeInstances')
            ->withAnyArgs()
            ->andReturn(new GuzzleModel($array))
            ->once();
    }

} 