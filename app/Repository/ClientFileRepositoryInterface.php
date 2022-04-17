<?php

namespace App\Repository;

use App\Models\ClientFile;

interface ClientFileRepositoryInterface
{
    /**
     * @param array $clientFiles
     */
    public function insertClientFiles(array $clientFiles): void;
    /**
     * @param ClientFile $clientFile
     * @return bool|null
     */
    public function deleteClientFile(ClientFile $clientFile): ?bool;
}
