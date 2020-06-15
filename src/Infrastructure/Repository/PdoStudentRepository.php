<?php

namespace Alura\Pdo\Infrastructure\Repository;

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Domain\Repository\StudentRepository;
use PDO;

class PdoStudentRepository implements StudentRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function allStudents(): array
    {
        $selectQuery = 'SELECT * FROM students;';
        $pstmt = $this->connection->query($selectQuery);

        return $this->hydrateStudentList($pstmt);
    }

    public function birthDateAt(\DateTimeImmutable $birthDate): array
    {
        $selectQuery = 'SELECT * FROM students WHERE birth_date = ?;';
        $pstmt = $this->connection->prepare($selectQuery);
        $pstmt->bindValue(1, $birthDate->format('Y-m-d'));
        $pstmt->execute();

        return $this->hydrateStudentList($pstmt);

    }

    public function hydrateStudentList(\PDOStatement $pstmt): array
    {
        $studentDataList = $pstmt->fetchAll(PDO::FETCH_ASSOC);
        $studentList = [];

        foreach($studentDataList as $studentData){
            $studentList = new Student(
                $studentData['id'],
                $studentData['name'],
                new \DateTimeImmutable($studentData['birthDate'])
            );
        }

        return $studentList;
    }

    public function save(Student $student): bool
    {
        if($student->id() === null){
            return $this->insert($student);
        }

        return $this->update($student);
    }

    public function remove(Student $student): bool
    {
        $pstmt = $this->connection->prepare('DELETE FROM students WHERE id = ?;');
        $pstmt->bindValue(1, $student->id(), PDO::PARAM_INT);

        return $pstmt->execute();
    }

    public function insert(Student $student): bool
    {
        $insertQuery = 'INSERT INTO students (name, birth_date) VALUES (:name, :birth_date);';
        $pstmt = $this->connection->prepare($insertQuery);

        $sucess = $pstmt->execute([
            ':name' => $student->name(),
            ':brith_date' => $student->birthDate()->format('Y-m-d'),
        ]);

        if($sucess){
            $student->setId($this->connection->lastInsertId());
        }

        return $sucess;
    }

    public function update(Student $student)
    {
        $updateQuery = 'UPDATE students SET name = :name, brith_date = :birth_date WHERE id = :id;';
        $pstmt = $this->connection->prepare($updateQuery);
        $pstmt->bindValue(':name', $student->name());
        $pstmt->bindValue(':birth_date', $student->birthDate()->format('Y-m-d'));
        $pstmt->bindValue(':id', $student->id(), PDO::PARAM_INT);

        return $pstmt->execute();
    }
}