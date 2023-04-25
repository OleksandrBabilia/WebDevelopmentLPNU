<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $errors = array();

        $data = json_decode(file_get_contents('php://input'), true);

        if (empty($data['group'])) {
            $errors['group'] = 'Group field could not be empty.';
        }

        if (empty($data['firstName'])) {
            $errors['firstName'] = 'First name field could not be empty.';
        } elseif (!preg_match('/^[a-zA-Z]+$/', $data['firstName'])) {
            $errors['firstName'] = 'First name can only contain letters.';
        }

        if (empty($data['lastName'])) {
            $errors['lastName'] = 'Last name field could not be empty';
        } elseif (!preg_match('/^[a-zA-Z]+$/', $data['lastName'])) {
            $errors['lastName'] = 'Last name can only contain letters.';
        }

        if (empty($data['gender'])) {
            $errors['gender'] = 'Gender field could not be empty.';
        }

        if (empty($data['birthday'])) {
            $errors['birthday'] = 'Birthday field could not be empty.';
        } elseif (strtotime($data['birthday']) < strtotime('1950-01-01') || strtotime($data['birthday']) > strtotime('2005-01-01')) {
            $errors['birthday'] = 'Birthday must be from 1950 year up to 2005.';
        }

        if (count($errors) > 0) {
            echo json_encode(array('success' => false, 'errors' => $errors));
        } else {
            echo json_encode(array('success' => true, 'data' => $data));
        }
    }else {
        echo json_encode(array('success' => false, 'errors' => 'Invalid request method.'));
    }
?>