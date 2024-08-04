<?php

namespace App\Services;

use Illuminate\Support\Collection;

class PrepareDataService
{
    public function prepareData(array $teamScores): Collection {
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

    private function initializeTeamArray(array $scores): array {
        return [
            'attackCount' => count($scores),
            'totalScores' => 0,
            'detailed' => []
        ];
    }

    private function calculateTotalScores(array $scores): int {
        $totalScores = 0;
        foreach ($scores as $score) {
            $totalScores += $score['score'];
        }

        return $totalScores;
    }

    private function prepareDetailedScores(array $scores): array {
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
        return $record->map(function($teamData, $teamId) {
            return [
                'team_id' => $teamId,
                'attack_count' => $teamData['attackCount'],
                'total_score' => $teamData['totalScores'],
            ];
        });
    }

    public function mappingForPlayerStats(Collection $record): Collection
    {
        return $record->map(function($teamData, $teamId) {
            return collect($teamData['detailed'])->map(function($score) use ($teamId) {
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
            $totalScore = $aggregatedTeamStats[$key]->total_score ?? 0;
            $totalAttackCount = $aggregatedTeamStats[$key]->total_attack_count ?? 0;

            return [
                'team_id' => $key,
                'attack_count' => $totalAttackCount,
                'total_scores' => $totalScore,
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
}
