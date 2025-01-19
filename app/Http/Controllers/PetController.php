<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Models\Pet;
use App\Enums\PetStatus;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PetController extends Controller
{
    public function index()
    {
        try {
            $response = Http::get('https://petstore.swagger.io/v2/pet/findByStatus', [
                'status' => 'available',
            ]);

            $response->throw();

            $petsData = $response->json();
            if (!is_array($petsData)) {
                return redirect()->route('pets.index')->with('error', 'Failed to fetch pets data from the API.');
            }

            $pets = collect($petsData)->map(fn($data) => $this->mapPetData($data));

            return view('pets.index', compact('pets'));

        } catch (\Exception $e) {
            return redirect()->route('pets.index')->with('error', 'Failed to fetch pets from API.');
        }
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

        try {
            $response = Http::withHeaders([
                'api_key' => config('services.petstore.api_key'),
            ])->delete("https://petstore.swagger.io/v2/pet/{$id}");

            if ($response->successful()) {
                return redirect()->route('pets.index')->with('success', "Pet with ID {$id} deleted successfully.");
            } else {
                $this->handleApiError($response);
            }

        } catch (\Exception $e) {
            return redirect()->route('pets.index')->with('error', 'Failed to delete pet due to an unexpected error.');
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'photoUrls' => 'required|array',
            'photoUrls.*' => 'required|string',
            'id' => 'nullable|integer',
            'category.id' => 'nullable|integer',
            'category.name' => 'nullable|string|max:255',
            'tags' => 'nullable|array',
            'tags.*.id' => 'nullable|integer',
            'tags.*.name' => 'nullable|string|max:255',
            'status' => 'nullable|string|in:available,pending,sold',
        ]);

        if ($validator->fails()) {
            return redirect()->route('pets.create')
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        $data = $this->preparePetDataForApi($validated);

        try {
            $response = Http::withHeaders([
                'api_key' => config('services.petstore.api_key'),
                'accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post('https://petstore.swagger.io/v2/pet', $data);

            if ($response->successful()) {
                return redirect()->route('pets.index')->with('success', 'Pet created successfully.');
            }

            $this->handleApiError($response);

        } catch (\Exception $e) {
            return redirect()->route('pets.index')->with('error', 'Failed to create pet. Please try again.');
        }
    }


    public function edit($id)
    {
        if (!ctype_digit($id)) {
            return redirect()->route('pets.index')->with('error', 'Invalid pet ID provided.');
        }

        try {
            $response = Http::get("https://petstore.swagger.io/v2/pet/{$id}");

            $response->throw();

            $petData = $response->json();
            $pet = $this->mapPetData($petData);

            return view('pets.edit', compact('pet'));

        } catch (\Exception $e) {
            return redirect()->route('pets.index')->with('error', 'Failed to fetch pet data for editing.');
        }
    }


    public function update(Request $request, $id)
    {
        if (!ctype_digit($id)) {
            return redirect()->route('pets.index')->with('error', 'Invalid pet ID provided.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'photoUrls' => 'required|array',
            'photoUrls.*' => 'required|string',
            'category.id' => 'nullable|integer',
            'category.name' => 'nullable|string|max:255',
            'tags' => 'nullable|array',
            'tags.*.name' => 'nullable|string|max:255',
            'status' => 'nullable|string|in:available,pending,sold',
        ]);

        if ($validator->fails()) {
            return redirect()->route('pets.edit', ['id' => $id])
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        $data = $this->preparePetDataForApi($validated);
        $data['id'] = $id;

        try {
            $response = Http::withHeaders([
                'api_key' => config('services.petstore.api_key'),
                'accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->put("https://petstore.swagger.io/v2/pet", $data);

            if ($response->successful()) {
                return redirect()->route('pets.index')->with('success', 'Pet updated successfully.');
            }

            $this->handleApiError($response);

        } catch (\Exception $e) {
            return redirect()->route('pets.index')->with('error', 'Failed to update pet. Please try again.');
        }
    }

    public function show($id)
    {
        if (!ctype_digit($id)) {
            return redirect()->route('pets.index')->with('error', 'Invalid pet ID provided.');
        }

        try {
            $response = Http::get("https://petstore.swagger.io/v2/pet/{$id}");

            $response->throw();

            $petData = $response->json();
            $pet = $this->mapPetData($petData);

            return view('pets.show', compact('pet'));

        } catch (\Exception $e) {
            return redirect()->route('pets.index')->with('error', 'Failed to fetch pet data.');
        }
    }

    //////////////////
    private function mapPetData($data)
    {
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
    }

    private function handleApiError($response)
    {
        if ($response->status() === 404) {
            return redirect()->route('pets.index')->with('error', 'Pet not found.');
        } elseif ($response->status() === 400) {
            return redirect()->route('pets.index')->with('error', 'Invalid pet data.');
        } else {
            return redirect()->route('pets.index')->with('error', 'An unexpected error occurred.');
        }
    }

    private function preparePetDataForApi($validated)
    {
        return [
            'id' => $validated['id'] ?? null,
            'name' => $validated['name'],
            'photoUrls' => $validated['photoUrls'],
            'category' => [
                'id' => $validated['category']['id'] ?? null,
                'name' => $validated['category']['name'] ?? null,
            ],
            'tags' => array_map(fn($tag) => [
                'id' => $tag['id'] ?? null,
                'name' => $tag['name'] ?? null,
            ], $validated['tags'] ?? []),
            'status' => $validated['status'] ?? null,
        ];
    }

}
