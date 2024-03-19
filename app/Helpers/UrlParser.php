<?php

namespace App\Helpers;

class UrlParser
{
    public static function buildUrl(string $url, array $query): string
    {
        $baseUrl = self::getUrlWithoutQueryString($url);
        $queryString = self::getQueryStringArray($url);
        $query = array_merge($queryString, $query);

        if (empty($query)) {
            return $baseUrl;
        }

        return $baseUrl . '?' . http_build_query($query);
    }

    private static function getUrlWithoutQueryString(string $url): string
    {
        return explode('?', $url)[0];
    }

    private static function getQueryString(string $url): string
    {
        return explode('?', $url)[1] ?? '';
    }

    private static function getQueryStringArray(string $url): array
    {
        if (!strpos($url, '?')) {
            return [];
        }

        $queryString = self::getQueryString($url);
        $queryStringArray = explode('&', $queryString) ?? [];
        $queryArray = [];

        foreach ($queryStringArray as $query) {
            [$key, $value] = explode('=', $query);
            $queryArray[$key] = $value;
        }

        return $queryArray;
    }

    public static function getQueryStringFromArray(array $query): string
    {
        return http_build_query($query);
    }
}
