<?php

namespace App\Repository;

use App\Models\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class ClientRepository implements ClientRepositoryInterface
{
    /**
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllClients(int $perPage): LengthAwarePaginator
    {
        return Client::paginate($perPage);
    }

    /**
     * @param string $id
     * @return Client|null
     */
    public function getClientById(string $id): ?Client
    {
        return Client::find($id);
    }

    /**
     * @param array $clientRequest
     * @param Client|null $client
     * @return Client
     */
    public function createOrUpdateUser(array $clientRequest, Client $client = null): Client
    {
        if($client === null) {
            $client = new Client();
            $client->id = $clientRequest['id'] ?: Str::random(6);
            $client->email = $clientRequest['email'];
        }

        $client->name = $clientRequest['name'];
        $client->address = $clientRequest['address'];
        $client->save();

        return $client;
    }

    /**
     * @param Client $client
     * @return bool|null
     */
    public function deleteClient(Client $client): ?bool
    {
        return $client->delete();
    }
}
