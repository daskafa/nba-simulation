@extends('layouts.master')
@section('content')
    <div class="border shadow-sm">
        <figure class="p-8 text-center bg-gray-50">
            <blockquote class="max-w-2xl mx-auto text-gray-500">
                <h3 class="text-2xl text-gray-700">
                    NBA First Week Fixture
                </h3>
                <div class="mt-4">
                    @foreach($fixture as $fixtureItem)
                        <div class="grid grid-cols-3 mt-3">
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">{{ $fixtureItem->homeTeam->name }}</span>
                            <span class="mx-2 italic">vs</span>
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">{{ $fixtureItem->awayTeam->name }}</span>
                        </div>
                    @endforeach
                </div>
            </blockquote>
            <a href="{{ url('simulation') }}" type="button" class="text-white bg-gray-700 hover:bg-gray-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center mt-8">
                <svg class="w-3.5 h-3.5 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1.984v14.032a1 1 0 0 0 1.506.845l12.006-7.016a.974.974 0 0 0 0-1.69L2.506 1.139A1 1 0 0 0 1 1.984Z"/>
                </svg>
                Start Simulation
            </a>
        </figure>
    </div>
@endsection
