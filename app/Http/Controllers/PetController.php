<?php

namespace App\Http\Controllers;

use Http;
use Illuminate\Http\Request;

class PetController extends Controller
{
    public function index()
    {
        $response = Http::get('https://petstore.swagger.io/v2/pet/findByStatus', [
            'status' => 'available'
        ]);

        $pets = $response->json();

        return view('pets.index',compact('pets'));
    }

    public function create()
    {
        return view('pets.create');
    }
}
