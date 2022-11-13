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
        $total = 0;

        if ($model == 'patient') {
            $total = $this->patientService->getAllPatients($request->all())->count();
        } elseif ($model == 'symptom') {
            $total = $this->symptomService->getAllSymptoms($request->all())->count();
        } elseif ($model == 'vaccine') {
            $total = $this->vaccineService->getAllVaccines($request->all())->count();
        } else {
            $total = 0;
        }

        return response()->json(['status' => true, 'count' => number_format($total)]);
    }
}
