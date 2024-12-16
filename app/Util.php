<?php

namespace App;

use App\Facades\Settings;
use DateTimeInterface;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;

class Util
{
    public static function config(string $key, mixed $default = null)
    {
        return Config::get('mixpost.'.$key, $default);
    }

    public static function isMixpostRequest(Request $request): bool
    {
        dd('isMixpostRequest: Check if the request is a Mixpost request');
        return true;
    }

    public static function convertTimeToUTC(string|DateTimeInterface|null $time = null, DateTimeZone|string|null $tz = null): Carbon
    {
        return Carbon::parse($time, $tz ?: Settings::get('timezone'))->utc();
    }

    public static function timeFormat(): string
    {
        return Settings::get('time_format') == 24 ? 'H:i' : 'h:ia';
    }

    public static function removeHtmlTags($string): string
    {
        if (!$string) {
            return '';
        }

        $text = trim(strip_tags($string));

        return html_entity_decode($text);
    }

    public static function isPublicDomainUrl(string $url): bool
    {
        $parsedUrl = parse_url($url);

        if (empty($parsedUrl['host'])) {
            return false;
        }

        // Validate URL format
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            return false;
        }

        // Check if the host part is an IP address (both IPv4 and IPv6)
        if (filter_var($parsedUrl['host'], FILTER_VALIDATE_IP)) {
            return false;
        }

        if (in_array($parsedUrl['host'], ['localhost', '127.0.0.1', '::1'])) {
            return false;
        }

        return true;
    }
}
