<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Province extends Model
{
    public $incrementing = false;
    
    protected $fillable = ['name'];

    public function regencies(): HasMany
    {
        return $this->hasMany(Regency::class);
    }
}
