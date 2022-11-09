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
            'patients' => $this->patientService->getAllPatients($filters)->count(),
            'symptoms' => $this->symptomService->getAllSymptoms($filters)->count(),
            'vaccines' => $this->vaccineService->getAllVaccines($filters)->count(),
            'patientsDied' => $this->patientService->getAllPatients(array_merge($filters, ['died' => true]))->count(),
            'patientsRecovered' => $this->patientService->getAllPatients(array_merge($filters, ['recovered' => true]))->count(),
            'patientsHospitalized' => $this->patientService->getAllPatients(array_merge($filters, ['hospitalized' => true]))->count(),
            'affectedGender' => $this->patientService->getGenderMetrics($filters),
            'affectedAge' => $this->patientService->getAgeMetrics($filters),
            'affectedMonth' => $this->patientService->getPatientLineChart($filters),
            'patientsStateMap' => $this->patientService->getPatientMap($filters),
            'vaccineOutcomes' => $this->vaccineService->getTopVaccinesOutcomesMetrics($filters),
        ]);
    }

}
