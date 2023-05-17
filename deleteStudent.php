<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' ) 
    {
        include 'constants.php';
        $query = "DELETE FROM students WHERE id = {$_POST['id']}";
        if ($conn->query($query) === false) {
            header('HTTP/1.1 500 Internal Server Error');
            header('Content-Type: application/json');
            echo json_encode( array(
                'status' => false,
                'message' => 'Bad query',
                'errors' => 'Bad query: ' . $conn->error,
                'user' => var_dump($_POST)
            ));
            exit();
        }
        header('HTTP/1.1 200 OK');
        header('Content-Type: application/json');
        echo json_encode(array(
            'status' => true,
            'message' => 'OK',
            'errors' => null,
            'user' => $_POST['id']
        ));
    } else {
        header('HTTP/1.1 405 Method Not Allowed');
        header('Content-Type: application/json');
        echo json_encode(array(
            'status' => false, 
            'message' => 'Invalid request method.',
            'errors' => 'Invalid request method.',
            'user' => null
        ));
    }
?>