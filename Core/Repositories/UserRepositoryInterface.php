<?php

namespace App\Core\Repositories;

use App\Core\Entities\User;

interface UserRepositoryInterface
{
    public function getById($id);

    public function getByName($name);

    public function getByEmail($email);

    public function save(User $user);

    public function delete($user);

    public function findByEmail(string $email);

    public function findByName(string $name);
}

