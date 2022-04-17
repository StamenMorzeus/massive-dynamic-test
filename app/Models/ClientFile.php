<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\ClientFile
 *
 * @property string $id
 * @property string $name
 * @property string $path
 * @property-read Collection|Client $client
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class ClientFile extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * @param $files
     * @param string $clientId
     * @return array
     */
    public static function uploadFiles($files, string $clientId): array
    {
        foreach($files as $key => $file)
        {
            $path = $file->store('public/documents');
            $name = $file->getClientOriginalName();

            $insert[$key]['client_id'] = $clientId;
            $insert[$key]['name'] = $name;
            $insert[$key]['path'] = $path;
        }

        return $insert;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
