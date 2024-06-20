<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentWompiController extends Controller
{
    public function generateSignature()
    {
        $amountInCents = 4950000; // Monto en centavos
        $currency = 'COP'; // Moneda
        $reference = 'sk8-438k4-xmxm392-sn5m'; // Referencia
        $publicKey = 'pub_test_vcwVzE4mwElxGcoBQQBDN0VEUr5Fqllj'; // Clave pública
        $privateKey = 'prv_test_SD9lVkeR0HwqO3Ta99MNWbuf3cU0aPyp'; // Clave privada
        $integrityKey = 'test_integrity_LSwafokf4k2zHUIJKMxN65JZNEiuG76Z';

        // Concatenar los datos
        $dataString = $reference . $amountInCents . $currency . $integrityKey;
        // bdd49b07960ae9671c1eea7ac06cce1de2fd3f9de09fe627fe7dedd20d3a4fe0
        // 4b43863e99b82e20b670c155969e4360d8a65d0cbf5b7ec29898cccc2242864b

        // Generar hash usando SHA-256 y la clave privada
        $signature = hash('sha256', $dataString);

        return $signature;
    }

    public function showPaymentForm()
    {
        $signature = $this->generateSignature();
        // <form>
        //     <script
        //         src="https://checkout.wompi.co/widget.js"
        //         data-render="button"
        //         data-public-key="{{ $publicKey }}"
        //         data-currency="{{ $currency }}"
        //         data-amount-in-cents="{{ $amountInCents }}"
        //         data-reference="{{ $reference }}"
        //         data-signature:integrity="{{ $signature }}"
        //     ></script>
        // </form>
        return view('wompi.checkout', [
            'signature' => $signature,
            'publicKey' => 'pub_test_vcwVzE4mwElxGcoBQQBDN0VEUr5Fqllj', // Cambia por tu clave pública real
            'amountInCents' => 4950000,
            'currency' => 'COP',
            'reference' => 'sk8-438k4-xmxm392-sn5m',
        ]);
    }
}
