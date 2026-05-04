<?php

require __DIR__ . '/../models/User.php';

class UserController
{
    public function send(array $data, int $code = 200): void
    {
        http_response_code($code);
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    public function register(array $input): void
    {
        $name = trim($input['name'] ?? '');
        $email = trim($input['email'] ?? '');
        $password = $input['password'] ?? '';

        if ($name === '' || $email === '' || trim($password) === '') {
            $this->send([
                'status' => 'error',
                'message' => 'Заполните name, email и password'
            ], 400);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->send([
                'status' => 'error',
                'message' => 'Некорректный email'
            ], 400);
        }

        if (strlen($password) < 6) {
            $this->send([
                'status' => 'error',
                'message' => 'Пароль должен быть не короче 6 символов'
            ], 400);
        }

        if (User::findByEmail($email) !== null) {
            $this->send([
                'status' => 'error',
                'message' => 'Пользователь с таким email уже существует'
            ], 409);
        }

        $user = User::create($name, $email, $password);

        $this->send([
            'status' => 'success',
            'message' => 'Пользователь зарегистрирован',
            'user' => User::publicData($user)
        ], 201);
    }

    public function login(array $input): void
    {
        $email = trim($input['email'] ?? '');
        $password = $input['password'] ?? '';

        if ($email === '' || trim($password) === '') {
            $this->send([
                'status' => 'error',
                'message' => 'Заполните email и password'
            ], 400);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->send([
                'status' => 'error',
                'message' => 'Некорректный email'
            ], 400);
        }

        $user = User::findByEmail($email);

        if ($user === null) {
            $this->send([
                'status' => 'error',
                'message' => 'Пользователь не найден'
            ], 404);
        }

        if (!password_verify($password, $user['password_hash'])) {
            $this->send([
                'status' => 'error',
                'message' => 'Неверный пароль'
            ], 401);
        }

        $this->send([
            'status' => 'success',
            'message' => 'Авторизация выполнена',
            'user' => User::publicData($user)
        ]);
    }

    public function getAll(): void
    {
        $users = array_map(fn($user) => User::publicData($user), User::all());

        $this->send([
            'status' => 'success',
            'users' => $users
        ]);
    }

    public function getOne(int $id): void
    {
        $user = User::findById($id);

        if ($user === null) {
            $this->send([
                'status' => 'error',
                'message' => 'Пользователь не найден'
            ], 404);
        }

        $this->send([
            'status' => 'success',
            'user' => User::publicData($user)
        ]);
    }

    public function changePassword(int $id, array $input): void
    {
        if (User::findById($id) === null) {
            $this->send([
                'status' => 'error',
                'message' => 'Пользователь не найден'
            ], 404);
        }

        $password = $input['password'] ?? $input['new_password'] ?? '';

        if (trim($password) === '') {
            $this->send([
                'status' => 'error',
                'message' => 'Введите новый пароль'
            ], 400);
        }

        if (strlen($password) < 6) {
            $this->send([
                'status' => 'error',
                'message' => 'Пароль должен быть не короче 6 символов'
            ], 400);
        }

        $user = User::changePassword($id, $password);

        $this->send([
            'status' => 'success',
            'message' => 'Пароль изменён',
            'user' => User::publicData($user)
        ]);
    }

    public function delete(int $id): void
    {
        if (!User::delete($id)) {
            $this->send([
                'status' => 'error',
                'message' => 'Пользователь не найден'
            ], 404);
        }

        $this->send([
            'status' => 'success',
            'message' => 'Пользователь удалён'
        ]);
    }
}
