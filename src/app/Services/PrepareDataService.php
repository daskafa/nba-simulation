<?php

namespace App\Services;

use Illuminate\Support\Collection;

class PrepareDataService
{
    public function __construct(
        private readonly ScoreService $scoreService
    )
    {
        //
    }

    public function prepareData(array $teamScores): Collection
    {
        $preparedArray = [];

        foreach ($teamScores as $teamScore) {
            foreach ($teamScore as $teamId => $scores) {
                $preparedArray[$teamId] = $this->initializeTeamArray($scores);

                $totalScores = $this->calculateTotalScores($scores);
                $preparedArray[$teamId]['totalScores'] = $totalScores;
                $preparedArray[$teamId]['detailed'] = $this->prepareDetailedScores($scores);
            }
        }

        return collect($preparedArray);
    }

    private function initializeTeamArray(array $scores): array
    {
        return [
            'attackCount' => count($scores),
            'totalScores' => 0,
            'detailed' => []
        ];
    }

    private function calculateTotalScores(array $scores): int
    {
        $totalScores = 0;
        foreach ($scores as $score) {
            $totalScores += $score['score'];
        }

        return $totalScores;
    }

    private function prepareDetailedScores(array $scores): array
    {
        $detailed = [];
        foreach ($scores as $score) {
            $detailed[] = [
                'score' => $score['score'],
                'player_id' => $score['player_id'],
                'assisted_player_id' => $score['assisted_player_id'],
            ];
        }

        return $detailed;
    }

    public function mappingForTeamStats(Collection $record): Collection
    {
        return $record->map(function ($teamData, $teamId) {
            return [
                'team_id' => $teamId,
                'attack_count' => $teamData['attackCount'],
                'score' => $teamData['totalScores'],
            ];
        });
    }

    public function mappingForPlayerStats(Collection $record): Collection
    {
        return $record->map(function ($teamData, $teamId) {
            return collect($teamData['detailed'])->map(function ($score) use ($teamId) {
                return [
                    'player_id' => $score['player_id'],
                    'assisted_player_id' => $score['score'] ? $score['assisted_player_id'] : null,
                    'score' => $score['score'],
                ];
            });
        })->flatten(1);
    }

    public function prepareSimulationData(Collection $preparedData, Collection $aggregatedTeamStats): array
    {
        return $preparedData->map(function ($fixture, $key) use ($aggregatedTeamStats) {
            $score = $aggregatedTeamStats[$key]->score ?? 0;
            $totalAttackCount = $aggregatedTeamStats[$key]->total_attack_count ?? 0;

            return [
                'team_id' => $key,
                'attack_count' => $totalAttackCount,
                'score' => $score,
                'detailed' => $fixture['detailed'],
            ];
        })->toArray();
    }

    public function prepareSuccessRates(Collection $playerStats): array
    {
        return $playerStats->map(function ($row) {
            $row->success_rate_2 = round($row->score_2_count / $row->total_attempts * 100);
            $row->success_rate_3 = round($row->score_3_count / $row->total_attempts * 100);
            return $row;
        })->toArray();
    }

    public function mappingFixtureForScores(Collection $fixtures, Collection $aggregatedTeamStats): Collection
    {
        return $fixtures->map(function ($fixture) use ($aggregatedTeamStats) {
            $homeTeam = $aggregatedTeamStats->get($fixture->home_team_id);
            $awayTeam = $aggregatedTeamStats->get($fixture->away_team_id);

            $homeScore = $this->scoreService->calculateScore($homeTeam->score, $awayTeam->score);
            $awayScore = $this->scoreService->calculateScore($awayTeam->score, $homeTeam->score);

            return [
                'id' => $fixture->id,
                'home_team_score' => $homeScore,
                'away_team_score' => $awayScore,
                'home_team_id' => $fixture->home_team_id,
                'away_team_id' => $fixture->away_team_id,
            ];
        });
    }

    public function prepareLeagueTable(Collection $fixtures): Collection
    {
        return collect($fixtures)->flatMap(function ($match) {
            return [
                ['team' => $match->homeTeam->name, 'score' => $match->home_team_score],
                ['team' => $match->awayTeam->name, 'score' => $match->away_team_score],
            ];
        })->sortByDesc('score')->values();
    }
}
