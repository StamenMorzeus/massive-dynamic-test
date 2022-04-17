<?php

namespace App\Http\Controllers;

use App\Enums\UserRoleEnum;
use App\Http\Requests\Users\UserCreateReqeust;
use App\Http\Requests\Users\UserUpdateRequest;
use App\Models\User;
use App\Repository\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    private UserRepositoryInterface $userRepository;

    /**
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('user.index', [
            'users' => $this->userRepository->getAllUsers(15)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('user.create', [
            'roles' => UserRoleEnum::getAllRolesValue()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserCreateReqeust $request
     * @return mixed
     */
    public function store(UserCreateReqeust $request)
    {
        $this->userRepository->createOrUpdateUser($request->all());

        return Redirect::route('user_index')->withSuccess(__('User is created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(int $id)
    {
        $user = $this->userRepository->getUserById($id);

        if(!$user) {
            return Redirect::route('user_index', $id)->withError(__("User don't exist"));
        }

        return view('user.edit', [
            'user' => $user,
            'roles' => UserRoleEnum::getAllRolesValue()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $this->userRepository->createOrUpdateUser($request->all(), $user);

        return Redirect::route('user_edit', $user->id)->withSuccess(__('User is updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->userRepository->deleteUser($user);

        return Redirect::route('user_index')->withSuccess(__('User is deleted'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function searchClients(Request $request): JsonResponse
    {
        return new JsonResponse($this->userRepository->searchClients($request->get('q')), 200);
    }

    public function profile()
    {
        /** @var User $user */
        $user = Auth::user();

        return view('user.profile', [
            'user' => $user
        ]);
    }
}
