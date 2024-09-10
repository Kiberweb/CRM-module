<?php

declare(strict_types=1);

namespace Mod\Crm\Controllers;

use Mod\Crm\Requests\UserRequest;
use Mod\Crm\Actions\HashPassAction;
use RedBeanPHP\R;

class UserController extends BaseController
{
    public function index()
    {
        return R::getAll('SELECT id, username, email, message FROM users');
    }
    public function store(): string
    {
        $form = new UserRequest();
        $form->validateData($form->prepareForm());

        if (empty($form->getErrors())) {
            $user = R::dispense('users');
            $user->username = $form->get('username');
            $user->email = $form->get('email');
            $user->password = HashPassAction::handler($form->get('password'));
            $user->message = $form->get('message') ?? '';
            $user->created_at = R::isoDateTime();

            $id = R::store($user);

            return '{"status": 200, "user_Id": ' . $id . '}';
        }

        return json_encode(['status' => 404, 'errors' => $form->getErrors()]);
    }

    public function update(int $id): string
    {
            $form = new UserRequest();
            $form->prepareForm();
            $password = $form->get('password');

            $user = R::load('users', $id);

            if ($user->id) {
                if (!empty($password)) {
                    $user->password = HashPassAction::handler($password);
                }

                R::store($user);

                return '{"status": 200, "userId": ' . $id . '}';
            }

            return '{"status": 404}';
    }

    public function delete(int $id): bool
    {
        $user = R::load('users', $id);

        if ($user->id) {
            R::trash($user);
            return true;
        }

        return false;
    }
}