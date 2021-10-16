<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PetPassport\Events\FriendshipReceived;
use App\PetPassport\Models\User\UserProfile;
use App\PetPassport\Models\Message;

class TestController extends Controller
{
    /**
     * @return string
     */
    public function test()
    {
        $msg = new Message;
        $msg->sender_id = 21;
        $msg->sender_type = 'profile';
        $msg->recipient_id = 1;
        $msg->recipient_type = 'profile';
        $msg->body = 'test';
        $msg->save();

        return "ok";
        function currencyConverter($currency_from, $currency_to, $currency_input) {
            $yql_base_url = "http://query.yahooapis.com/v1/public/yql";
            $yql_query = 'select * from yahoo.finance.xchange where pair in ("' . $currency_from . $currency_to . '")';
            $yql_query_url = $yql_base_url . "?q=" . urlencode($yql_query);
            $yql_query_url .= "&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys";
            $yql_session = curl_init($yql_query_url);
            curl_setopt($yql_session, CURLOPT_RETURNTRANSFER, true);
            $yqlexec = curl_exec($yql_session);
            $yql_json =  json_decode($yqlexec, true);

            dd($yqlexec);
            $currency_output = (float) $currency_input * $yql_json['query']['results']['rate']['Rate'];

            return $currency_output;
        }

        $currency_input = 1;
        //currency codes : http://en.wikipedia.org/wiki/ISO_4217
        $currency_from = "USD";
        $currency_to = "RUB";
        $currency = currencyConverter($currency_from, $currency_to, $currency_input);

        echo $currency_input . ' ' . $currency_from . ' = ' . $currency . ' ' . $currency_to;
    }
}
