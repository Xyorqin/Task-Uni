<?php

namespace App\Services;

use App\Repositories\StaffRepository;

class StaffService
{
    protected $staff_repository;

    public function __construct(StaffRepository $staff_repository)
    {
        return $this->staff_repository = $staff_repository;
    }

    public function all()
    {
        return $this->staff_repository->getAll();
    }

    public function store($data)
    {
        return $this->staff_repository->save($data);
    }

    public function show($id)
    {
        return $this->staff_repository->show($id);
    }

    public function update($data, $id)
    {
        return $this->staff_repository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->staff_repository->delete($id);
    }
}
