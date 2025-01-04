<?php
require_once __DIR__ . '/dao.php';

class task
{
    public int $id;
    public string $description;
    public int $estimate;
    public ?int $assignedTo;
    public bool $completed;

    public function __construct(int $id, string $description, int $estimate, ?int $assignedTo = null, ?bool $completed = false)
    {
        $this->id = $id;
        $this->description = $description;
        $this->estimate = $estimate;
        $this->assignedTo = $assignedTo;
        $this->completed = $completed;
    }

    public function isCompleted(): string
    {
        if ($this->completed) {
            return "completed";
        }
        return "not completed";
    }

    public function getAssignedToName($assignedTo): string {
        if (is_null($assignedTo)) {
            return 'unassigned';
        }
        return $this->fetchUserNameById($assignedTo);
    }

    private function fetchUserNameById($userId): string {
        $dao = new Dao();
        $employee = $dao->getEmployee($userId);
        return $employee ? $employee->firstName . " " .$employee->lastName: 'unassigned';
    }
}