<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appartement extends Model
{
    use SoftDeletes;

    public $table = 'appartements';

    public $fillable = [
        'batiment_id',
        'nom',
        'numero',
        'niveau',
        'adresse',
        'statut',
    ];

    protected $casts = [
        'batiment_id' => 'integer',
        'statut' => 'boolean',
    ];

    public function compteur(): HasOne
    {
        return $this->hasOne(Compteur::class);
    }

    public function contrat(): HasOne
    {
        return $this->hasOne(Contrat::class);
    }

    public function batiment(): BelongsTo
    {
        return $this->belongsTo(Batiment::class);
    }
}
