<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService
{
    protected $user_repository;

    public function __construct(UserRepository $user_repository)
    {
        return $this->user_repository = $user_repository;
    }

    public function all()
    {
        return $this->user_repository->getAll();
    }

    public function store($data)
    {
        return $this->user_repository->save($data);
    }

    public function show($id)
    {
        return $this->user_repository->show($id);
    }

    public function update($data, $id)
    {
        return $this->user_repository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->user_repository->delete($id);
    }
}
