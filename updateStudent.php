<?php
    function updateStudent($conn, $user)
    {
        include 'constants.php';

        $query =
            "UPDATE students
            SET 
                uni_group = {$user['uni_group']}, 
                name = '{$user['name']}', 
                surname = '{$user['surname']}', 
                gender = {$user['gender']}, 
                birthday = '{$user['birthday']}', 
                status = {$user['status']}
            WHERE id = {$user['id']}";
                
        if ($conn->query($query) === false) {
            $response = array(
                'status' => false,
                'message' => 'Bad query',
                'errors' => 'Bad query: ' . $conn->error,
                'users' => $user
            );
        
            return $response;
        }

        $response = array(
            'status' => true,
            'message' => 'OK',
            'errors' => null,
            'users' => $user
        );
        return $response;
    }
?>