<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PortafolioClient;

class PortafolioClientController extends Controller
{
    public function create($portafolio_id, $client_id){
        $portClient = new PortafolioClient();
        $portClient->portafolio_id = $portafolio_id;
        $portClient->client_id = $client_id;
        $portClient->save();
    }
}
