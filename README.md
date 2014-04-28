Laravel AWS SSH
==========
[![Build Status](https://travis-ci.org/atyagi/laravel-aws-ssh.svg)](https://travis-ci.org/atyagi/laravel-aws-ssh)
[![Coverage Status](https://coveralls.io/repos/atyagi/laravel-aws-ssh/badge.png)](https://coveralls.io/r/atyagi/laravel-aws-ssh)

Laravel AWS SSH Client for Log Tailing and Other using Instance ID's and Elastic Beanstalk Applications Names/Environments.

## Purpose
I found a need to want to SSH and tail logs from my EC2 Instances and Elastic Beanstalk Applications. I figured this would be an easier way to do so when working within a Laravel project thanks to Laravel 4.1 and the remoting functionality.

## Long Term Goals
Eventually I'll create a SSH-type Facade that allows for being able to SSH into EC2 instances (or Elastic Beanstalk instances) and run commands through it.

## Installation

With composer, simply add `"atyagi/laravel-aws-ssh": "dev-master"` to your composer.json.

Once `composer update` is ran, add

`'Atyagi\LaravelAwsSsh\Providers\LaravelAwsSshServiceProvider',`

to the providers array in `app/config.php`.

At this point, you should see `eb:tail` and `ec2:tail` available for use.

### Versions
- dev-master -- Stable release version
- dev-dev -- Generally stable, but still the main development branch
- tags -- see Packagist (https://packagist.org/packages/atyagi/laravel-aws-ssh) for specific tagged versions. Most releases to master get tagged.

## Usage

Run Artisan commands as follows:

### Elastic Beanstalk

For tailing Elastic Beanstalk environments logs:

`php artisan eb:tail [-u|--user[="..."]] [--keyFile[="..."]] env logFile`

where:
- `u` is the user to SSH as (defaults to config value)
- `keyFile` is the key file location (defaults to key path value in config)
- `env` is the Environment name
- `logFile` is the absolute path of the log file location

### EC2

For tailing logs on EC2 Instances:

`php artisan ec2:tail [-u|--user[="..."]] [--keyFile[="..."]] instanceId logFile`

where:
- `u` is the user to SSH as (defaults to config value)
- `keyFile` is the key file location (defaults to key path value in config)
- `instanceId` is the EC2 Instance ID
- `logFile` is the absolute path of the log file location

## Configuration

```
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
        'access_key' => '',   //AWS Access Key
        'secret_key' => '',   //AWS Secret Key
        'region' => '',       //AWS Region to use in querying
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
        'default_user' => '',       //Default SSH User
        'default_key_path' => '',   //Default SSH Key Path
    ),
```

