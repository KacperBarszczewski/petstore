<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Models\Pet;
use App\Enums\PetStatus;
use App\Models\Category;
use App\Models\Tag;


class PetController extends Controller
{
    public function index()
    {
        $response = Http::get('https://petstore.swagger.io/v2/pet/findByStatus', [
            'status' => 'available',
        ]);

        $petsData = $response->json();

        if (!is_array($petsData)) {
            return view('error');
        }

        $pets = collect($petsData)->map(function ($data) {
            $category = isset($data['category']) ? new Category(
                id: $data['category']['id'] ?? null,
                name: $data['category']['name'] ?? null
            ) : null;

            $tags = isset($data['tags']) ? collect($data['tags'])->map(function ($tag) {
                return new Tag(
                    id: $tag['id'] ?? null,
                    name: $tag['name'] ?? null
                );
            })->toArray() : [];

            $status = isset($data['status']) ? PetStatus::tryFrom($data['status']) : null;

            return new Pet(
                name: $data['name'] ?? '',
                photoUrls: $data['photoUrls'] ?? [],
                id: $data['id'] ?? null,
                category: $category,
                tags: $tags,
                status: $status
            );
        });

        return view('pets.index', compact('pets'));
    }

    public function create()
    {
        return view('pets.create');
    }

    public function delete($id)
    {
        $response = Http::withHeaders([
            'api_key' => 'special-key',
        ])->delete("https://petstore.swagger.io/v2/pet/{$id}");


        if ($response->successful()) {
            return redirect()->route('pets.index')->with('success', 'Pet deleted successfully.');
        } else {
            return redirect()->route('pets.index')->with('error', 'Failed to delete pet.');
        }
    }
}
