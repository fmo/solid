<?php

/**
 * "There should never be more than one reason for a class to change."[5] In other words, every class should have only one responsibility."
 *  - Wikipedia
 */

namespace Fmo\Solid\Breach;

// Breaching Single Responsibility Principle
class User {
    public function __construct(private string $email, private string $password)
    {
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
}
class UserRepository {
    private array $users = [];

    public function save(User $user): void
    {
        $this->users[] = $user;
    }

    public function getUsers(): array
    {
        return $this->users;
    }

    public function hashPassword(string $password): string
    {
        return  password_hash($password, PASSWORD_DEFAULT);
    }
}
class Register {
    public function save(): void
    {
        $email = "example@example.com";
        $password = "example-pass";

        $userRepository = new UserRepository();
        $hashedPassword = $userRepository->hashPassword($password);
        $userRepository->save((new User($email, $hashedPassword)));
    }
}

// Fixing Single Responsibility Principle

namespace Fmo\Solid\Fix;

use Fmo\Solid\Breach\User;

class UserRepository {
    private array $users = [];

    public function save(User $user): void
    {
        $this->users[] = $user;
    }

    public function getUsers(): array
    {
        return $this->users;
    }
}

interface HashPassword {
    public static function hash(string $password): String;
}

class DefaultHashPassword implements HashPassword  {
    public static function hash(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}

class Register {
    public function save($email, $password): void
    {
        $userRepository = new UserRepository();
        $userRepository->save((new User($email, DefaultHashPassword::hash($password))));

        var_dump($userRepository->getUsers());
    }
}

(new Register())
    ->save("example@example.com", "example-pass");
