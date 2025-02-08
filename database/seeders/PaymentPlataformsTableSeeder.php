<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentPlatform;

class PaymentPlataformsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentPlatform::create([
            'name' => 'Paypal',
            'image' => 'img/payment-plataforms/paypal.jpg',
        ]);

        PaymentPlatform::create([
            'name' => 'Stripe',
            'image' => 'img/payment-plataforms/stripe.jpg',
        ]);

        PaymentPlatform::create([
            'name' => 'MercadoPago',
            'image' => 'img/payment-plataforms/mercadopago.jpg',
        ]);

        PaymentPlatform::create([
            'name' => 'PayU',
            'image' => 'img/payment-plataforms/payu.jpg',
        ]);
    }
}
