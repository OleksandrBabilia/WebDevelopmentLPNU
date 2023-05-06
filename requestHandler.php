<?php
    include 'constants.php';
    include 'validateData.php';
    include 'updateStudent.php';
    include 'addStudent.php';
    include 'deleteStudent.php';
    include 'getStudent.php';

    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['action'])) {
        header('HTTP/1.1 405 Method Not Allowed');
        header('Content-Type: application/json');
        echo json_encode(array(
            'status' => false, 
            'message' => 'Invalid request method.',
            'errors' => 'Invalid request method.',
            'users' => null
        ));
        exit();
    }
    $validatedUser;
    if (($_POST['action'] === 'CREATE' || $_POST['action'] === 'UPDATE')) {

        $validatedUser = validate($_POST['users']);

        if ($validatedUser['status'] !== true) {
            header('HTTP/1.1 400 Bad Request');
            header('Content-Type: application/json');
            echo json_encode($validatedUser);
            exit();
        }
        
    }
    
    $conn = new MySQLi(HOSTNAME, USERNAME, PASSWORD, DATABASE);

    if ($conn->connect_error) {
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json');
        echo json_encode(array(
            'status' => false, 
            'message' => 'Connection failed',
            'errors' => 'Connection failed: ' . $conn->connect_error,
            'users' => null
        ));
        exit();
    }

    $response;
    switch ($_POST['action']) {   
        case 'CREATE': 
            $response = addStudent($conn, $validatedUser['users']);
            break;
        case 'READ':
            $response = getStudents($conn);
            break;
        case 'UPDATE':
            $response = updateStudent($conn, $validatedUser['users']);
            break;
        case 'DELETE':
            $response = deleteStudent($conn, $_POST['id']);
            break;
        default:
            header('HTTP/1.1 500 Internal Server Error');
            header('Content-Type: application/json');
            echo json_encode(array(
                'status' => false,  
                'message' => 'Bad Action',
                'errors' => 'Bad Action not allowed: ' . $_POST['action'],
                'users' => null
            ));
            exit();
    }
    
    if ($response['status'] === false) {
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }
    
    header('HTTP/1.1 200 OK');
    header('Content-Type: application/json');
    echo json_encode($response);
?>