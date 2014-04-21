<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | AWS Credentials
    |--------------------------------------------------------------------------
    |
    | AWS Access Key, Secret Key, and Region.
    | Note that 'us-east-1' will be used if none is provided
    |
    */
    'aws' => array(
        'access_key' => '',
        'secret_key' => '',
        'region' => '',
    ),

    /*
	|--------------------------------------------------------------------------
	| AWS Elastic Beanstalk Applications
	|--------------------------------------------------------------------------
	|
    | These are the Elastic Beanstalk applications that you will use to connect
    | and tail from the backing EC2 instances
    |
    | Example:
    | 'applications' => array(
    |     '<EB_APP_NAME> => array(
    |         '[ENVIRONMENT_NAMES]
    |     )
    | )
    |
	*/
    'applications' => array(

    ),

    /*
    |--------------------------------------------------------------------------
    | Default Key Path
    |--------------------------------------------------------------------------
    |
    | Location of a default SSH Key
    |
    */
    'default_key_path' => ''



);
 