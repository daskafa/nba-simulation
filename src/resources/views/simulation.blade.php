@extends('layouts.master')
@section('content')
    <div class="league-area hidden relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Team Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Total Score
                </th>
            </tr>
            </thead>
            <tbody class="league-area-body"></tbody>
        </table>
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
                                const leagueAreaBody = document.getElementsByClassName('league-area-body')[0];

                                Object.values(data).forEach(item => {
                                    const tr = document.createElement('tr');
                                    tr.className = 'odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700';

                                    const th = document.createElement('th');
                                    th.className = 'px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white';
                                    th.textContent = item.team;

                                    const td = document.createElement('td');
                                    td.className = 'px-6 py-4';
                                    td.textContent = item.score;

                                    tr.appendChild(th);
                                    tr.appendChild(td);

                                    leagueAreaBody.appendChild(tr);
                                });

                                document.getElementsByClassName('league-area')[0].classList.remove('hidden');

                                clearInterval(interval);
                            });
                    }
                });
        }

        let interval = setInterval(sendRequest, 5000);

        function updateSimulationData(data) {
            Object.keys(data).forEach(function (key) {
                document.getElementById('team-' + data[key].team_id).innerText = data[key].score;
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
