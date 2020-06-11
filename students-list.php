<?php

use Alura\Pdo\Domain\Model\Student;

require 'vendor/autoload.php';

$databsePath = __DIR__ . '/banco.sqlite';
$pdo = new PDO('sqlite:' . $databsePath);

$statement = $pdo->query('SELECT * FROM students');

$studentDataList = $statement->fetchAll(PDO::FETCH_ASSOC);

$studentList = [];

foreach($studentDataList as $studentData){
    $studentList[] = new Student(
        $studentData['id'],
        $studentData['name'],
        new DateTimeImmutable($studentData['birth_date'])
    );
}


