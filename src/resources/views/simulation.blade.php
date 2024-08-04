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
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                    {{ $fixtureItem->homeTeam->name }} <span id="team-{{ $fixtureItem->homeTeam->id }}">0</span> - <span id="team-{{ $fixtureItem->awayTeam->id }}">0</span> {{ $fixtureItem->awayTeam->name }}
                </h5>
            </div>
            <div class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-2xl tracking-tight text-gray-900 dark:text-white">{{ $fixtureItem->homeTeam->name }}</h5>
                <p class="text-gray-700 dark:text-gray-300">Attack Count: <span id="team-attack-count-{{ $fixtureItem->homeTeam->id }}">0</span></p>
                @foreach($fixtureItem->homeTeam->players as $player)
                    <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">{{ $player->name }}</h2>
                    <ul class="max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
                        <li>
                            <span class="text-gray-900 dark:text-white">Assist:</span> <span id="player-assist-{{ $player->id }}">0</span>
                        </li>
                        <li>
                            <span class="text-gray-900 dark:text-white">3 Point Success Rate:</span> %<span id="player-3-point-success-rate-{{ $player->id }}">0</span>
                        </li>
                        <li>
                            <span class="text-gray-900 dark:text-white">2 Point Success Rate:</span> %<span id="player-2-point-success-rate-{{ $player->id }}">0</span>
                        </li>
                    </ul>
                    @if(! $loop->last)
                        <hr class="h-px my-2 bg-gray-200 border-0 dark:bg-gray-700">
                    @endif
                @endforeach
            </div>
            <div class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-2xl tracking-tight text-gray-900 dark:text-white">{{ $fixtureItem->awayTeam->name }}</h5>
                <p class="text-gray-700 dark:text-gray-300">Attack Count: <span id="team-attack-count-{{ $fixtureItem->awayTeam->id }}">0</span></p>
                @foreach($fixtureItem->awayTeam->players as $player)
                    <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">{{ $player->name }}</h2>
                    <ul class="max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
                        <li>
                            <span class="text-gray-900 dark:text-white">Assist:</span> <span id="player-assist-{{ $player->id }}">0</span>
                        </li>
                        <li>
                            <span class="text-gray-900 dark:text-white">3 Point Success Rate:</span> %<span id="player-3-point-success-rate-{{ $player->id }}">0</span>
                        </li>
                        <li>
                            <span class="text-gray-900 dark:text-white">2 Point Success Rate:</span> %<span id="player-2-point-success-rate-{{ $player->id }}">0</span>
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
        setInterval(() => {
            fetch('{{ url('simulate') }}', {
                method: 'GET',
            })
                .then(response => response.json())
                .then(data => {
                    console.log(data)
                    updateSimulationData(data.simulationData);
                    updatePlayerStats(data.playerStats);
                    updateSuccessRate(data.successRates);
                })
                .catch(error => {
                    console.log(error);
                });
        }, 2000);

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
