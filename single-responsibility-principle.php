<?php

/**
 * "There should never be more than one reason for a class to change."[5] In other words, every class should have only one responsibility."
 *  - Wikipedia
 */

// Breaching Single Responsibility Principle

namespace Fmo\Solid\Breach;

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

    public function getUsers(): array
    {
        return $this->users;
    }

    public function save(User $user): void
    {
        $this->users[] = $user;
    }

    public function hashPassword(string $password): string
    {
        return  password_hash($password, PASSWORD_DEFAULT);
    }
}
class Register {
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }
    public function __invoke(): void
    {
        $email = "";
        $password = "example-pass";

        $hashedPassword = $this->userRepository->hashPassword($password);
        $this->userRepository->save(
            (new User($email, $hashedPassword))
        );
    }
}

// Fixing Single Responsibility Principle

namespace Fmo\Solid\Fix;

use Fmo\Solid\Breach\User;

class UserRepository {
    private array $users = [];

    public function getUsers(): array
    {
        return $this->users;
    }

    public function save(User $user): void
    {
        $this->users[] = $user;
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

class Register
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function save($email, $password): void
    {
        $this->userRepository->save(
            (new User($email, DefaultHashPassword::hash($password)))
        );

        var_dump($this->userRepository->getUsers());
    }
}

(new Register())
    ->save("example@example.com", "example-pass");
