<?php

namespace App\Services;

class PrepareDataService
{
    public function prepareData(array $teamScores): array {
        $preparedArray = [];

        foreach ($teamScores as $teamScore) {
            foreach ($teamScore as $teamId => $scores) {
                $preparedArray[$teamId] = $this->initializeTeamArray($scores);

                $totalScores = $this->calculateTotalScores($scores);
                $preparedArray[$teamId]['totalScores'] = $totalScores;
                $preparedArray[$teamId]['detailed'] = $this->prepareDetailedScores($scores);
            }
        }

        return $preparedArray;
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

    public function mappingForTeamStats(array $record): array
    {
        return collect($record)->map(function($teamData, $teamId) {
            return [
                'team_id' => $teamId,
                'attack_count' => $teamData['attackCount'],
                'total_score' => $teamData['totalScores'],
            ];
        })->toArray();
    }

    public function mappingForPlayerStats(array $record): array
    {
        return collect($record)->map(function($teamData, $teamId) {
            return collect($teamData['detailed'])->map(function($score) use ($teamId) {
                return [
                    'player_id' => $score['player_id'],
                    'assisted_player_id' => $score['score'] ? $score['assisted_player_id'] : null,
                    'score' => $score['score'],
                ];
            });
        })->flatten(1)->toArray();
    }
}
