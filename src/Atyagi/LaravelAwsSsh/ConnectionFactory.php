<?php namespace Atyagi\LaravelAwsSsh;

use Illuminate\Remote\Connection;

class ConnectionFactory {

    public function createConnection($instanceId, $host, $user, $keyFile)
    {
        return new Connection($instanceId, $host, $user, array(
            'key' => $keyFile,
            'keyphrase' => '',
        ));
    }

} 