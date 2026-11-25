<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Compteur extends Model
{
    use SoftDeletes;

    public $table = 'compteurs';

    public $fillable = [
        'appartement_id',
        'type',
        'reference',
        'ref_client',
        'ref_compteur',
        'adresse_technique',
    ];

    protected $casts = [
        'appartement_id' => 'integer',
    ];

    public function appartement(): BelongsTo
    {
        return $this->belongsTo(Appartement::class);
    }
}
