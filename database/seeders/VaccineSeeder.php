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
    public function run(...$parameters)
    {
        DB::table('vaccines')->truncate();

        $basePath = $parameters[0];
        $years = $parameters[1];
        $folderName = 'vax/';
        foreach ($years as $year) {
            if (is_dir($basePath.$year.$folderName)) {
                $arrFiles = scandir($basePath.$year.$folderName);
                foreach ($arrFiles as $arrFile) {
                    if (is_file($basePath.$year.$folderName.$arrFile)) {
                        $start_time = microtime(true);
                        $this->command->line("Seeding : {$year} {$folderName} {$arrFile}");

                        (new FastExcel)
                            ->withoutHeaders()
                            ->import(
                                $basePath.$year.$folderName.$arrFile,
                                function ($line) {
                                    /**
                                     * 0 => "VAERS_ID", 1 => "VAX_TYPE", 2 => "VAX_MANU", 3 => "VAX_LOT"
                                     * 4 => "VAX_DOSE_SERIES", 5 => "VAX_ROUTE", 6 => "VAX_SITE", 7 => "VAX_NAME"
                                     */
                                    if ($line[0] != 'VAERS_ID') {
                                        set_time_limit(2100);
                                        ini_set('memory_limit', -1);

                                        return Vaccine::create(
                                            [
                                                'vaers_id' => (int) $line[0] ?? null,
                                                'vax_type' => clean($line[1]),
                                                'vax_manu' => clean($line[2]),
                                                'vax_lot' => clean($line[3]),
                                                'vax_dose_series' => clean($line[4]),
                                                'vax_route' => clean($line[5]),
                                                'vax_site' => clean($line[6]),
                                                'vax_name' => clean($line[7]),
                                            ]
                                        );
                                    }

                                    return null;
                                }
                            );

                        $this->command->line('Seeded In: '.((microtime(true) - $start_time) * 1000000).'sec');
                    }
                }
            }
        }
    }
}
