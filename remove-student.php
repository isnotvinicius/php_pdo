<?php

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;

require 'vendor/autoload.php';

$pdo = ConnectionCreator::createConnection();

$pstmt = $pdo->prepare($sqlDelete = 'DELETE FROM students WHERE id = ?;');
$pstmt->bindValue(1, 3, PDO::PARAM_INT);
var_dump($pstmt->execute());


