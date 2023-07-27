<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Repository\User\UserRepositoryInterface;
use App\Services\Utils\ResponseServiceInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{


    private $modelRepository;
    private $responseService;
    private $name = 'User';

    public function __construct(UserRepositoryInterface $modelRepository, ResponseServiceInterface $responseService){
        $this->modelRepository = $modelRepository;
        $this->responseService = $responseService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $results =  $this->modelRepository->getList();
        return $this->responseService->resolveResponse('User Fetch Successfully!', new UserCollection($results));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $user = $this->modelRepository->create($request->validated());
        $user = new UserResource($user);
        return $this->responseService->storeResponse($this->name, $user);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->modelRepository->find($id);
        return $this->responseService->resolveResponse('User show Successfully!', $data);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = $this->modelRepository->update($request->validated(), $id);
        $user = new UserResource($user);
        return $this->responseService->updateResponse($this->name, $user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->modelRepository->delete($id);
        return $this->responseService->deleteResponse($this->name);
    }
}
