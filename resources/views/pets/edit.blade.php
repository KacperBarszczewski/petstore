@extends('layouts.app')

@section('content')
    <h1 class="mt-10 font-extrabold text-4xl underline shadow-lg">Edytuj zwierzę</h1>

    <form action="{{ route('pets.update', $pet->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Imię*</label>
            <input type="text" name="name" id="name" value="{{ old('name', $pet->name) }}"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-2"
                placeholder="Wpisz imię zwierzęcia">
            @error('name')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="photoUrls" class="block text-sm font-medium text-gray-700">Zdjęcia</label>
            <textarea name="photoUrls[]" id="photoUrls" rows="3"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-2"
                placeholder="Dodaj zdjęcia">{{ old('photoUrls.0', $pet->photoUrls[0] ?? '') }}</textarea>
            @error('photoUrls.*')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="category_name" class="block text-sm font-medium text-gray-700">Kategoria</label>
            <input type="text" name="category[name]" id="category_name" value="{{ old('category.name', $pet->category->name ?? '') }}"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-2"
                placeholder="Wpisz kategorię">
            @error('category.name')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="tags" class="block text-sm font-medium text-gray-700">Tagi</label>
            <input type="text" name="tags[0][name]" id="tags" value="{{ old('tags.0.name', $pet->tags[0]->name ?? '') }}"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-2"
                placeholder="Wpisz tag">
            @error('tags.*.name')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" id="status"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-2">
                <option value="available" {{ old('status', $pet->status) === 'available' ? 'selected' : '' }}>Available</option>
                <option value="pending" {{ old('status', $pet->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="sold" {{ old('status', $pet->status) === 'sold' ? 'selected' : '' }}>Sold</option>
            </select>
            @error('status')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <button type="submit"
                class="w-full bg-blue-500 text-white font-bold mb-4 py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Zaktualizuj
            </button>
        </div>
    </form>
@endsection
