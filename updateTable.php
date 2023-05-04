<?php
    if($_SERVER['REQUEST_METHOD'] === 'GET'){
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

        $rows = $conn->query("SELECT * FROM students"); 

        if ($rows === false) {
            die("Connection failed: " . $conn->connect_error);
            header('HTTP/1.1 500 Internal Server Error');
            header('Content-Type: application/json');
            echo json_encode(array(
                'status' => true, 
                'errors' => 'Invalid request method.',
                'users' => null
            ));
        }  
           
        $users = array();
        foreach ($rows as $user) {
            array_push($users, $user);
        }

        header('HTTP/1.1 200 OK');
        header('Content-Type: application/json');
        echo json_encode(array(
            'status' => true, 
            'errors' => null,
            'users' => $users
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