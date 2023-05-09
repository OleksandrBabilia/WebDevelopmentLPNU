<?php
    function addStudent($conn, $user)
    {
        include 'constants.php';

        $query =
            "INSERT INTO students (uni_group, name, surname, gender, birthday, status) 
            VALUES ({$user['uni_group']}, '{$user['name']}', '{$user['surname']}', {$user['gender']}, '{$user['birthday']}', {$user['status']})";
       
                
        if ($conn->query($query) === false) {
            $user['id'] = $conn->insert_id;

            $response = array(
                'status' => false,
                'message' => 'Bad query',
                'errors' => 'Bad query: ' . $conn->error,
                'users' => $user
            );
        
            return $response;
        }

        $user['id'] = $conn->insert_id;
        
        $response = array(
            'status' => true,
            'message' => 'OK',
            'errors' => null,
            'users' => $user
        );
        return $response;
    }
?>