<?php

namespace App\Repository;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    /**
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllUsers(int $perPage): LengthAwarePaginator;
    /**
     * @param int $id
     * @return User|null
     */
    public function getUserById(int $id): ?User;
    /**
     * @param array $userRequest
     * @param User|null $user
     * @return User
     */
    public function createOrUpdateUser(array $userRequest, User $user = null): User;
    /**
     * @param User $user
     * @return bool|null
     */
    public function deleteUser(User $user): ?bool;
    /**
     * @param string|null $name
     * @return Collection
     */
    public function searchClients(string|null $name): Collection;

    /**
     * @param array $userIds
     * @param string $clientId
     */
    public function associate(array $userIds, string $clientId): void;
    /**
     * @param array $userIds
     */
    public function dissociate(array $userIds): void;
}
