<?php

use App\Services\Media\Http\TransmissionSession;

$default = [
    'manual_config' => env('MANUAL_CONFIG', true),
    'sonarr'        => [
        'host'    => env('SONARR_HOST', null),
        'port'    => env('SONARR_PORT', null),
        'api_key' => env('SONARR_API_KEY', null),
        'folder'  => env('SONARR_FOLDER', null),
    ],
    'radarr' => [
        'host'    => env('RADARR_HOST', null),
        'port'    => env('RADARR_PORT', null),
        'api_key' => env('RADARR_API_KEY', null),
        'folder'  => env('RADARR_FOLDER', null),
    ],
    'transmission' => [
        'host'       => env('TRANSMISSION_HOST', null),
        'port'       => env('TRANSMISSION_PORT', null),
        'session_id' => null,
    ],
    'jackett' => [
        'host'    => env('JACKETT_HOST', null),
        'port'    => env('JACKETT_PORT', null),
        'api_key' => env('JACKETT_API_KEY', null),
    ],
];

if (false === env('AUTO_CONFIG', true)) {
    try {
        $default['transmission']['session_id'] = TransmissionSession::getSession($default['transmission']['host'], $default['transmission']['port']);
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

    $transmission_host       = env('TRANSMISSION_HOST', 'transmission');
    $transmission_port       = (int) $transmission_config->{'rpc-port'};
    $transmission_session_id = TransmissionSession::getSession($transmission_host, strval($transmission_port));

    return [
        'sonarr' => [
            'host'    => env('SONARR_HOST', 'sonarr'),
            'port'    => (int) $sonarr_config->Port,
            'api_key' => (string) $sonarr_config->ApiKey,
            'folder'  => env('SONARR_HOST', '/tv/'),
        ],
        'radarr' => [
            'host'    => env('RADARR_HOST', 'radarr'),
            'port'    => (int) $radarr_config->Port,
            'api_key' => (string) $radarr_config->ApiKey,
            'folder'  => env('RADARR_FOLDER', '/movies/'),
        ],
        'transmission' => [
            'host'       => $transmission_host,
            'port'       => $transmission_port,
            'session_id' => $transmission_session_id,
        ],
        'jackett' => [
            'host'    => env('RADARR_HOST', 'jackett'),
            'port'    => (int) $jackett_config->Port,
            'api_key' => (string) $jackett_config->APIKey,
        ],
    ];
} catch (Throwable $exception) {
    return $default;
}