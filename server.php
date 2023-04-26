<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //Error Code, Gender, Group by id, ID, parse through POST, Select, use AJAX, header
        $errors = array();
        $group = $_POST['user']['group'];
        $user = json_decode(file_get_contents('php://input'), true);

        if (empty($user['group'])) {
            $errors['group'] = 'Group field could not be empty.';
        }

        if (empty($user['firstName'])) {
            $errors['firstName'] = 'First name field could not be empty.';
        } 

        if (empty($user['lastName'])) {
            $errors['lastName'] = 'Last name field could not be empty';
        } 

        if (empty($user['gender'])) {
            $errors['gender'] = 'Gender field could not be empty.';
        }

        if (empty($user['birthday'])) {
            $errors['birthday'] = 'Birthday field could not be empty.';
        } 

        if ($errors) {
            echo json_encode(array('success' => false, 'errors' => $errors));
        } else {
            echo json_encode(array('success' => true, 'user' => $user));
        }
    }else {
        echo json_encode(array('success' => false, 'errors' => 'Invalid request method.'));
    }
?>