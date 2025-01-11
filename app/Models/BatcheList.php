<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BatcheList extends Model
{
    protected $fillable = [
        'serial_number',
        'caller_number',
        'batche_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'batche_id' => 'integer',
    ];


    public function batche(): BelongsTo
    {
        return $this->belongsTo(Batche::class);
    }

    public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }

    public function archivedStudent(): HasOne
    {
        return $this->hasOne(ArchivedStudent::class);
    }


}
