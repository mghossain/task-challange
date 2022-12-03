<?php


namespace App\Services;

class NumValidation
{
    public function numberValidation(string $number)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.apilayer.com/number_verification/validate?number=$number}",
            CURLOPT_HTTPHEADER => [
                'Content-Type: text/plain',
                "apikey: " . config('services.numverify.key')
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET"
        ]);

        $response = curl_exec($curl);

        curl_close($curl);
        //dd(json_decode($response));
        return json_decode($response);


    }
}