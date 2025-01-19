@extends('layouts.app')


@section('content')

<h1 class="mt-10 font-extrabold text-4xl underline shadow-lg">Dodaj zwierze</h1>

<form action="{{ route('pets.store') }}" method="POST" class="space-y-6">
    @csrf

    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Imie*</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}" required
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-2"
            placeholder="Wisz imie zwierzecia">
    </div>


    <div>
        <label for="photoUrls" class="block text-sm font-medium text-gray-700">Zdjęcia</label>
        <textarea name="photoUrls[]" id="photoUrls" rows="3" required
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-2"
            placeholder="Dodaj zdjęcia">{{ old('photoUrls.0') }}</textarea>
    </div>

    <div>
        <label for="category_id" class="block text-sm font-medium text-gray-700"> ID</label>
        <input type="number" name="category[id]" id="category_id" value="{{ old('category.id') }}"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-2"
            placeholder="Wpisz ID">
    </div>

    <div>
        <label for="category_name" class="block text-sm font-medium text-gray-700">Kategoria</label>
        <input type="text" name="category[name]" id="category_name" value="{{ old('category.name') }}"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-2"
            placeholder="wpisz kategorie">
    </div>

    <div>
        <label for="tags" class="block text-sm font-medium text-gray-700">Tags</label>
        <textarea name="tags[0][name]" id="tags" rows="1"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-2"
            placeholder="wpisz tag">{{ old('tags.0.name') }}</textarea>
    </div>

    <div>
        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
        <select name="status" id="status"
            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-2">
            <option value="available" {{ old('status') === 'available' ? 'selected' : '' }}>Available</option>
            <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="sold" {{ old('status') === 'sold' ? 'selected' : '' }}>Sold</option>
        </select>
    </div>

    <div>
        <button type="submit"
            class="w-full bg-blue-500 text-white font-bold mb-4 py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            Dodaj
        </button>
    </div>
</form>
@endsection