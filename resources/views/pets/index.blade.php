@extends('layouts.app')


@section('content')

<h1 class="mt-10">Tabela zwierząt</h1>

<table class="my-10 bg-gray-200 border border-gray-300 shadow-md rounded-lg text-center">
    <thead class="bg-gray-300 text-gray-700 font-semibold">
        <tr class="border-b border-gray-300">
            <th class="px-4 py-3">Id</th>
            <th class="px-4 py-3">Imię</th>
            <th class="px-4 py-3">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pets as $pet)
            <tr class="hover:bg-gray-100 border-b border-gray-300">
                <td class="px-4 py-2 ">{{ $pet['id'] }}</td>
                <td class="px-4 py-2">{{ $pet['name'] }}</td>
                <td class="px-4 py-2">{{ $pet['status'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>


@endsection