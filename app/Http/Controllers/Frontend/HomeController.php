<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\Backend\Organization\PatientService;
use App\Services\Backend\Organization\SymptomService;
use App\Services\Backend\Organization\VaccineService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private PatientService $patientService;

    private SymptomService $symptomService;

    private VaccineService $vaccineService;

    /**
     * @param  PatientService  $patientService
     * @param  SymptomService  $symptomService
     * @param  VaccineService  $vaccineService
     */
    public function __construct(PatientService $patientService,
                                SymptomService $symptomService,
                                VaccineService $vaccineService)
    {
        $this->patientService = $patientService;
        $this->symptomService = $symptomService;
        $this->vaccineService = $vaccineService;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * @throws \Exception
     */
    public function __invoke(Request $request)
    {
        $filters = $request->except('page');

        return view('frontend.home', [
            'patients' => 0,
            'symptoms' => 0,
            'vaccines' => 0,
            'patientsDied' => 0,

        ]);
    }
}
