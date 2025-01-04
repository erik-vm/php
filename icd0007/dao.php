<?php

require_once __DIR__ . '/employee.php';
require_once __DIR__ . '/task.php';
require_once __DIR__ . '/ex6/connection.php';

class Dao
{
    private PDO $connection;

    public function __construct()
    {
        $this->connection = getConnection();
    }

    // Employee related functions
    public function saveEmployee(string $firstName, string $lastName, string $position, string $picture): string
    {
        try {
            $firstName = urldecode($firstName);
            $lastName = urldecode($lastName);

            $statement = $this->connection->prepare(
                'INSERT INTO employee (first_name, last_name, position, picture)
                     VALUES (?, ?, ?, ?)'
            );
            $statement->execute([
                $firstName,
                $lastName,
                $position,
                $picture
            ]);
            return "Saved!";

        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function getLastInsertedID(): int
    {
        return $this->connection->lastInsertId();
    }


    public function updateEmployee(int $employeeId, string $firstName, string $lastName, string $position, string $picture): string
    {
        try {
            $firstName = urldecode($firstName);
            $lastName = urldecode($lastName);

            $statement = $this->connection->prepare(
                'UPDATE employee 
                     SET first_name = ?, last_name = ?, position = ?, picture = ?
                     WHERE employee_id = ?'
            );
            $statement->execute([
                $firstName,
                $lastName,
                $position,
                $picture,
                $employeeId
            ]);
            return "Updated!";

        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }


    public function deleteEmployee(int $employeeId): string
    {
        try {
            $statement = $this->connection->prepare('DELETE FROM employee WHERE employee_id = ?');
            $statement->execute([$employeeId]);
            return 'Deleted!';
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }
//    public function deleteEmployee(employee $employee): string
//    {
//        $id = $employee->id;
//        try {
//            $statement = $this->connection->prepare('DELETE FROM employee WHERE employee_id = ?');
//            $statement->execute([$id]);
//            return 'Deleted!';
//        } catch (PDOException $e) {
//            return "Error: " . $e->getMessage();
//        }
//    }

    public function getEmployee(int $employeeId): ?Employee
    {
        try {
            $statement = $this->connection->prepare('SELECT * FROM employee WHERE employee_id = ?');
            $statement->execute([$employeeId]);
            $item = $statement->fetch(PDO::FETCH_ASSOC);

            if ($item) {
                return new Employee($item['employee_id'], $item['first_name'], $item['last_name'], $item['position'], $item['picture']);
            }
            return null;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function getAllEmployees(): array
    {
        try {
            if (!$this->connection) {
                error_log("Database connection failed.");
                return []; // Early return on connection issues
            }

            $statement = $this->connection->query('SELECT * FROM employee ORDER BY employee_id DESC');
            $statement->execute();
            $items = $statement->fetchAll(PDO::FETCH_ASSOC); // Fetch associative array

            // If no items are found, $items will be an empty array
            $result = [];
            foreach ($items as $item) {
                $result[] = new Employee($item['employee_id'], $item['first_name'], $item['last_name'], $item['position'], $item['picture']);
            }
            return $result; // Return empty array if no employees
        } catch (PDOException $e) {
            error_log("Error fetching employees: " . $e->getMessage());
            return [];
        }
    }

//    public function getAllEmployees() {
//        // Sample database fetch logic
//        // Ensure it returns an array even if empty
//        $results = $this->connection->query("SELECT * FROM employee");
//        return $results->fetchAll(PDO::FETCH_OBJ) ?: []; // Returns empty array if null
//    }

    // Task related functions
    public function saveTask(int $taskId, string $description, int $estimate, int $assignedTo, bool $completed): string
    {
        try {
            if ($taskId) {
                $statement = $this->connection->prepare(
                    'UPDATE task 
                     SET description = :description, estimate = :estimate, assigned_to = :assigned_to, completed = :completed
                     WHERE task_id = :task_id'
                );
                $statement->execute([
                    ':task_id' => $taskId,
                    ':description' => $description,
                    ':estimate' => $estimate,
                    ':assigned_to' => $assignedTo,
                    ':completed' => intval($completed)
                ]);
                return "Updated!";
            } else {
                $statement = $this->connection->prepare(
                    'INSERT INTO task (description, estimate, assigned_to, completed)
                     VALUES (:description, :estimate, :assigned_to, :completed)'
                );
                $statement->execute([
                    ':description' => $description,
                    ':estimate' => $estimate,
                    ':assigned_to' => $assignedTo,
                    ':completed' => intval($completed)
                ]);
                return "Saved!";
            }
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function deleteTask(int $taskId): string
    {
        try {
            $statement = $this->connection->prepare('DELETE FROM task WHERE task_id = :task_id');
            $statement->execute([':task_id' => $taskId]);
            return "Deleted!";
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function getTask(int $taskId): ?Task
    {
        try {
            $statement = $this->connection->prepare('SELECT * FROM task WHERE task_id = :task_id');
            $statement->execute([':task_id' => $taskId]);
            $item = $statement->fetch(PDO::FETCH_ASSOC);

            if ($item) {
                return new Task($item['task_id'], $item['description'], $item['estimate'], $item['assigned_to'], $item['completed']);
            }
            return null;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function getAllTasks(): array
    {
        try {
            $statement = $this->connection->prepare('SELECT * FROM task');
            $statement->execute();
            $items = $statement->fetchAll(PDO::FETCH_ASSOC);

            $result = [];
            foreach ($items as $item) {
                $result[] = new Task($item['task_id'], $item['description'], $item['estimate'], $item['assigned_to'], $item['completed']);
            }
            return $result;
        } catch (PDOException $e) {
            return [];
        }
    }
}
