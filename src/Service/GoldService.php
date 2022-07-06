<?php

namespace App\Service;

class GoldService implements GoldServiceInterface
{
    public function getTimezone($date): string
    {
        return substr($date, -15);
    }

    public function getDateNoTimezone($date): string
    {
        return date('Y-m-d', strtotime($date));
    }

    public function getResponse($request): array
    {
        return json_decode($request->getContent(), true);
    }

    public function getColumn($response, $column): array
    {
        return array_column($response, $column);
    }

    public function getAvg($response, $column): float
    {
        return round(array_sum(array_column($response, $column))/count($response), 2);
    }
}
