<?php

namespace Database\Seeders;

use App\Models\Vaccine;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Rap2hpoutre\FastExcel\FastExcel;

class VaccineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $basePath = base_path('database/data/');
        $years = ['2019/', '2020/', '2021/', '2022/'];
        $folderName = 'vax/';
        foreach ($years as $year) {
            if (is_dir($basePath . $year . $folderName)) {
                $arrFiles = scandir($basePath . $year . $folderName);
                foreach ($arrFiles as $arrFile) {
                    if (is_file($basePath . $year . $folderName . $arrFile)) {
                        (new FastExcel)
                            ->withoutHeaders()
                            ->import(
                                $basePath . $year . $folderName . $arrFile,
                                function ($line) use ($basePath, $year, $folderName, $arrFile) {
                                    /**
                                     * 0 => "VAERS_ID", 1 => "VAX_TYPE", 2 => "VAX_MANU", 3 => "VAX_LOT"
                                     * 4 => "VAX_DOSE_SERIES", 5 => "VAX_ROUTE", 6 => "VAX_SITE", 7 => "VAX_NAME"
                                     */
                                    if ($line[0] != 'VAERS_ID') {
                                        $this->command->line(
                                            $basePath . $year . $folderName . $arrFile . '--'
                                            . date('Y-m-d H:i:s')
                                        );
                                        set_time_limit(2100);
                                        ini_set('memory_limit', -1);
                                        return Vaccine::create(
                                            [
                                                'vaers_id' => (int)$line[0] ?? null,
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
                    }
                }
            }
        }

        Model::reguard();
    }
}
