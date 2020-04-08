<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateJSSeederData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:js_seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates a seeder skeleton for JS models.';

    protected $seedExportLocation;
    protected $seedSourceFileLocation;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->seedExportLocation = resource_path('js/seed');
        $this->seedSourceFileLocation = resource_path('js/seed/index.json');
    }

    public function getSourceData()
    {
        return json_decode(file_get_contents($this->seedSourceFileLocation), true);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $seedSourceData = $this->getSourceData();

        foreach ($seedSourceData as $seedSourceRecord) {
            $entity = 'App\Entities\\' . $seedSourceRecord['entity'];

            if (array_key_exists('filter', $seedSourceRecord)) {
                $obj = $entity::where(...$seedSourceRecord['filter'])->firstOrFail();
            } else {
                $obj = $entity::first();
            }

            if (array_key_exists('relationships', $seedSourceRecord)
            && is_array($seedSourceRecord['relationships'])
            && !empty($seedSourceRecord['relationships'])) {
                $obj->load(
                    ...$seedSourceRecord['relationships']
                );
            }

            $this->storeSeedData($obj->toJson(JSON_PRETTY_PRINT), strtolower($seedSourceRecord['name']) . '.json');
        }
    }

    public function storeSeedData($data, $fileName)
    {
        file_put_contents($this->seedExportLocation . '/' . $fileName, $data);
    }
}
