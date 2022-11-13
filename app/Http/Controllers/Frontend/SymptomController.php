<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\Auth\AuthenticatedSessionService;
use App\Services\Backend\Organization\SymptomService;
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

    /**
     * SymptomController Constructor
     *
     * @param  AuthenticatedSessionService  $authenticatedSessionService
     * @param  SymptomService  $symptomService
     */
    public function __construct(SymptomService $symptomService)
    {
        $this->symptomService = $symptomService;
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

        $symptoms = $this->symptomService->getAllSymptoms($filters)->toArray();

        dd($symptoms);
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
