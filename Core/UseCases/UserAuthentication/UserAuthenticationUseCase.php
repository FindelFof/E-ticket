<?php

namespace App\Core\UseCases\UserAuthentication;

use App\Core\Entities\User;
use App\Core\Repositories\UserRepositoryInterface;
use App\Exceptions\InvalidCredentialsException;
use App\Exceptions\UserAlreadyExistsException;

class UserAuthenticationUseCase
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @throws InvalidCredentialsException
     *
     */

    public function authenticateUser(string $email, string $password): bool
    {
        $user = $this->userRepository->findByEmail($email);

        if (!$user || !password_verify($password, $user["password"])) {
            throw new InvalidCredentialsException('Invalid email or password');
        }    return true;
    }



    /**
     * @throws UserAlreadyExistsException
     * @throws \Exception
     */
    public function registerUser(string $name, string $email, string $password): User
    {
        $this->checkIfUserExistsByEmail($email);
        $this->checkIfUserExistsByName($name);

        $user = new User(null, $name, $email, $password);

        return $this->userRepository->save($user);
    }




    public function checkIfUserExistsByEmail(mixed $email): void
    {
        if ($this->userRepository->findByEmail($email)) {
            throw new UserAlreadyExistsException('User with this email already exists.');
        }
    }

    public function checkIfUserExistsByName(mixed $name): void
    {
        if ($this->userRepository->findByName($name)) {
            throw new UserAlreadyExistsException('User with this name already exists.');
        }
    }


}

