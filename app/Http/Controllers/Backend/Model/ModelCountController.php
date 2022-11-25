<?php

namespace App\Http\Controllers\Backend\Model;

use App\Http\Controllers\Controller;
use App\Services\Backend\Organization\PatientService;
use App\Services\Backend\Organization\SymptomService;
use App\Services\Backend\Organization\VaccineService;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ModelCountController extends Controller
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
     * @param  string  $model
     * @param  Request  $request
     * @return JsonResponse
     *
     * @throws BindingResolutionException|Exception
     */
    public function __invoke(string $model, Request $request)
    {
        $filters = $request->all();

        if ($model == 'patient') {
            $filters['metric'] = 'total_patients';
            $total = $this->patientService->getAllPatients($filters)->first()->aggregate;
        } elseif ($model == 'symptom') {
            $filters['metric'] = 'total_symptoms';
            $total = $this->symptomService->getAllSymptoms($filters)->first()->aggregate;
        } elseif ($model == 'vaccine') {
            $filters['metric'] = 'total_vaccines';
            $total = $this->vaccineService->getAllVaccines($filters)->first()->aggregate;
        } else {
            $total = 0;
        }

        return response()->json(['status' => true, 'count' => number_format($total)]);
    }
}
