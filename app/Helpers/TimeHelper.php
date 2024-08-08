<?php


namespace App\Helpers;


class TimeHelper
{
    public static function secondsToFormatTime(int $seconds):string
    {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $seconds = $seconds % 60;

        // Форматирование времени в строку H:i:s
        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }
}
