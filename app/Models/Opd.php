<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Opd extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'id',
        'regency_id',
        'name',
        'created_by',
        'start_date',
        'end_date',
    ];

    public function regency(): BelongsTo
    {
        return $this->belongsTo(Regency::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function letters()
    {
        return $this->belongsToMany(Letter::class, 'letter_opd', 'opd_id', 'letter_id');
    }
}