<?php

namespace App\Core\Repositories;


use App\Models\User as Usermodel;
use App\Core\Entities\User;

class UserRepository implements UserRepositoryInterface
{

    public function getById($id)
    {
        return Usermodel::find($id);
    }
    public function getByName($name)
    {
        return Usermodel::where('$name', $name)->first();
    }
    public function getByEmail($email)
    {
        return Usermodel::where('email', $email)->first();
    }


    public function save(User $user): User
    {
        $userData = [
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword()
        ];

        $model = UserModel::create($userData);

        return new User($model->id, $model->name, $model->email, $model->password);
    }


    public function delete($user)
    {
        $model = Usermodel::find($user->getId());
        if ($model) {
            $model->delete();
        }
    }

    public function findByEmail(string $email)
    {
        // TODO: Implement findByEmail() method.
        return Usermodel::where('email', $email)->first();
    }

    public function findByName(string $name)
    {
        // TODO: Implement findByName() method.
        return Usermodel::where('name', $name)->first();
    }

}
