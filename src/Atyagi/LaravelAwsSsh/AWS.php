<?php namespace Atyagi\LaravelAwsSsh;

use Aws\Common\Aws as ProvidedAWS;
use Illuminate\Foundation\Application;

class AWS {

    /**
     * @var \Aws\Common\Aws
     */
    protected $providedAws;

    public function __construct($accessKey, $secretKey, $region = 'us-east-1')
    {
        $this->accessKey = $accessKey;
        $this->secretKey = $secretKey;

        $this->providedAws = ProvidedAWS::factory(array(
            'key' => $accessKey,
            'secret' => $secretKey,
            'region' => $region,
        ));
    }

    public function getEc2InstanceIp($instanceId)
    {

    }



} 