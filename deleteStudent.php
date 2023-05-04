<?php
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        include 'constants.php';

        $conn = new MySQLi(HOSTNAME, USERNAME, PASSWORD, DATABASE);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
            header('HTTP/1.1 500 Internal Server Error');
            header('Content-Type: application/json');
            echo json_encode(array(
                'status' => true, 
                'errors' => 'Invalid request method.',
                'users' => null
            ));
        }

        if ($conn->query("DELETE FROM students WHERE id = {$_POST['id']}") === false) {
            die("Connection failed: " . $conn->connect_error);
            header('HTTP/1.1 500 Internal Server Error');
            header('Content-Type: application/json');
            echo json_encode(array(
                'status' => true, 
                'errors' => 'Invalid request method.',
                'users' => null
            ));
        } 

        header('HTTP/1.1 200 OK');
        header('Content-Type: application/json');
        echo json_encode(array(
            'status' => true, 
            'errors' => null,
            'users' => $_POST['id']
        ));
        
        $conn->close();
    } else{
        header('HTTP/1.1 405 Method Not Allowed');
        header('Content-Type: application/json');
        echo json_encode(array(
            'status' => true, 
            'errors' => 'Invalid request method.',
            'users' => null
        ));
    }   
?>