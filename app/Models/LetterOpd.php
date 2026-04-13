<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class LetterOpd extends Pivot
{
    public function p1Type(): BelongsTo
    {
        return $this->belongsTo(P1Type::class, 'p1_type_id');
    }
}
