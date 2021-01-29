<?php

use App\Enums\AppName;
use App\Library\Url;
use App\Services\Media\Http\TransmissionSession;

$default = [
    'manual_config' => env('MANUAL_CONFIG', true),
    AppName::SONARR => [
        'url'     => env('SONARR_URL', null),
        'api_key' => env('SONARR_API_KEY', null),
        'folder'  => env('SONARR_FOLDER', null),
    ],
    AppName::RADARR => [
        'url'     => env('RADARR_URL', null),
        'api_key' => env('RADARR_API_KEY', null),
        'folder'  => env('RADARR_FOLDER', null),
    ],
    AppName::TRANSMISSION => [
        'url'        => env('TRANSMISSION_URL', null),
        'session_id' => null,
    ],
    AppName::JACKETT => [
        'url'     => env('JACKETT_HOST', null),
        'api_key' => env('JACKETT_API_KEY', null),
    ],
];

if (false === env('AUTO_CONFIG', true)) {
    try {
        $default['transmission']['session_id'] = TransmissionSession::getSession($default['transmission']['url']);
    } catch (\Throwable $th) {
        try {
            Log::error($th->getMessage());
        } catch (\Throwable $th) {
            // Do nothing
        }
    }

    return $default;
}

try {
    $files = [
        storage_path('docker/sonarr/config.xml'),
        storage_path('docker/radarr/config.xml'),
        storage_path('docker/jackett/ServerConfig.json'),
        storage_path('docker/transmission/settings.json'),
    ];

    foreach ($files as $file) {
        if (! file_exists($file)) {
            return $default;
        }
    }

    $sonarr_config = new SimpleXMLElement(
        file_get_contents($files[0]) ?: ''
    );

    $radarr_config = new SimpleXMLElement(
        file_get_contents($files[1]) ?: ''
    );

    $jackett_config = json_decode(
        file_get_contents($files[2]) ?: ''
    );

    $transmission_config = json_decode(
        file_get_contents($files[3]) ?: ''
    );

    $transmission_url = Url::baseUrl(AppName::TRANSMISSION, $transmission_config->{'rpc-port'});

    try {
        $transmission_session_id = TransmissionSession::getSession($transmission_url);
    } catch (\Throwable $th) {
        $transmission_session_id = '';
    }

    return [
        AppName::SONARR => [
            'url'     => Url::baseUrl(AppName::SONARR, $sonarr_config->Port),
            'api_key' => (string) $sonarr_config->ApiKey,
            'folder'  => env('SONARR_FOLDER', '/tv/'),
        ],
        AppName::RADARR => [
            'url'     => Url::baseUrl(AppName::RADARR, $radarr_config->Port),
            'api_key' => (string) $radarr_config->ApiKey,
            'folder'  => env('RADARR_FOLDER', '/movies/'),
        ],
        AppName::TRANSMISSION => [
            'url'        => $transmission_url,
            'session_id' => $transmission_session_id,
        ],
        AppName::JACKETT => [
            'url'     => Url::baseUrl(AppName::JACKETT, $jackett_config->Port),
            'api_key' => (string) $jackett_config->APIKey,
        ],
    ];
} catch (Throwable $exception) {
    return $default;
}
