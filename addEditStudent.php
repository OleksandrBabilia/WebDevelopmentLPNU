<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' ) 
    {
            include 'constants.php';
            include 'validateData.php';

            $user = array(
                'id' => $_POST['id'],
                'name' => $_POST['name'],
                'surname' => $_POST['surname'], 
                'gender_id' => $_POST['gender_id'],
                'birthday' => $_POST['birthday'],
                'group_id' => $_POST['group_id'],
                'status' => $_POST['status']
            );
            
            $validatedUser = validate($user);
            
            if ($validatedUser['status'] === false) {
                header('HTTP/1.1 400 Bad Request');
                header('Content-Type: application/json');
                echo json_encode(array(
                    'status' => $validatedUser['status'],
                    'message' => $validatedUser['message'],
                    'errors' => $validatedUser['errors'],
                    'users' => $validatedUser['user'],
                    ));
                exit();
            }

            $query =
                "INSERT INTO students (group_id, name, surname, gender_id, birthday, status) 
                VALUES ({$validatedUser['user']['group_id']}, '{$validatedUser['user']['name']}', '{$validatedUser['user']['surname']}', {$validatedUser['user']['gender_id']}, '{$validatedUser['user']['birthday']}', {$validatedUser['user']['status']})";
           
           if ($validatedUser['user']['id']) {
                $query =
                "UPDATE students
                SET 
                    group_id = {$validatedUser['user']['group_id']}, 
                    name = '{$validatedUser['user']['name']}', 
                    surname = '{$validatedUser['user']['surname']}', 
                    gender_id = {$validatedUser['user']['gender_id']}, 
                    birthday = '{$validatedUser['user']['birthday']}', 
                    status = {$validatedUser['user']['status']}
                WHERE id = {$validatedUser['user']['id']}";
                
            } 
            
            $validatedUser['user']['group_id'] = $groups_arr[$validatedUser['user']['group_id']];
            $validatedUser['user']['gender_id'] = $genders_arr[$validatedUser['user']['gender_id']];

            if ($conn->query($query) === false) {
                header('HTTP/1.1 500 Internal Server Error');
                header('Content-Type: application/json');
                echo json_encode( array(
                    'status' => false,
                    'message' => 'Bad query',
                    'errors' => 'Bad query: ' . $conn->error,
                    'users' => $validatedUser
                ));
                exit();
            }

            if (!$validatedUser['user']['id'])
                $validatedUser['user']['id'] = $conn->insert_id;

            header('HTTP/1.1 200 OK');
            header('Content-Type: application/json');
            echo json_encode(array(
                'status' => true,
                'message' => 'OK',
                'errors' => null,
                'user' => $validatedUser['user']
            ));
    } else {
        header('HTTP/1.1 405 Method Not Allowed');
        header('Content-Type: application/json');
        echo json_encode(array(
            'status' => false, 
            'message' => 'Invalid request method.',
            'errors' => 'Invalid request method.',
            'users' => null
        ));
    }
?>