<?php

namespace App\Http\Controllers\Backend;

use App\Services\Backend\Organization\PatientService;
use App\Services\Backend\Organization\SymptomService;
use App\Services\Backend\Organization\VaccineService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    private PatientService $patientService;

    private SymptomService $symptomService;

    private VaccineService $vaccineService;

    /**
     * DashboardController constructor.
     *
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

    public function __invoke(Request $request)
    {
        $filters = $request->except('page');

        return view('backend.dashboard', [
            'patients' => 0,
            'symptoms' => 0,
            'vaccines' => 0,
            'patientsDied' => 0,
            'patientsRecovered' => 0,
            'patientsHospitalized' => 0,
            'affectedGender' => $this->patientService->getGenderMetrics($filters),
            'affectedAge' => $this->patientService->getAgeMetrics($filters),
            'affectedMonth' => $this->patientService->getPatientLineChart($filters),
            'patientsStateMap' => $this->patientService->getPatientMap($filters),
            'vaccineOutcomes' => $this->vaccineService->getTopVaccinesOutcomesMetrics($filters),
        ]);
    }
}
