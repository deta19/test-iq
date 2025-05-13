<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Orase;
use App\Models\Judets;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;

class ImportOraseCSV extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:importorasecsv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'import orase from csv file in storage folder';

    /**
     * Execute the console command.
     */
    public function handle()
    {
         $path = storage_path('orase.csv');

        if (!file_exists($path)) {
            $this->error('orase.csv not found in storage');
            return;
        }

        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0); // assumes headers exist

        foreach ($csv as $record) {

            $judete = Judets::firstOrCreate(
                ['nume' => $record['JUDET']],
                ['cod' => $record['JUDET AUTO']]
            );

            Orase::updateOrCreate(
                [
                    'nume' => $record['NUME'], 
                    'judet_id' => $judete->id
                ],
                [
                    'coord_x' => $record['X'],
                    'coord_y' => $record['Y'],
                    'populatie' => $record['POPULATIE (in 2002)'],
                    'regiune' => $record['REGIUNE'],
                ]
            );
        }

        $this->info('Cities imported successfully.');
    }
}
