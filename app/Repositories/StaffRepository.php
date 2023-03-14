<?php

namespace App\Repositories;

use App\Models\Staff;

class  StaffRepository
{
    protected $staff;

    public function __construct(Staff $staff)
    {
        $this->staff = $staff;
    }

    public function getAll()
    {
        $staff = $this->staff;

        $user =  auth()->user()->load(['company']);

        if ($user->role && $user->role->slug == 'company') {
            if (!empty($user->company)) {
                $staff = $staff->where('company_id', $user->company->id);
            } else
                return false;
        }

        $staff = $staff->get();

        return $staff;
    }

    public function save($data)
    {
        $staff = $this->staff->create($data);

        return $staff;
    }

    public function show($id)
    {
        $staff = $this->staff;

        $user =  auth()->user()->load(['company']);

        if ($user->role && $user->role->slug == 'company') {
            if (!empty($user->company)) {
                $staff->where('company_id', $user->company->id);
            } else return false;
        }

        return $staff->find($id);
    }

    public function update($data, $id)
    {
        $staff = $this->staff->find($id);

        $user =  auth()->user()->load(['company']);

        if ($user->role && $user->role->slug == 'company') {
            if (!empty($user->company) && $staff->company_id == $user->company->id)
                return  $staff->update($data);
            else return false;
        }

        return  $staff->update($data);
    }

    public function delete($id)
    {
        $staff = $this->staff->find($id);

        $user =  auth()->user()->load(['company']);

        if ($user->role && $user->role->slug == 'company') {
            if (!empty($user->company) && $staff->company_id == $user->company->id)
                return $staff->destroy();
            else return false;
        }
        return $staff->destroy();
    }
}
