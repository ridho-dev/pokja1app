<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LetterType extends Model
{
    public $incrementing = false;
    
    protected $fillable = ['letter_type'];

    public function regencies(): HasMany
    {
        return $this->hasMany(Letter::class,'letter_type_id', 'id');
    }
}
