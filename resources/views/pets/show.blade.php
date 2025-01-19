@extends('layouts.app')

@section('content')

<h1 class="mt-10 font-extrabold text-4xl underline shadow-lg">Szczegóły zwierzęcia</h1>

<div class="mt-6 flex flex-col items-center">
    @if(count($pet->photoUrls) > 0)
        <p><strong>Zdjęcia:</strong></p>
        <div class="grid grid-cols-3 gap-4">
            @foreach($pet->photoUrls as $url)
                <img src="{{ $url }}" alt="Pet photo" class="w-full h-64 rounded-md shadow-md">
            @endforeach
        </div>
    @endif

    <p><strong>Imię: </strong>{{ $pet->name }}</p>
    <p><strong>Status: </strong>{{ $pet->status }}</p>

    @if($pet->category)
        <p><strong>Kategoria: </strong>{{ $pet->category->name }}</p>
    @endif

    @if(count($pet->tags) > 0)
        <p><strong>Tagi: </strong>
            @foreach($pet->tags as $tag)
                {{ $tag->name }}@if(!$loop->last), @endif
            @endforeach
        </p>
    @endif

    <div class="mt-4">
        <a href="{{ route('pets.edit', $pet->id) }}"
            class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
            Edytuj zwierzę
        </a>
    </div>

    <div class="mt-4">
        <form action="{{ route('pets.delete', $pet->id) }}" method="POST"
            onsubmit="return confirm('Napewno chcesz usunąć zwierzę?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-400 hover:bg-red-500 text-white px-4 py-2 rounded-md">Usuń</button>
        </form>
    </div>
</div>

@endsection