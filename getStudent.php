<?php
    function getStudents($conn)
    {
        $rows = $conn->query("SELECT * FROM students"); 

        if ($rows === false) {
            $response = array(
                'status' => false,
                'message' => 'Bad query',
                'errors' => 'Bad query: ' . $conn->error,
                'users' => null
                
            );
            return $response;
        }  
           
        $users = array();
        foreach ($rows as $user) {
            array_push($users, $user);
        }

        $response = array(
            'status' => true,
            'message' => 'OK',
            'errors' => null,
            'users' => $users
            
        );
        return $response;
    } 
?>