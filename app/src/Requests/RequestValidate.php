<?php

namespace Mod\Crm\Requests;

class RequestValidate
{
    private array $errors = [];

    public function validateData($data):void
    {
        if (empty($data['username'])) {
            $errors['username'] = 'Username is required';
        } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $data['username'])) {
            $errors['username'] = 'Username must contain only letters, numbers, and underscores';
        }
        if (empty($data['email'])) {
            $errors['email'] = 'Email is required';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format';
        }
        if (empty($data['password'])) {
            $errors['password'] = 'Password is required';
        } elseif (strlen($data['password']) < 8) {
            $errors['password'] = 'Password must be at least 8 characters long';
        }
//        if (empty($data['message'])) {
//            $errors['message'] = 'Message is required';
//        }
    }

    public function printError() {
        foreach ($this->errors as $field => $error) {
            echo "$field: $error\n";
        }
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}