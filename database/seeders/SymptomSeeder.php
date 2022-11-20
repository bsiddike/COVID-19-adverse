<?php

namespace Database\Seeders;

use App\Models\Symptom;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use OpenSpout\Common\Exception\IOException;
use OpenSpout\Common\Exception\UnsupportedTypeException;
use OpenSpout\Reader\Exception\ReaderNotOpenedException;
use Rap2hpoutre\FastExcel\FastExcel;

class SymptomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     *
     * @throws IOException
     * @throws UnsupportedTypeException
     * @throws ReaderNotOpenedException
     */
    public function run()
    {
        DB::table('symptoms')->truncate();
        $target_dir = base_path('database/data/2020-2022-VAERSSYMPTOMS/');
        $files = scandir($target_dir);
        foreach ($files as $file) {
            if (is_file($target_dir . $file)) {
                $this->command->warn("Seeding {$file} started, Date: " . date("c"));
                (new FastExcel)
                    ->withoutHeaders()
                    ->import(
                        $target_dir . $file,
                        function ($line) {
                            set_time_limit(2100);
                            ini_set('memory_limit', -1);

                            /**
                             * 0 => "VAERS_ID", 1 => "SYMPTOM1", 2 => "SYMPTOMVERSION1", 3 => "SYMPTOM2"
                             * 4 => "SYMPTOMVERSION2", 5 => "SYMPTOM3", 6 => "SYMPTOMVERSION3"
                             * 7 => "SYMPTOM4", 8 => "SYMPTOMVERSION4", 9 => "SYMPTOM5"
                             * 10 => "SYMPTOMVERSION5"
                             */

                            set_time_limit(2100);
                            ini_set('memory_limit', -1);

                            return Symptom::create([
                                'vaers_id' => (int)clean($line[0]),
                                'symptom1' => clean($line[1]),
                                'symptomversion1' => clean($line[2]),
                                'symptom2' => clean($line[3]),
                                'symptomversion2' => clean($line[4]),
                                'symptom3' => clean($line[5]),
                                'symptomversion3' => clean($line[6]),
                                'symptom4' => clean($line[7]),
                                'symptomversion4' => clean($line[8]),
                                'symptom5' => clean($line[9]),
                                'symptomversion5' => clean($line[10]),
                            ]);
                        });
                $this->command->info("Seeded: {$file} finished, Date: " . date("c"));
            }
        }
    }
}