<?php
    function  validate($user)
    {
        $errors = array();

        if ($user['group_id'] === "0") {
            $errors['uni_group'] = 'Group field could not be empty.';
        }

        if (!$user['name']) {
            $errors['name'] = 'First name field could not be empty.';
        } 

        if (!$user['surname']) {
            $errors['surname'] = 'Last name field could not be empty';
        } 

        if ($user['gender_id'] === "0") {
            $errors['gender'] = 'Gender field could not be empty.';
        }

        if (!$user['birthday']) {
            $errors['birthday'] = 'Birthday field could not be empty.';
        } 

        if (!$user['status']) {
            $errors['status'] = 'Status field could not be empty.';
        } 

        $response = array(
            'status' => (empty($errors)) ? true : false,
            'message' => (empty($errors)) ? 'OK' : 'Bad Request',
            'errors' => (empty($errors)) ? null : $errors,
            'user' => $user
        );

        return $response;
    }
?>