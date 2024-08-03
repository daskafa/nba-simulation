@extends('layouts.master')
@section('content')
    <div class="description-area">
        <p>
            This is a simulation page. Here you can simulate the NBA games. You can see the fixture of the first week of the NBA season. You can see the home team and away team players and their stats. <br>
            Simulation will after 5 seconds.
        </p>
    </div>
    @foreach($fixture as $fixtureItem)
        <div class="grid grid-cols-3 gap-6">
            <div class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $fixtureItem->homeTeam->name }} vs {{ $fixtureItem->awayTeam->name }}</h5>
            </div>
            <div class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $fixtureItem->homeTeam->name }}</h5>
                <p class="text-gray-700 dark:text-gray-300">Attack Count: X</p>
                @foreach($fixtureItem->homeTeam->players as $player)
                    <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">{{ $player->name }}</h2>
                    <ul class="max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
                        <li>
                            <span class="text-gray-900 dark:text-white">Assist:</span> X
                        </li>
                        <li>
                            <span class="text-gray-900 dark:text-white">3 Point Success Rate:</span> X
                        </li>
                        <li>
                            <span class="text-gray-900 dark:text-white">2 Point Success Rate:</span> X
                        </li>
                    </ul>
                    @if(! $loop->last)
                        <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">
                    @endif
                @endforeach
            </div>
            <div class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $fixtureItem->awayTeam->name }}</h5>
                <p class="text-gray-700 dark:text-gray-300">Attack Count: X</p>
                @foreach($fixtureItem->awayTeam->players as $player)
                    <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">{{ $player->name }}</h2>
                    <ul class="max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
                        <li>
                            <span class="text-gray-900 dark:text-white">Assist:</span> X
                        </li>
                        <li>
                            <span class="text-gray-900 dark:text-white">3 Point Success Rate:</span> X
                        </li>
                        <li>
                            <span class="text-gray-900 dark:text-white">2 Point Success Rate:</span> X
                        </li>
                    </ul>
                    @if(! $loop->last)
                        <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">
                    @endif
                @endforeach
            </div>
        </div>
        @if(! $loop->last)
            <hr class="w-48 h-1 mx-auto bg-gray-100 border-0 rounded md:my-10 dark:bg-gray-700">
        @endif
    @endforeach
@endsection
@section('js')
    <script>
        /*
        setInterval(() => {
            fetch('{{ url('simulate') }}', {
                method: 'GET',
            })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }, 1000);
        */
    </script>
@endsection
