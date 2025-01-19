@extends('layouts.app')


@section('content')


<p class="text-lg mt-4">Create</p>

<form action="{{ route('pets.store') }}" method="POST" class="mt-4">
    @csrf
    <div class="flex flex-col">
        <label for="name" class="text-lg">Name</label>
        <input type="text" name="name" id="name" class="border border-gray-300 rounded-lg p-2">
    </div>
    <div class="flex flex-col mt-4">
        <label for="status" class="text-lg">Status</label>
        <select name="status" id="status" class="border border-gray-300 rounded-lg p-2">
            <option value="available">Available</option>
            <option value="pending">Pending</option>
            <option value="sold">Sold</option>
        </select>
    </div>
    <button type="submit" class="bg-blue-500 text-white rounded-lg p-2 mt-4">Create</button>


        @endsection