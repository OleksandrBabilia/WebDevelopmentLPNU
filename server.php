<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $errors = array();

        $data = json_decode(file_get_contents('php://input'), true);

        if (empty($data['group'])) {
            $errors['group'] = 'Group is required !';
        }

        if (empty($data['firstName'])) {
            $errors['firstName'] = 'First name is required !';
        } elseif (!preg_match('/^[a-zA-Z]+$/', $data['firstName'])) {
            $errors['firstName'] = 'First name can only contain letters';
        }

        if (empty($data['lastName'])) {
            $errors['lastName'] = 'Last name is required !';
        } elseif (!preg_match('/^[a-zA-Z]+$/', $data['lastName'])) {
            $errors['lastName'] = 'Last name can only contain letters';
        }

        if (empty($data['gender'])) {
            $errors['gender'] = 'Gender is required !';
        }

        if (empty($data['birthday'])) {
            $errors['birthday'] = 'Birthday is required !';
        } elseif (strtotime($data['birthday']) < strtotime('1920-01-01') || strtotime($data['birthday']) > strtotime('2007-01-01')) {
            $errors['birthday'] = 'Birday must be from 1920 year up to 2007 !';
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