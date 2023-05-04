<?php
    if($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        include 'constants.php';

        $errors = array();
        $user = array(
            'id' => $_POST['id'],
            'name' => $_POST['firstName'],
            'surname' => $_POST['lastName'], 
            'status' => $_POST['status'],
            'gender' => $_POST['gender'],
            'birthday' => $_POST['birthday'],
            'uni_group' => $_POST['group']
        );
        
        if ($user['uni_group'] === "0") {
            $errors['group'] = 'Group field could not be empty.';
        }

        if (!$user['name']) {
            $errors['firstName'] = 'First name field could not be empty.';
        } 

        if (!$user['surname']) {
            $errors['lastName'] = 'Last name field could not be empty';
        } 

        if ($user['gender'] === "0") {
            $errors['gender'] = 'Gender field could not be empty.';
        }

        if (!$user['birthday']) {
            $errors['birthday'] = 'Birthday field could not be empty.';
        } 

        if (!$user['status']) {
            $errors['status'] = 'Status field could not be empty.';
        } 

        if ($errors) {
            header('HTTP/1.1 400 Bad Request');
            header('Content-Type: application/json');
            echo json_encode(array(
                'status' => false, 
                'errors' => 'Bad Request.',
                'users' => null
            ));
        } 
        else 
        {
            $conn = new MySQLi(HOSTNAME, USERNAME, PASSWORD, DATABASE);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
                header('HTTP/1.1 500 Internal Server Error');
                header('Content-Type: application/json');
                echo json_encode(array(
                    'status' => false, 
                    'errors' => 'Invalid request method.',
                    'users' => null
                ));
            }

            if($user['id']){
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
                    header('HTTP/1.1 500 Internal Server Error');
                    header('Content-Type: application/json');
                    echo json_encode(array(
                        'status' => false, 
                        'errors' =>  $query . " | " . $conn->error,
                        'users' => $user
                    ));
                }
            } else {
                $query =
                "INSERT INTO students (uni_group, name, surname, gender, birthday, status) 
                VALUES ({$user['uni_group']}, '{$user['name']}', '{$user['surname']}', {$user['gender']}, '{$user['birthday']}', {$user['status']})";
                $user['id'] = $conn->insert_id;
                
                if ($conn->query($query) === false) {
                    header('HTTP/1.1 500 Internal Server Error');
                    header('Content-Type: application/json');
                    echo json_encode(array(
                        'status' => false, 
                        'errors' => "Error: " . $sql . " | " . $conn->error,
                        'users' => $user
                    ));
                }
            }
             
            header('HTTP/1.1 200 OKI');
            header('Content-Type: application/json');
            echo json_encode(array(
                'status' => true, 
                'errors' => null,
                'users' => $user
            ));
            
            $conn->close();
        }
    } 
    else
    {
        header('HTTP/1.1 405 Method Not Allowed');
        header('Content-Type: application/json');
        echo json_encode(array(
            'status' => true, 
            'errors' => 'Invalid request method.',
            'users' => null
        ));
    }   
?>