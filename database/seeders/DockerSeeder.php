<?php

namespace Database\Seeders;

use App\Models\Radarr\DownloadClient as RadarrDownloadClient;
use App\Models\Radarr\Indexer as RadarrIndexer;
use App\Models\Radarr\RootFolder as RadarrRootFolder;
use App\Models\Sonarr\DownloadClient as SonarrDownloadClient;
use App\Models\Sonarr\Indexer as SonarrIndexer;
use App\Models\Sonarr\RootFolder as SonarrRootFolder;
use Illuminate\Database\Seeder;

class DockerSeeder extends Seeder
{
    public function run(): void
    {
        if (config('docker.manual_config')) {
            return;
        }

        $this->seed(SonarrDownloadClient::class);
        $this->seed(SonarrIndexer::class);
        $this->seed(SonarrRootFolder::class);

        $this->seed(RadarrDownloadClient::class);
        $this->seed(RadarrIndexer::class);
        $this->seed(RadarrRootFolder::class);
    }

    private function seed(string $model): void
    {
        $message = $model::getDescription();

        if ($model::exists()) {
            $model::query()->delete();
        }

        $model::create($model::getDefaults());

        $this->command->info("Created {$message}!");
    }
}
