<?php

global $data;
require_once __DIR__ . '/dao.php';
require_once __DIR__ . '/task.php';
require_once __DIR__ . '/employee.php';
require_once __DIR__ . '/ex7/Request.php';
require_once __DIR__ . '/ex7/vendor/tpl.php';


$request = new Request($_REQUEST);
$dao = new Dao();

$cmd = $request->param('cmd') ?: 'dashboard-page';

if ($cmd === 'dashboard-page') {
    $data = [
        'page' => 'dashboard-page',
        'content' => 'dashboard.html',
        'message' => $request->param('message') ?? null,
        'employees' => (new dao())->getAllEmployees(),
        'tasks' => (new dao())->getAllTasks()
    ];
} else if ($cmd === 'employee-list') {
    $data = [
        'page' => 'employee-list-page',
        'content' => 'employee-list.html',
        'message' => $request->param('message') ?? null,
        'employees' => (new dao())->getAllEmployees()
    ];
} else if ($cmd === 'task-list') {

    $data = [
        'page' => 'task-list-page',
        'content' => 'task-list.html',
        'message' => $request->param('message') ?? null,
        'tasks' => $dao->getAllTasks(),
    ];
} else if ($cmd === 'task-form' || $cmd === 'task-add-submit') {

    $id = intval($request->param('id') ?? 0);
    $employeeId = intval($request->param('employeeId')) ?? null;
    $description = $request->param('description') ?? '';
    $estimate = intval($request->param('estimate') ?? 1);
    $completed = boolval($request->param('completed') ?? false);
    $error = null;

    if ($cmd === 'task-add-submit') {
        if (strlen($description) < 5 || strlen($description) > 40) {
            $error = "Description must be between 5-40 characters!";
        } else {
            if ($request->param('deleteButton'))
                $message = $dao->deleteTask($id);
            else

            $message = $dao->saveTask($id, $description, $estimate, $employeeId, $completed);
            header("Location: ?cmd=task-list&message=$message)");
            exit();
        }
    } else if ($id) {
        $task = $dao->getTask($id);
        $description = $task->description;
        $estimate = $task->estimate;
        $employeeId = $task->assignedTo;
        $completed = $task->completed;
    }

    $data = [
        'id' => $id,
        'description' => $description,
        'estimate' => $estimate,
        'employeeId' => $employeeId,
        'completed' => $completed,
        'error' => $error,
        'allEmployees' => $dao->getAllEmployees(),
        'content' => 'task-form.html',
        'page' => 'task-form-page'
    ];
} else if ($cmd === 'employee-form' || $cmd === 'employee-add-submit') {

    $id = intval($request->param('id') ?? 0);
    $firstName = $request->param('firstName') ?? '';
    $lastName = $request->param('lastName') ?? '';
    $position = $request->param('position') ?? '';
    $picture = $request->param('picture') ?? '';
    $error = null;

    if ($cmd === 'employee-add-submit') {
        if (strlen($firstName) < 1 || strlen($firstName) > 21) {
            $error = "First name must be 1-21 characters long and contain only letters!";
        } else if (strlen($lastName) < 2 || strlen($lastName) > 22) {
            $error = "Last name must be 2-22 characters long and contain only letters!";
        } else {
            if ($request->param('deleteButton')) {
                $message = $dao->deleteEmployee($id);
            } elseif ($id) {
                $message = $dao->updateEmployee($id, $firstName, $lastName, $position, $picture);
            } else {
                $message = $dao->saveEmployee($firstName, $lastName, $position, $picture);
            }
            header("Location: ?cmd=employee-list&message=$message");
            exit();
        }
    } else if ($id) {
        $employee = $dao->getEmployee($id);
        $firstName = $employee->firstName;
        $lastName = $employee->lastName;
        $position = $employee->position;
        $picture = $employee->picture;
    }

    $data = [
        'id' => $id,
        'firstName' => $firstName,
        'lastName' => $lastName,
        'position' => $position,
        'picture' => $picture,
        'error' => $error,
        'content' => 'employee-form.html',
        'page' => 'employee-form-page'
    ];

}

print renderTemplate('main.html', $data);
