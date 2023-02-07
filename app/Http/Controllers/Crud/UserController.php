<?php

namespace App\Http\Controllers\Crud;

use App\Extensions\CrudController;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class UserController extends CrudController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): ResourceCollection
    {
        return User::resources();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): UserResource
    {
        $user = User::create($request->validated());

        return $this->show($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): UserResource
    {
        return $user->resource();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): UserResource
    {
        $user->update($request->validated());

        return $this->show($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
