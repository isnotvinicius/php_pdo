<?php

use Alura\Pdo\Domain\Model\Student;

require 'vendor/autoload.php';

$databsePath = __DIR__ . '/banco.sqlite';
$pdo = new PDO('sqlite:' . $databsePath);

$student = new Student(null, 'Vinicius Oliveira', new DateTimeImmutable('2000-10-08'));

$sqlInsert = "INSERT INTO students(name, birth_date) VALUES('{$student->name()}', '{$student->birthDate()->format('Y-m-d')}');";

$pdo->exec($sqlInsert);

