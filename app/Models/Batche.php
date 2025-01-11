<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Batche extends Model
{
    protected $fillable = [
        'name',
        'note',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];


    public function batcheLists(): HasMany
    {
        return $this->hasMany(BatcheList::class);
    }
}
