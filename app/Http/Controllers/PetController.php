<?php

namespace App\Http\Controllers;

use Http;
use App\Models\Pet;
use App\Enums\PetStatus;

class PetController extends Controller
{
    public function index()
    {
        $response = Http::get('https://petstore.swagger.io/v2/pet/findByStatus', [
            'status' => 'available'
        ]);

        $petsData = $response->json();

        $pets = collect($petsData)->map(function ($data) {
            return new Pet(
                id: $data['id'],
                name: $data['name'],
                photoUrls: $data['photoUrls'],
                status: PetStatus::from($data['status'])
            );
        });

        return view('pets.index',compact('pets'));
    }

    public function create()
    {
        return view('pets.create');
    }
}
