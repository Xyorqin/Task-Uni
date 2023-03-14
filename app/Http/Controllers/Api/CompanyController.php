<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Services\CompanyService;
use Exception;
use Illuminate\Http\Request;

class CompanyController extends Controller
{

    protected $service;

    public function __construct(CompanyService $company_service)
    {
        $this->middleware('role:company')->only(['show', 'update']);
        $this->middleware('role:admin')->except(['show', 'update']);
        $this->service = $company_service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = $this->service->all();

        return $result ? response()->successJson($result) : response()->errorJson('Object not found', 404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {
        $params = $request->validated();
        $result = $this->service->createCompany($params);

        return $result ? response()->successJson($result) : response()->errorJson('Error', 422);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = $this->service->show($id);

        return $result ? response()->successJson($result) : response()->errorJson('Company not found', 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyRequest $request, $id)
    {
        $params = $request->validated();

        $result = $this->service->update($params, $id);

        return $result ? response()->successJson($result) : response()->errorJson('Error', 422);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->service->deleteCompany($id);

        return $result ? response()->successJson('Successfully deleted') : response()->errorJson('Object not found', 404);
    }
}
