@extends('layouts.master')
@section('content')
    <div class="border mb-8 hidden" id="league-area">
        <figure class="p-8 text-center bg-gray-50">
            <blockquote class="max-w-2xl mx-auto text-gray-500">
                <h3 class="text-2xl text-gray-700">
                    NBA League Table
                </h3>
                <div class="mt-4">
                    @foreach($fixture as $fixtureItem)
                        <div class="grid grid-cols-3 mt-3">
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">{{ $fixtureItem->homeTeam->name }}</span>
                            <span class="mx-2 italic">
                                <span id="league-table-{{ $fixtureItem->homeTeam->id }}">0</span>
                                -
                                <span id="league-table-{{ $fixtureItem->awayTeam->id }}">0</span>
                            </span>
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">{{ $fixtureItem->awayTeam->name }}</span>
                        </div>
                    @endforeach
                </div>
            </blockquote>
        </figure>
    </div>
    @foreach($fixture as $fixtureItem)
        <div class="p-6">
            <h5 class="mb-2 text-2xl font-bold tracking-tight dark:text-white text-center">
                {{ $fixtureItem->homeTeam->name }} <span class="text-blue-600" id="team-{{ $fixtureItem->homeTeam->id }}">0</span> - <span class="text-blue-600" id="team-{{ $fixtureItem->awayTeam->id }}">0</span> {{ $fixtureItem->awayTeam->name }}
            </h5>
        </div>
        <div class="grid grid-cols-2 gap-6">
            <div class="block p-6 bg-white border rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-2xl tracking-tight text-gray-900 dark:text-white">{{ $fixtureItem->homeTeam->name }}</h5>
                <p class="italic text-gray-700 dark:text-gray-300">Attack Count: <span id="team-attack-count-{{ $fixtureItem->homeTeam->id }}">0</span></p>
                @foreach($fixtureItem->homeTeam->players as $player)
                    <div class="rounded-lg p-2 my-2">
                        <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">{{ $player->name }}</h2>
                        <ul class="max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
                            <li>
                                <span class="dark:text-white">Assist:</span> <span id="player-assist-{{ $player->id }}">0</span>
                            </li>
                            <li>
                                <span class="dark:text-white">3 Point Success Rate:</span> %<span id="player-3-point-success-rate-{{ $player->id }}">0</span>
                            </li>
                            <li>
                                <span class="dark:text-white">2 Point Success Rate:</span> %<span id="player-2-point-success-rate-{{ $player->id }}">0</span>
                            </li>
                        </ul>
                    </div>
                    @if(! $loop->last)
                        <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">
                    @endif
                @endforeach
            </div>
            <div class="block p-6 bg-white border rounded-lg hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-2xl tracking-tight text-gray-900 dark:text-white">{{ $fixtureItem->awayTeam->name }}</h5>
                <p class="italic text-gray-700 dark:text-gray-300">Attack Count: <span id="team-attack-count-{{ $fixtureItem->awayTeam->id }}">0</span></p>
                @foreach($fixtureItem->awayTeam->players as $player)
                    <div class="rounded-lg p-2 my-2">
                        <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">{{ $player->name }}</h2>
                        <ul class="max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
                            <li>
                                <span class="dark:text-white">Assist:</span> <span id="player-assist-{{ $player->id }}">0</span>
                            </li>
                            <li>
                                <span class="dark:text-white">3 Point Success Rate:</span> %<span id="player-3-point-success-rate-{{ $player->id }}">0</span>
                            </li>
                            <li>
                                <span class="dark:text-white">2 Point Success Rate:</span> %<span id="player-2-point-success-rate-{{ $player->id }}">0</span>
                            </li>
                        </ul>
                    </div>
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
        function sendRequest(){
            fetch('{{ url('simulate') }}', {
                method: 'GET',
            })
                .then(response => response.json())
                .then(data => {
                    if (data.data) {
                        updateSimulationData(data.data.simulationData);
                        updatePlayerStats(data.data.playerStats);
                        updateSuccessRate(data.data.successRates);
                    } else {
                        fetch('{{ url('api/league-table') }}', {
                            method: 'GET',
                        })
                            .then(response => response.json())
                            .then(data => {
                                Object.keys(data).forEach(function (key) {
                                    document.getElementById('league-table-' + data[key].team_id).innerText = data[key].total_score;
                                });

                                document.getElementById('league-area').classList.remove('hidden');

                                clearInterval(interval);
                            })
                            .catch(error => {
                                console.log(error);
                            });
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        }

        let interval = setInterval(sendRequest, 2000);

        function updateSimulationData(data) {
            Object.keys(data).forEach(function (key) {
                document.getElementById('team-' + data[key].team_id).innerText = data[key].total_scores;
                document.getElementById('team-attack-count-' + data[key].team_id).innerText = data[key].attack_count;
            });
        }

        function updatePlayerStats(data) {
            Object.keys(data).forEach(function (key) {
                document.getElementById('player-assist-' + data[key].assisted_player_id).innerText = data[key].total_assists;
            });
        }

        function updateSuccessRate(data) {
            Object.keys(data).forEach(function (key) {
                document.getElementById('player-3-point-success-rate-' + data[key].player_id).innerText = data[key].success_rate_3;
                document.getElementById('player-2-point-success-rate-' + data[key].player_id).innerText = data[key].success_rate_2;
            });
        }
    </script>
@endsection
