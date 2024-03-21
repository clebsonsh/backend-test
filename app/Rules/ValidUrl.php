<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class ValidUrl implements Rule
{
    private string $message = '';
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        match (true) {
            $this->isUrlInvalid($value) => $this->message = 'The URL is not valid.',
            $this->isInvalidScheme($value) => $this->message = 'The URL must use the HTTPS protocol.',
            $this->isUrlSameToServerUrl($value) => $this->message = 'The URL must be different from the server URL.',
            $this->isUrlOffiline($value) => $this->message = 'The URL must be online.',
            $this->doesUrlHaveNullQueryParams($value) => $this->message = 'The URL must not have null query parameters.',
            default => null,
        };

        return $this->message === '';
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }

    private function isUrlInvalid(string $url): bool
    {
        return !filter_var($url, FILTER_VALIDATE_URL);
    }

    private function parseUrl(string $url): string
    {
        return parse_url($url, PHP_URL_SCHEME) . '://' . parse_url($url, PHP_URL_HOST);
    }

    private function isInvalidScheme(string $url): bool
    {
        return !in_array(parse_url($url, PHP_URL_SCHEME), ['https']);
    }

    private function isUrlSameToServerUrl(string $url): bool
    {
        return $this->parseUrl($url) === $this->parseUrl(config('app.url'));
    }

    private function isUrlOffiline(string $url): bool
    {
        try {
            $response = Http::get($url);
        } catch (\Exception $e) {
            return true;
        }

        $statusCode = $response->status();

        return !in_array($statusCode, [Response::HTTP_OK, Response::HTTP_CREATED]);
    }

    private function doesUrlHaveNullQueryParams(string $url): bool
    {
        $query = parse_url($url, PHP_URL_QUERY);

        if ($query === null) {
            return false;
        }

        $querys = explode('&', $query);

        foreach ($querys as $query) {
            [$key, $value] = explode('=', $query);
            if (!$value) {
                return true;
            }
        }

        return false;
    }
}
