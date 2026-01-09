<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Opd extends Model
{
    public $incrementing = false;
    
    protected $fillable = ['regency_id', 'name', 'created_by'];

    public function regency(): BelongsTo
    {
        return $this->belongsTo(Regency::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}