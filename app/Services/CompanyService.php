<?php

namespace App\Services;

use App\Repositories\CompanyRepository;

class CompanyService
{
    protected $company_repository;

    public function __construct(CompanyRepository $company_repository)
    {
        return $this->company_repository = $company_repository;
    }

    public function all()
    {
        return $this->company_repository->getAll();
    }

    public function createCompany($data)
    {
        return $this->company_repository->save($data);
    }

    public function show($id)
    {
        return $this->company_repository->show($id);
    }

    public function update($data, $id)
    {
        return $this->company_repository->update($data, $id);
    }

    public function deleteCompany($id)
    {
        return $this->company_repository->delete($id);
    }
}
