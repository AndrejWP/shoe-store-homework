<?php

class User
{
    private static function filePath(): string
    {
        return __DIR__ . '/../data/users.json';
    }

    public static function all(): array
    {
        $file = self::filePath();

        if (!file_exists($file) || filesize($file) === 0) {
            return [];
        }

        $users = json_decode(file_get_contents($file), true);

        return is_array($users) ? $users : [];
    }

    private static function save(array $users): void
    {
        file_put_contents(
            self::filePath(),
            json_encode(array_values($users), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
        );
    }

    public static function findById(int $id): ?array
    {
        foreach (self::all() as $user) {
            if ((int)$user['id'] === $id) {
                return $user;
            }
        }

        return null;
    }

    public static function findByEmail(string $email): ?array
    {
        foreach (self::all() as $user) {
            if (strtolower($user['email']) === strtolower($email)) {
                return $user;
            }
        }

        return null;
    }

    public static function create(string $name, string $email, string $password): array
    {
        $users = self::all();
        $ids = array_column($users, 'id');
        $nextId = empty($ids) ? 1 : max($ids) + 1;

        $user = [
            'id' => $nextId,
            'name' => $name,
            'email' => $email,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT)
        ];

        $users[] = $user;
        self::save($users);

        return $user;
    }

    public static function changePassword(int $id, string $password): ?array
    {
        $users = self::all();

        foreach ($users as $index => $user) {
            if ((int)$user['id'] === $id) {
                $users[$index]['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
                self::save($users);

                return $users[$index];
            }
        }

        return null;
    }

    public static function delete(int $id): bool
    {
        $users = self::all();
        $newUsers = array_filter($users, fn($user) => (int)$user['id'] !== $id);

        if (count($users) === count($newUsers)) {
            return false;
        }

        self::save($newUsers);

        return true;
    }

    public static function publicData(array $user): array
    {
        return [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email']
        ];
    }
}
