<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Facture extends Model
{
    use SoftDeletes;

    public $table = 'factures';

    public $fillable = [
        'compteur_id',
        'montant',
        'date',
        'facture',
        'numero',
    ];

    protected $casts = [
        'compteur_id' => 'integer',
        'montant' => 'decimal:2',
    ];

    public function compteur(): BelongsTo
    {
        return $this->belongsTo(Compteur::class);
    }
}
