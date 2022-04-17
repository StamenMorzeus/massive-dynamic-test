<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Client
 *
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $address
 * @property-read Collection|User[] $contactPersons
 * @property-read Collection|ClientFile[] $documents
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Client extends Model
{
    use HasFactory;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contactPersons()
    {
        return $this->hasMany(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documents()
    {
        return $this->hasMany(ClientFile::class);
    }
}
