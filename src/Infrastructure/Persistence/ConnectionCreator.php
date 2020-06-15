<?php

namespace Alura\Pdo\Infrastructure\Persistence;

use PDO;

class ConnectionCreator
{
    public static function createConnection(): PDO
    {
        $databsePath = __DIR__ . '/../../../banco.sqlite';
        return new PDO('sqlite:' . $databsePath);
    }
}