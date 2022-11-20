<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use OpenSpout\Common\Exception\IOException;
use OpenSpout\Common\Exception\UnsupportedTypeException;
use OpenSpout\Reader\Exception\ReaderNotOpenedException;
use Rap2hpoutre\FastExcel\FastExcel;

class PatientSeeder extends Seeder
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
        Model::unguard();
        DB::table('patients')->truncate();
        $target_dir = base_path('database/data/2020-2022-VAERSDATA/');
        $files = scandir($target_dir);
        foreach ($files as $file) {
            if (is_file($target_dir . $file) && data_limit($file)) {
                $this->command->warn("Seeding {$file} started, Date: " . date("c"));
                (new FastExcel)
                    ->withoutHeaders()
                    ->import(
                        $target_dir . $file,
                        function ($line) {
                            set_time_limit(2100);
                            ini_set('memory_limit', -1);

                            return Patient::create([
                                'vaers_id' => (int)$line[0] ?? null,
                                'recive_date' => server_date(($line[1] ?? null)),
                                'state' => clean($line[2]),
                                'age_yrs' => clean($line[3]),
                                'cage_yr' => clean($line[4]),
                                'cage_mo' => clean($line[5]),
                                'sex' => clean($line[6]),
                                'rpt_date' => server_date(($line[7] ?? null)),
                                'symptom_text' => clean($line[8]),
                                'died' => clean($line[9]),
                                'datedied' => server_date(($line[10] ?? null)),
                                'l_threat' => clean($line[11]),
                                'er_visit' => clean($line[12]),
                                'hospital' => clean($line[13]),
                                'hospdays' => clean($line[14]),
                                'x_stay' => clean($line[15]),
                                'disable' => clean($line[16]),
                                'recovd' => clean($line[17]),
                                'vax_date' => server_date(($line[18] ?? null)),
                                'onset_date' => server_date(($line[19] ?? null)),
                                'numdays' => clean($line[20]),
                                'lab_data' => clean($line[21]),
                                'v_adminby' => clean($line[22]),
                                'v_fundby' => clean($line[23]),
                                'other_meds' => clean($line[24]),
                                'cur_ill' => clean($line[25]),
                                'history' => clean($line[26]),
                                'prior_vax' => clean($line[27]),
                                'splttype' => clean($line[28]),
                                'form_vers' => clean($line[29]),
                                'todays_date' => server_date(($line[30] ?? null)),
                                'birth_defect' => clean($line[31]),
                                'ofc_visit' => clean($line[32]),
                                'er_ed_visit' => clean($line[33]),
                                'allergies' => clean($line[34]),
                            ]);
                        });
                $this->command->info("Seeded: {$file} finished, Date: " . date("c"));
            }
        }
        Model::reguard();
    }
}
