<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArchivedStudent extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'index_number',
        'program_id',
        'telephone',
        'level',
        'expected_completion_year',
        'is_verified',
        'batche_list_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'program_id' => 'integer',
        'batche_list_id' => 'integer',

    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function batcheList(): BelongsTo
    {
        return $this->belongsTo(BatcheList::class);
    }
}
