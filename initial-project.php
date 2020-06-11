<?php

use Alura\Pdo\Domain\Model\Student;

require_once 'vendor/autoload.php';

$student = new Student(
    null,
    'Vinicius Oliveira',
    new \DateTimeImmutable('2000-10-08')
);

echo $student->age();
