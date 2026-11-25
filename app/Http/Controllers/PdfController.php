<?php

namespace App\Http\Controllers;

use App\Models\Appartement;
use App\Models\Batiment;
use App\Models\Client;
use App\Models\Compteur;
use App\Models\Contrat;
use App\Models\Settings;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function show_contrat($contrat_id)
    {
        $contrat = Contrat::findOrFail($contrat_id);
        $client = $contrat->client;
        $appartement = $contrat->appartement;
        $data = array(
            "client" => $client,
            "appart" => $appartement,
            "contrat" => $contrat,
            "annee" => date('Y')+1,
            'taxe' => $contrat->montant*0.24 + 6000,
            'caution' => $contrat->montant*2,
            'date_global' => Settings::where('key', 'date')->first(),
            // 'jour' => date('d F Y')
        );

        $pdf = Pdf::loadView('contrats.contrat_pdf', $data);

        return $pdf->stream("Contrat $client->prenom $client->nom _ $appartement->nom");
    }

    public function show_all_contrat()
    {
        $contrats = Contrat::with(['client', 'appartement'])->get();

        $data = array(
            "contrats" => $contrats,
            "annee" => date('Y'),
            'jour' => date('d F Y'),
            'date_global' => Settings::where('key','date')->first()
        );

        $pdf = Pdf::loadView('contrats.all_contrat_pdf', $data);
        return $pdf->stream("Contrats");
    }
    public function some_contrats_pdf($batiment_id)
    {
        if ($batiment_id) {
            $batiment = Batiment::findOrFail($batiment_id);
            $contrats = $batiment->contrats()->with(['client', 'appartement'])->get();
        } else {
            $contrats = Contrat::with(['client', 'appartement'])->get();
        }

        $data = array(
            "contrats" => $contrats,
            "annee" => date('Y'),
            'jour' => date('d F Y'),
            'date_global' => Settings::where('key','date')->first(),
            'start_date' => Settings::where('key','start_date')->first(),
        );

        $pdf = Pdf::loadView('contrats.all_contrat_pdf', $data);

        return $pdf->stream("Contrats");
    }

    public function show_clients()
    {
        $clients = Client::with('contrat.appartement')->where('statut', 1)->get();

        $data = array(
            "clients" => $clients,
        );

        $pdf = Pdf::loadView('clients.clients_pdf', $data);

        return $pdf->stream('Liste des clients');
    }

    public function show_appartements()
    {
        $appartements = Appartement::with(['batiment', 'contrat.client', 'compteur'])->where('statut', 1)
            ->orderBy('batiment_id', 'asc')
            ->orderBy('numero', 'asc')
            ->get();

        $data = array(
            "appartements" => $appartements,
        );
        $pdf = Pdf::loadView('appartements.appartements_pdf', $data);

        return $pdf->stream('Liste des appartements');
    }

    public function appartement_compteurs_pdf()
    {
        $compteurs = Compteur::with('appartement.contrat.client')->where('type', 'EAU')->get();

        $data = array(
            "compteurs" => $compteurs,
        );

        $pdf = Pdf::loadView('_pdf.appartement_compteurs_pdf', $data);
        return $pdf->stream('Liste des compteurs');
    }

}
