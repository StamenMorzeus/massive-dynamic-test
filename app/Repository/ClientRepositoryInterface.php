<?php

namespace App\Repository;

use App\Models\Client;
use Illuminate\Pagination\LengthAwarePaginator;

interface ClientRepositoryInterface
{
    /**
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllClients(int $perPage): LengthAwarePaginator;
    /**
     * @param string $id
     * @return Client|null
     */
    public function getClientById(string $id): ?Client;
    /**
     * @param array $clientRequest
     * @param Client|null $client
     * @return Client
     */
    public function createOrUpdateUser(array $clientRequest, Client $client = null): Client;
    /**
     * @param Client $client
     * @return bool|null
     */
    public function deleteClient(Client $client): ?bool;
}
