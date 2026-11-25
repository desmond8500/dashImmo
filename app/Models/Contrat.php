<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contrat extends Model
{
    use SoftDeletes;

    public $table = 'contrats';

    public $fillable = [
        'client_id',
        'appartement_id',
        'debut',
        'fin',
        'montant',
        'type',
        'date',
        'sign1',
        'sign2',
    ];

    // debut / fin / date restent de simples chaînes "Y-m-d" : la vue PDF
    // (contrats.contrat_pdf) fait un explode("-", $contrat->date), un cast
    // Carbon ajouterait une heure et casserait ce parsing.
    protected $casts = [
        'client_id' => 'integer',
        'appartement_id' => 'integer',
        'montant' => 'decimal:2',
        'sign1' => 'boolean',
        'sign2' => 'boolean',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function appartement(): BelongsTo
    {
        return $this->belongsTo(Appartement::class);
    }
}
