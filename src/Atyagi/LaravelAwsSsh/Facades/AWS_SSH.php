<?php namespace Atyagi\LaravelAwsSsh\Facades;

use Illuminate\Support\Facades\Facade;

class AWS_SSH extends Facade {

    protected static function getFacadeAccessor() { return 'aws_ssh'; }

} 