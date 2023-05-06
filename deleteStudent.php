<?php
    function deleteStudent($conn, $id)
    {
        include 'constants.php';
        $query = "DELETE FROM students WHERE id = {$id}";
        if ($conn->query($query) === false) {
            //die("Connection failedd: " . $conn->connect_error);
            $response = array(
                'status' => false,
                'message' => 'Bad query',
                'errors' => 'Bad query: ' . $query. $conn->error,
                'users' => $id 
            );
            return $response;
        } 

        $response = array(
            'status' => true,
            'message' => 'OK',
            'errors' => null,
            'users' => $id
            
        );
        return $response;
    }  
?>