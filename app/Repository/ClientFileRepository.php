<?php

namespace App\Repository;

use App\Models\ClientFile;

class ClientFileRepository implements ClientFileRepositoryInterface
{
    /**
     * @param array $clientFiles
     */
    public function insertClientFiles(array $clientFiles): void
    {
        ClientFile::insert($clientFiles);
    }

    /**
     * @param ClientFile $clientFile
     * @return bool|null
     */
    public function deleteClientFile(ClientFile $clientFile): ?bool
    {
       return $clientFile->delete();
    }
}
