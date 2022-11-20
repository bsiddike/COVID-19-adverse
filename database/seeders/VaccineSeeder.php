<?php

namespace Database\Seeders;

use App\Models\Vaccine;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use OpenSpout\Common\Exception\IOException;
use OpenSpout\Common\Exception\UnsupportedTypeException;
use OpenSpout\Reader\Exception\ReaderNotOpenedException;
use Rap2hpoutre\FastExcel\FastExcel;

class VaccineSeeder extends Seeder
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
        DB::table('vaccines')->truncate();
        $target_dir = base_path('database/data/2020-2022-VAERSVAX/');
        $files = scandir($target_dir);
        foreach ($files as $file) {
            if (is_file($target_dir . $file)) {
                $this->command->warn("Seeding {$file} started, Date: " . date("c"));
                (new FastExcel)
                    ->withoutHeaders()
                    ->import(
                        $target_dir . $file,
                        function ($line) {
                            /**
                             * 0 => "VAERS_ID", 1 => "VAX_TYPE", 2 => "VAX_MANU", 3 => "VAX_LOT"
                             * 4 => "VAX_DOSE_SERIES", 5 => "VAX_ROUTE", 6 => "VAX_SITE", 7 => "VAX_NAME"
                             */
                            set_time_limit(2100);
                            ini_set('memory_limit', -1);

                            return Vaccine::create([
                                'vaers_id' => (int)$line[0] ?? null,
                                'vax_type' => clean($line[1]),
                                'vax_manu' => clean($line[2]),
                                'vax_lot' => clean($line[3]),
                                'vax_dose_series' => clean($line[4]),
                                'vax_route' => clean($line[5]),
                                'vax_site' => clean($line[6]),
                                'vax_name' => clean($line[7]),
                            ]);
                        });
                $this->command->info("Seeded: {$file} finished, Date: " . date("c"));
            }
        }
    }
}
