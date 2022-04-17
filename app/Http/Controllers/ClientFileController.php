<?php

namespace App\Http\Controllers;

use App\Models\ClientFile;
use App\Repository\ClientFileRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class ClientFileController extends Controller
{
    private ClientFileRepositoryInterface $clientFileRepository;

    /**
     * @param ClientFileRepositoryInterface $clientFileRepository
     */
    public function __construct(ClientFileRepositoryInterface $clientFileRepository)
    {
        $this->clientFileRepository = $clientFileRepository;
    }

    /**
     * @param ClientFile $clientFile
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function downloadFile(ClientFile $clientFile)
    {
        return Storage::download($clientFile->path, $clientFile->name);
    }

    /**
     * @param ClientFile $clientFile
     * @return mixed
     */
    public function destroy(ClientFile $clientFile)
    {
        $clientId = $clientFile->client->id;

        if($this->clientFileRepository->deleteClientFile($clientFile) === true)
        {
            // delete document
            Storage::delete($clientFile->path);
        }

        return Redirect::route('client_edit', $clientId)->withSuccess(__('Document is deleted'));
    }
}
