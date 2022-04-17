<?php

namespace App\Http\Controllers;

use App\Http\Requests\Clients\ClientCreateRequest;
use App\Http\Requests\Clients\ClientUpdateRequest;
use App\Models\Client;
use App\Models\ClientFile;
use App\Repository\ClientFileRepositoryInterface;
use App\Repository\ClientRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use Illuminate\Support\Facades\Redirect;

class ClientController extends Controller
{
    private ClientRepositoryInterface $clientRepository;
    private UserRepositoryInterface $userRepository;
    private ClientFileRepositoryInterface $clientFileRepository;

    /**
     * @param ClientRepositoryInterface $clientRepository
     * @param UserRepositoryInterface $userRepository
     * @param ClientFileRepositoryInterface $clientFileRepository
     */
    public function __construct(
        ClientRepositoryInterface $clientRepository,
        UserRepositoryInterface $userRepository,
        ClientFileRepositoryInterface $clientFileRepository
    )
    {
        $this->clientRepository = $clientRepository;
        $this->userRepository = $userRepository;
        $this->clientFileRepository = $clientFileRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('client.index', [
            'clients' => $this->clientRepository->getAllClients(15)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('client.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ClientCreateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientCreateRequest $request)
    {
        // create client
        $client = $this->clientRepository->createOrUpdateUser($request->all());

        if(!empty($contactPersons = $request->input('contactPersons'))) {
            // add contact persons
            $this->userRepository->associate($contactPersons, $client->id);
        }

        return Redirect::route('client_index')->withSuccess(__('Client is created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(string $id)
    {
        $client = $this->clientRepository->getClientById($id);

        if(!$client) {
            return Redirect::route('client_index', $id)->withError(__("Client don't exist"));
        }

        return view('client.edit', [
            'client' => $client
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ClientUpdateRequest $request
     * @param \App\Models\Client $client
     * @return \Illuminate\Http\Response
     */
    public function update(ClientUpdateRequest $request, Client $client)
    {
        // update client
        $client = $this->clientRepository->createOrUpdateUser($request->all(), $client);

        // update contact persons
        $contactPersons = $client->contactPersons->pluck('id')->all() ?: [];
        $newContactPerson = $request->input('contactPersons') ?: [];

        $whatNeedsToBeDeleted = array_diff($contactPersons, $newContactPerson);
        $this->userRepository->dissociate($whatNeedsToBeDeleted);

        $whatNeedsToBeAdded = array_diff($newContactPerson, $contactPersons);
        $this->userRepository->associate($whatNeedsToBeAdded, $client->id);

        // upload documents
        if($request->hasfile('documents'))
        {
            $clientFiles = ClientFile::uploadFiles($request->file('documents'), $client->id);

            $this->clientFileRepository->insertClientFiles($clientFiles);
        }

        return Redirect::route('client_edit', $client->id)->withSuccess(__('Client is updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $this->clientRepository->deleteClient($client);

        return Redirect::route('client_index')->withSuccess(__('Client is deleted'));
    }
}
