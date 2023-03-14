<?php

namespace App\Repositories;

use App\Models\User;

class  UserRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getAll()
    {
        return $this->user->get();
    }

    public function save($data)
    {
        $user = $this->user->create($data);

        return $user;
    }

    public function show($id)
    {
        $user = $this->user->find($id);

        return $user;
    }

    public function update($data, $id)
    {
        $user = $this->user->find($id);

        $user = $user->update($data);

        return $user;
    }

    public function delete($id)
    {
        $user = $this->user->find($id);

        return $user->destroy();
    }
}
