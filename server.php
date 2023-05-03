<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //Error Code, Gender, Group by id, ID, parse through POST, Select, use AJAX, header
        $errors = array();
        $user = array(
            'id' => $_POST['id'],
            'firstName' => $_POST['firstName'],
            'lastName' => $_POST['lastName'], 
            'gender' => $_POST['gender'],
            'birthday' => $_POST['birthday'],
            'group' => $_POST['group']
        );

        if ($user['group'] === "0") {
            $errors['group'] = 'Group field could not be empty.';
        }

        if (!$user['firstName']) {
            $errors['firstName'] = 'First name field could not be empty.';
        } 

        if (!$user['lastName']) {
            $errors['lastName'] = 'Last name field could not be empty';
        } 

        if ($user['gender'] === "0") {
            $errors['gender'] = 'Gender field could not be empty.';
        }

        if (!$user['birthday']) {
            $errors['birthday'] = 'Birthday field could not be empty.';
        } 

        if ($errors) {
            header('HTTP/1.1 400 Bad Request');
            header('Content-Type: application/json');
            echo json_encode(array('errors' => $errors));
        } else {
            header('HTTP/1.1 200 OK');
            header('Content-Type: application/json');
            echo json_encode(array('success' => true, 'user' => $user, 'errors' => null));
        }
    }else {
        header('HTTP/1.1 405 Method Not Allowed');
        header('Content-Type: application/json');
        echo json_encode(array('errors' => 'Invalid request method.'));
    }
?>