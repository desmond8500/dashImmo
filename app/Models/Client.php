<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;

    public $table = 'clients';

    public $fillable = [
        'prenom',
        'nom',
        'genre',
        'ci',
        'delivre',
        'statut',
    ];

    protected $casts = [
        'statut' => 'boolean',
    ];

    public function contrat(): HasOne
    {
        return $this->hasOne(Contrat::class);
    }
}
