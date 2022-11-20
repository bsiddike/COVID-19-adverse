<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Vaccine;
use App\Services\Backend\Organization\PatientService;
use App\Services\Backend\Organization\SymptomService;
use App\Services\Backend\Organization\VaccineService;
use App\Supports\Utility;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @class SymptomController
 */
class SymptomController extends Controller
{
    /**
     * @var SymptomService
     */
    private $symptomService;

    private VaccineService $vaccineService;

    private PatientService $patientService;

    /**
     * SymptomController Constructor
     *
     * @param  SymptomService  $symptomService
     * @param  VaccineService  $vaccineService
     * @param  PatientService  $patientService
     */
    public function __construct(SymptomService $symptomService,
                                VaccineService $vaccineService,
                                PatientService $patientService)
    {
        $this->symptomService = $symptomService;
        $this->vaccineService = $vaccineService;
        $this->patientService = $patientService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return Application|Factory|View
     *
     * @throws Exception
     */
    public function index(Request $request)
    {
        $filters = $request->except('page');

        $symptoms = $this->symptomService->symptomPaginate($filters);

        return view('frontend.symptom.index', [
            'symptoms' => $symptoms,
        ]);
    }

    /***
     * @param string $type
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function charts(string $type, Request $request)
    {
        $filters = $request->except('page');

        $result = [];

        switch ($type) {
            case 'vaccine-outcome':
                $result = $this->vaccineService->getTopVaccinesOutcomesMetrics($filters);
                break;
            case 'symptom-gender':
                $result = $this->symptomService->getSymptomGenderBarMetrics($filters, 'symptom1');
                break;
            case 'asset-age':
                $result = $this->patientService->getAgeMetrics($filters);
                break;
            case 'patient-state-map':
                $result = $this->patientService->getPatientMap($filters);
                break;
        }

        return response()->json($result);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  int  $symptom_number
     * @param  Request  $request
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function search(int $symptom_number, Request $request)
    {
        $key = 'symptom'.$symptom_number;

        $filters[$key] = $request->get('query');

        $filters['search_column'] = $key;

        $symptoms = $this->symptomService->getAllSymptoms($filters)->pluck($key)->toArray();

        return response()->json($symptoms, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function register(Request $request)
    {
        $filters = $request->except(['submit', '_token']);
        $vaccines = array_unique(Vaccine::all()->where('vax_type', 'COVID19')->pluck('vax_name')->toArray());

        $filters['other_meds_not_none'] = 'no';
        $symptoms = $this->symptomService->symptomPaginate($filters, ['vaccine', 'patient']);

        return view('frontend.patient.apply', [
            'symptoms' => $symptoms,
            'vaccines' => $vaccines,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param    $id
     * @return Application|Factory|View
     *
     * @throws Exception
     */
    public function show($id)
    {
        if ($symptom = $this->symptomService->getSymptomById($id)) {
            return view('frontend.symptom.show', [
                'symptom' => $symptom,
                'timeline' => Utility::modelAudits($symptom),
            ]);
        }

        abort(404);
    }
}
