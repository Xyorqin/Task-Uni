<?php

namespace App\Repositories;

use App\Models\Company;
use App\Models\Role;
use App\Models\User;

class  CompanyRepository
{
    protected $company;

    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    public function getAll()
    {
        return $this->company->get();
    }

    public function save($data)
    {
        if (!$role = Role::where('slug', 'company')->first()) return false;

        $user = new User();

        $user->name         = $data['name'];
        $user->phone_number = $data['phone_number'];
        $user->password     = bcrypt($data['password']);
        $user->role_id      = $role->id;
        $user->save();

        $data['user_id'] = $user->id;

        $company = $this->company->create($data);

        return $company;
    }

    public function show($id)
    {
        $company = $this->company->find($id);

        if (auth()->user()->role->slug == 'company') {
            if ($company->id != auth()->user()->id)
                return false;
        }
        return $company;
    }

    public function update($data, $id)
    {
        $company = $this->company->find($id);
        $id = auth()->id();

        if (auth()->user()->role()->slug == 'company') {
            if ($id != $company->user_id) return false;
        }

        $user = User::find($company->user_id)->update([
            'name'          =>  $data['name'],
            'phone_number'  =>  $data['phone_number'],
            'password'      =>  bcrypt($data['password'])
        ]);

        $company = $company->update($data);

        return $company;
    }

    public function delete($id)
    {
        $company = $this->company->find($id);

        return $company->delete();
    }
}
