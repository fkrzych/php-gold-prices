<?php

namespace App\Service;

interface GoldServiceInterface
{
    public function getTimezone($date): string;

    public function getDateNoTimezone($date): string;

    public function getResponse($request): array;

    public function getColumn($response, $column): array;

    public function getAvg($response, $column): float;
}