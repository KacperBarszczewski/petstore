<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Models\Pet;
use App\Enums\PetStatus;
use App\Models\Category;
use App\Models\Tag;
use App\Http\Requests\StorePetRequest;

class PetController extends Controller
{
    public function index()
    {
        $response = Http::get('https://petstore.swagger.io/v2/pet/findByStatus', [
            'status' => 'available',
        ]);

        if (!$response->successful()) {
            return redirect()->route('pets.index')->with('error', 'Failed to fetch pets from API.');
        }

        $petsData = $response->json();

        if (!is_array($petsData)) {
            return redirect()->route('pets.index')->with('error', 'Failed to fetch pets data from the API.');
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
        if (!ctype_digit($id)) {
            return redirect()->route('pets.index')->with('error', 'Invalid pet ID provided.');
        }

        $response = Http::withHeaders([
            'api_key' => config('services.petstore.api_key'),
        ])->delete("https://petstore.swagger.io/v2/pet/{$id}");

        if ($response->successful()) {
            return redirect()->route('pets.index')->with('success', "Pet with ID {$id} deleted successfully.");
        } elseif ($response->status() === 404) {
            return redirect()->route('pets.index')->with('error', "Pet with ID {$id} not found.");
        } elseif ($response->status() === 400) {
            return redirect()->route('pets.index')->with('error', "Invalid pet ID: {$id}.");
        } else {
            \Log::error('Failed to delete pet', [
                'id' => $id,
                'response' => $response->body(),
            ]);
            return redirect()->route('pets.index')->with('error', 'Failed to delete pet due to an unexpected error.');
        }
    }

    public function store(StorePetRequest $request)
    {
        \Log::info('Store method called');

        dd($request);
        $validated = $request->validated();

        $data = [
            'id' => $validated['id'] ?? null,
            'name' => $validated['name'],
            'photoUrls' => $validated['photoUrls'],
            'category' => [
                'id' => $validated['category']['id'] ?? null,
                'name' => $validated['category']['name'] ?? null,
            ],
            'tags' => array_map(function ($tag) {
                return [
                    'id' => $tag['id'] ?? null,
                    'name' => $tag['name'] ?? null,
                ];
            }, $validated['tags'] ?? []),
            'status' => $validated['status'] ?? null,
        ];


        $response = Http::withHeaders([
            'api_key' => config('services.petstore.api_key'),
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post('https://petstore.swagger.io/v2/pet', $data);


        dd($response);

        if ($response->status() == 302) {
            // Log the redirect URL
            \Log::info('Redirect URL: ' . $response->header('Location'));
        }

        if ($response->successful()) {
            return redirect()->route('pets.index')->with('success', 'Pet created successfully.');
        }

        \Log::error('Failed to create pet', [
            'data' => $data,
            'response' => $response->body(),
        ]);

        return redirect()->route('pets.index')->with('error', 'Failed to create pet. Please try again.');
    }

}
