<?php

declare(strict_types=1);

namespace Mod\Crm\Requests;

class UserRequest extends RequestValidate
{
    private array $data = [
        'username',
        'email',
        'password',
        'message'
    ];

    private array $form = [];

    public function prepareForm(): array
    {
        foreach ($this->data as $value) {
            $this->form[$value] = (isset($_POST[$value])) ? $_POST[$value] : NULL;
        }

        return $this->form;
    }

    public function get(string $key): string
    {
        if (isset($this->form[$key])) {
            return $this->form[$key];
        }

        return '';
    }
}