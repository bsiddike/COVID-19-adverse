<?php

namespace Database\Seeders;

use App\Models\Symptom;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Rap2hpoutre\FastExcel\FastExcel;

class SymptomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        (new FastExcel)
            ->withoutHeaders()
            ->import(base_path('database/data/2022VAERSSYMPTOMS.csv'), function ($line) {
                /*0 => "VAERS_ID"
                  1 => "SYMPTOM1"
                  2 => "SYMPTOMVERSION1"
                  3 => "SYMPTOM2"
                  4 => "SYMPTOMVERSION2"
                  5 => "SYMPTOM3"
                  6 => "SYMPTOMVERSION3"
                  7 => "SYMPTOM4"
                  8 => "SYMPTOMVERSION4"
                  9 => "SYMPTOM5"
                  10 => "SYMPTOMVERSION5"
                */

                if ($line[0] != 'VAERS_ID') {
                    return Symptom::create([
                        'vaers_id' => clean($line[0]),
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
                }

                return null;
            });

        Model::reguard();
    }
}
