<?php

namespace App\Repository;

use App\Enums\UserRoleEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllUsers(int $perPage): LengthAwarePaginator
    {
        return User::where('id', '!=', Auth::id())->paginate($perPage);
    }

    /**
     * @param int $id
     * @return User|null
     */
    public function getUserById(int $id): ?User
    {
        return User::find($id);
    }

    /**
     * @param array $userRequest
     * @param User|null $user
     * @return User
     */
    public function createOrUpdateUser(array $userRequest, User $user = null): User
    {
        if($user === null) {
            $user = new User;
            $user->email = $userRequest['email'];
            $user->password = Hash::make($userRequest['password']);
        }

        $user->name = $userRequest['name'];
        $user->username = $userRequest['username'];
        $user->role = $userRequest['role'];
        $user->save();

        return $user;
    }

    /**
     * @param User $user
     * @return bool|null
     */
    public function deleteUser(User $user): ?bool
    {
        return $user->delete();
    }

    /**
     * @param string|null $name
     * @return Collection
     */
    public function searchClients(string|null $name): Collection
    {
        $query = User::where('role', UserRoleEnum::CLIENT->value)
            ->whereNull('client_id');

        if($name !== null) {
            $query->where('name', 'like', '%' . $name . '%');
        }

        return $query->get();
    }

    /**
     * @param array $userIds
     * @param string $clientId
     */
    public function associate(array $userIds, string $clientId): void
    {
        User::whereIn('id', $userIds)
            ->update(['client_id' => $clientId]);
    }

    /**
     * @param array $userIds
     */
    public function dissociate(array $userIds): void
    {
        User::whereIn('id', $userIds)
            ->update(['client_id' => NULL]);
    }
}
