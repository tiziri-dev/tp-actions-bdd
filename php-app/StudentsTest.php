<?php
require_once __DIR__ . '/Students.php';

use PHPUnit\Framework\TestCase;

class StudentsTest extends TestCase
{
    private $students;

    protected function setUp(): void
    {
        $this->students = new Students();
        $pdo = new PDO("pgsql:host=127.0.0.1;dbname=tp", "postgres", "postgres");
        $pdo->exec("TRUNCATE TABLE students RESTART IDENTITY");
    }

    public function testAjouterEtLire()
    {
        $this->students->addStudent("Alice", 15);
        $student = $this->students->getStudent("Alice");
        $this->assertNotNull($student);
        $this->assertEquals("Alice", $student['name']);
        $this->assertEquals(15, (float)$student['grade']);
    }

    public function testEtudiantInconnu()
    {
        $student = $this->students->getStudent("Inconnu");
        $this->assertNull($student);
    }

    public function testMoyenne()
    {
        $this->students->addStudent("Amel", 10);
        $this->students->addStudent("Karim", 14);
        $this->assertEquals(12.0, $this->students->averageGrade());
    }
}