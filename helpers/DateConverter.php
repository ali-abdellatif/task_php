<?php

class DateConverter
{
    public static function convertToHijri($gregorianDate)
    {
        // Your conversion logic here...

        // For simplicity, let's use the previous basic conversion logic
        $timestamp = strtotime($gregorianDate);
        $hijriYear = intval((date('Y', $timestamp) - 622) * 0.9702);
        $hijriMonth = intval((date('m', $timestamp) + 2) / 12 + (date('m', $timestamp) + 2) % 12);
        $hijriDay = intval((date('d', $timestamp) * 0.9702));
        $formattedHijriDate = sprintf('%04d-%02d-%02d', $hijriYear, $hijriMonth, $hijriDay);

        return $formattedHijriDate;
    }

    public static function gregorianToHijri($gregorianDate)
    {
        $timestamp = strtotime($gregorianDate);

        // This is a very basic approximation and may not be accurate for historical dates
        $hijriYear = intval(($timestamp - strtotime('622-07-16')) / (365.25 * 24 * 3600)) + 1;

        $days = floor(($timestamp - strtotime("{$hijriYear}-01-01")) / (24 * 3600));
        $hijriMonth = floor($days / 29.5) + 1;
        $hijriDay = $days - floor(29.5 * ($hijriMonth - 1)) + 1;

        return sprintf('%04d-%02d-%02d', $hijriYear, $hijriMonth, $hijriDay);
    }
}