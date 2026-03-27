<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Letter extends Model
{
    use HasFactory;

    // const CREATED_AT = 'upload_date';
    // const UPDATED_AT = 'updated_date';

    protected $fillable = [
        'file_name',
        'kloter',
        'letter_number',
        'letter_type_id',
        'letter_date',
        'uploaded_by',
        'updated_by',
        'information',
        'file_path',
        'start_date',
        'end_date',
    ];

    /**
     * Relasi ke LetterType
     */
    public function letterType(): BelongsTo
    {
        return $this->belongsTo(LetterType::class, 'letter_type_id');
    }

    /**
     * Relasi ke Provinsi (Province)
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * Relasi ke Kabupaten/Kota (Regency)
     */
    public function regency(): BelongsTo
    {
        return $this->belongsTo(Regency::class, 'regency_id');
    }

    /**
     * Relasi ke OPD
     */
    public function opds(): BelongsToMany
    {
        // belongsToMany(ModelTujuan, NamaTabelPivot, KolomForeignDiPivot, KolomTujuanDiPivot)
        return $this->belongsToMany(Opd::class, 'letter_opd', 'letter_id', 'opd_id');   
    }

    /**
     * Relasi ke User (siapa yang upload)
     */
    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Relasi ke User (siapa yang terakhir update)
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
