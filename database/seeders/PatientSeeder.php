<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Rap2hpoutre\FastExcel\FastExcel;

class PatientSeeder extends Seeder
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
        $folderName = 'data/';
        foreach ($years as $year) {
            if (is_dir($basePath.$year.$folderName)) {
                $arrFiles = scandir($basePath.$year.$folderName);
                foreach ($arrFiles as $arrFile) {
                    if (is_file($basePath.$year.$folderName.$arrFile)) {
                        //dump($basePath.$year.$folderName.$arrFile);

                        (new FastExcel)
                            ->withoutHeaders()
                            ->import(
                                $basePath.$year.$folderName.$arrFile,
                                function ($line) use ($basePath, $year, $folderName, $arrFile) {
                                    /*0 => "VAERS_ID"
                                      1 => "RECVDATE"
                                      2 => "STATE"
                                      3 => "AGE_YRS"
                                      4 => "CAGE_YR"
                                      5 => "CAGE_MO"
                                      6 => "SEX"
                                      7 => "RPT_DATE"
                                      8 => "SYMPTOM_TEXT"
                                      9 => "DIED"
                                      10 => "DATEDIED"
                                      11 => "L_THREAT"
                                      12 => "ER_VISIT"
                                      13 => "HOSPITAL"
                                      14 => "HOSPDAYS"
                                      15 => "X_STAY"
                                      16 => "DISABLE"
                                      17 => "RECOVD"
                                      18 => "VAX_DATE"
                                      19 => "ONSET_DATE"
                                      20 => "NUMDAYS"
                                      21 => "LAB_DATA"
                                      22 => "V_ADMINBY"
                                      23 => "V_FUNDBY"
                                      24 => "OTHER_MEDS"
                                      25 => "CUR_ILL"
                                      26 => "HISTORY"
                                      27 => "PRIOR_VAX"
                                      28 => "SPLTTYPE"
                                      29 => "FORM_VERS"
                                      30 => "TODAYS_DATE"
                                      31 => "BIRTH_DEFECT"
                                      32 => "OFC_VISIT"
                                      33 => "ER_ED_VISIT"
                                      34 => "ALLERGIES"
                                    */

                                    if ($line[0] != 'VAERS_ID') {
                                        $this->command->line($basePath.$year.$folderName.$arrFile.'--'
                                                             .date('Y-m-d H:i:s'));
                                        set_time_limit(2100);
                                        ini_set('memory_limit', -1);

                                        return Patient::create(
                                            [
                                                'vaers_id' => (int) $line[0] ?? null,
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
