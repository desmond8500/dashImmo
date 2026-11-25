<?php

// Messages de validation en français (sous-ensemble des règles utilisées
// dans l'application). Sans ce fichier, la locale « fr » (fallback compris)
// afficherait les clés brutes du type « validation.required ».
return [
    'after_or_equal' => 'Le champ :attribute doit être une date postérieure ou égale à :date.',
    'boolean' => 'Le champ :attribute doit être vrai ou faux.',
    'date' => 'Le champ :attribute n\'est pas une date valide.',
    'date_format' => 'Le champ :attribute ne correspond pas au format :format.',
    'exists' => 'La valeur sélectionnée pour :attribute est invalide.',
    'file' => 'Le champ :attribute doit être un fichier.',
    'in' => 'La valeur sélectionnée pour :attribute est invalide.',
    'integer' => 'Le champ :attribute doit être un nombre entier.',
    'max' => [
        'numeric' => 'Le champ :attribute ne doit pas dépasser :max.',
        'file' => 'Le fichier :attribute ne doit pas dépasser :max kilo-octets.',
        'string' => 'Le champ :attribute ne doit pas dépasser :max caractères.',
        'array' => 'Le champ :attribute ne doit pas contenir plus de :max éléments.',
    ],
    'mimes' => 'Le fichier :attribute doit être de type : :values.',
    'min' => [
        'numeric' => 'Le champ :attribute doit être supérieur ou égal à :min.',
        'file' => 'Le fichier :attribute doit faire au moins :min kilo-octets.',
        'string' => 'Le champ :attribute doit contenir au moins :min caractères.',
        'array' => 'Le champ :attribute doit contenir au moins :min éléments.',
    ],
    'numeric' => 'Le champ :attribute doit être un nombre.',
    'required' => 'Le champ :attribute est obligatoire.',
    'string' => 'Le champ :attribute doit être une chaîne de caractères.',
    'unique' => 'Cette valeur de :attribute est déjà utilisée.',
    'uploaded' => 'Le fichier :attribute n\'a pas pu être envoyé.',

    'attributes' => [
        'nom' => 'nom',
        'prenom' => 'prénom',
        'montant' => 'montant',
        'date' => 'date',
        'genre' => 'genre',
        'statut' => 'statut',
        'type' => 'type',
        'niveau' => 'niveau',
        'numero' => 'numéro',
        'adresse' => 'adresse',
    ],
];
