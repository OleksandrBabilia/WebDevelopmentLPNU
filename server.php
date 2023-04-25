<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //HTTP Core, Gender, Group by id, ID
        $errors = array();

        $user = json_decode(file_get_contents('php://input'), true);

        if (empty($user['group'])) {
            $errors['group'] = 'Group field could not be empty.';
        }

        if (empty($user['firstName'])) {
            $errors['firstName'] = 'First name field could not be empty.';
        } elseif (!preg_match('/^[a-zA-Z]+$/', $user['firstName'])) {
            $errors['firstName'] = 'First name can only contain letters.';
        }

        if (empty($user['lastName'])) {
            $errors['lastName'] = 'Last name field could not be empty';
        } elseif (!preg_match('/^[a-zA-Z]+$/', $user['lastName'])) {
            $errors['lastName'] = 'Last name can only contain letters.';
        }

        if (empty($user['gender'])) {
            $errors['gender'] = 'Gender field could not be empty.';
        }

        if (empty($user['birthday'])) {
            $errors['birthday'] = 'Birthday field could not be empty.';
        } elseif (strtotime($user['birthday']) < strtotime('1950-01-01') || strtotime($user['birthday']) > strtotime('2005-01-01')) {
            $errors['birthday'] = 'Birthday must be from 1950 year up to 2005.';
        }

        if (count($errors) > 0) {
            echo json_encode(array('success' => false, 'errors' => $errors));
        } else {
            echo json_encode(array('success' => true, 'user' => $user));
        }
    }else {
        echo json_encode(array('success' => false, 'errors' => 'Invalid request method.'));
    }
?>