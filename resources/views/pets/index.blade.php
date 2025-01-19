@extends('layouts.app')


@section('content')

<h1 class="mt-10 font-extrabold text-4xl underline shadow-lg">Tabela zwierząt</h1>

<table class="my-10 bg-gray-200 border border-gray-300 shadow-md rounded-lg text-center">
    <thead class="bg-gray-300 text-gray-700 font-semibold">
        <tr class="border-b border-gray-300">
            <th class="px-4 py-3">Id</th>
            <th class="px-4 py-3">Zdjecie</th>
            <th class="px-4 py-3">Imie</th>
            <th class="px-4 py-3">Status</th>
            <th class="px-4 py-3">Kategoria</th>
            <th class="px-4 py-3">Tag</th>
            <th class="px-4 py-3">Edytuj</th>
            <th class="px-4 py-3">Usuń</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pets as $pet)
            <tr class="hover:bg-gray-100 hover:cursor-pointer border-b border-gray-300" onclick="window.location='{{ route('pets.show', $pet->id) }}'">
                <td class="px-4 py-2 ">{{ $pet->id}}</td>
                <td class="px-4 py-2 ">
                    @if(!empty($pet->photoUrls) && isset($pet->photoUrls[0]))
                        <img src="{{ $pet->photoUrls[0] }}" alt="Pet photo" class="w-32 h-32 object-cover">
                    @else
                        No photo available
                    @endif
                </td>
                <td class="px-4 py-2">{{ $pet->name }}</td>
                <td class="px-4 py-2">{{ $pet->status->value }}</td>
                <td class="px-4 py-2"> {{ $pet->category->name ?? 'No category' }}</td>
                <td class="px-4 py-2">
                    @foreach ($pet->tags as $tag)
                        {{ $tag->name }}
                    @endforeach
                </td>
                <td class="px-4 py-2">
                    <form action="{{ route('pets.edit', $pet->id) }}" method="GET">
                        @csrf
                        <button type="submit" class="bg-blue-400 hover:bg-blue-500 text-white px-4 py-2 rounded">
                            Edytuj
                        </button>
                    </form>
                </td>
                <td class="px-4 py-2">
                    <form action="{{ route('pets.delete', $pet->id) }}" method="POST"
                        onsubmit="return confirm('Napewno chcesz usunąć zwierze?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-400 hover:bg-red-500 text-white px-4 py-2 rounded">Usuń</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>


@endsection