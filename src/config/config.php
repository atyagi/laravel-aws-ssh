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
    | Defaults for SSH
    |--------------------------------------------------------------------------
    |
    | Default info for SSH commands
    |
    */
    'ssh_defaults' => array(
        'default_user' => '',
        'default_key_path' => '',
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

);
 