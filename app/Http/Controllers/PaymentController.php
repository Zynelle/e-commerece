<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Affiche le formulaire de paiement
     */
    public function showForm()
    {
        return view('payment.form');
    }

    /**
     * Redirige vers la page contenant le widget de paiement Monetbil
     */
    public function redirectToMonetbil(Request $request)
    {
        $amount = $request->input('amount', 500); // Montant dynamique ou par défaut
        $user = auth()->id() ?? 1;

        $params = [
            'amount' => $amount,
            'currency' => config('services.monetbil.currency'),
            'locale' => 'fr',
            'service' => config('services.monetbil.service_key'),
            'return_url' => config('services.monetbil.return_url'),
            'notify_url' => config('services.monetbil.notify_url'),
            'user' => $user,
        ];

        $paymentUrl = "https://api.monetbil.com/widget/v2.1/checkout.js?" . http_build_query($params);

        return view('payment.checkout', compact('paymentUrl'));
    }

    /**
     * Traite le retour après paiement (retour utilisateur)
     */
    public function paymentReturn(Request $request)
    {
        $transaction_id = $request->input('transaction_id');
        $service_key = config('services.monetbil.service_key');

        $response = Http::get("https://api.monetbil.com/payment/v1/transaction/{$transaction_id}?service={$service_key}");

        $status = $response['status'] ?? 'unknown';

        if ($status === 'success') {
            return view('payment.success', compact('transaction_id'));
        }

        return view('payment.fail', compact('transaction_id'));
    }

    /**
     * Reçoit les notifications automatiques de Monetbil (webhook)
     */
    public function notify(Request $request)
    {
        Log::info('Notification Monetbil reçue:', $request->all());

        // Tu peux ici enregistrer la transaction dans la base de données si nécessaire

        return response('OK', 200);
    }
}
