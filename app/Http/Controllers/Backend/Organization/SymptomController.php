<?php

namespace App\Http\Controllers\Backend\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Organization\CreateSymptomRequest;
use App\Http\Requests\Backend\Organization\UpdateSymptomRequest;
use App\Services\Auth\AuthenticatedSessionService;
use App\Services\Backend\Organization\SymptomService;
use App\Supports\Constant;
use App\Supports\Utility;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use OpenSpout\Common\Exception\InvalidArgumentException;
use OpenSpout\Common\Exception\IOException;
use OpenSpout\Common\Exception\UnsupportedTypeException;
use OpenSpout\Writer\Exception\WriterNotOpenedException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * @class SymptomController
 */
class SymptomController extends Controller
{
    /**
     * @var AuthenticatedSessionService
     */
    private $authenticatedSessionService;

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
    public function __construct(AuthenticatedSessionService $authenticatedSessionService,
                                SymptomService $symptomService)
    {
        $this->authenticatedSessionService = $authenticatedSessionService;
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

        return view('backend.organization.symptom.index', [
            'symptoms' => $symptoms,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     */
    public function create()
    {
        $enables = [];
        foreach (Constant::ENABLED_OPTIONS as $field => $label) {
            $enables[$field] = __('common.'.$label);
        }

        return view('backend.organization.symptom.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateSymptomRequest  $request
     * @return RedirectResponse
     *
     * @throws Exception|\Throwable
     */
    public function store(Request $request): RedirectResponse
    {
        $inputs = $request->except('_token');

        $confirm = $this->symptomService->storeSymptom($inputs);

        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);

            return redirect()->route('backend.organization.symptoms.index');
        }

        notify($confirm['message'], $confirm['level'], $confirm['title']);

        return redirect()->back()->withInput();
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
            return view('backend.organization.symptom.show', [
                'symptom' => $symptom,
                'timeline' => Utility::modelAudits($symptom),
            ]);
        }

        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return Application|Factory|View
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     */
    public function edit($id)
    {
        if ($symptom = $this->symptomService->getSymptomById($id)) {
            $enables = [];
            foreach (Constant::ENABLED_OPTIONS as $field => $label) {
                $enables[$field] = __('common.'.$label);
            }

            return view('backend.organization.symptom.edit', [
                'symptom' => $symptom,
                'enables' => $enables,
                'states' => $this->stateService->getStateDropdown(['enabled' => Constant::ENABLED_OPTION, 'type' => 'district', 'sort' => ((session()->get('locale') == 'bd') ? 'native' : 'name'), 'direction' => 'asc'], (session()->get('locale') == 'bd')),
                'surveys' => $this->surveyService->getSurveyDropDown(),
                'genders' => $this->catalogService->getCatalogDropdown(['type' => Constant::CATALOG_TYPE['GENDER']], 'bn'),
                'exam_dropdown' => $this->examLevelService->getExamLevelDropdown(['id' => [1, 2, 3, 4]]),
            ]);
        }

        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateSymptomRequest  $request
     * @param    $id
     * @return RedirectResponse
     *
     * @throws \Throwable
     */
    public function update(UpdateSymptomRequest $request, $id): RedirectResponse
    {
        $inputs = $request->except('_token', 'submit', '_method');
        $confirm = $this->symptomService->updateSymptom($inputs, $id);

        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);

            return redirect()->route('backend.organization.symptoms.index');
        }

        notify($confirm['message'], $confirm['level'], $confirm['title']);

        return redirect()->back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @param  Request  $request
     * @return RedirectResponse
     *
     * @throws \Throwable
     */
    public function destroy($id, Request $request)
    {
        if ($this->authenticatedSessionService->validate($request)) {
            $confirm = $this->symptomService->destroySymptom($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }

            return redirect()->route('backend.organization.symptoms.index');
        }
        abort(403, 'Wrong user credentials');
    }

    /**
     * Restore a Soft Deleted Resource
     *
     * @param $id
     * @param  Request  $request
     * @return RedirectResponse|void
     *
     * @throws \Throwable
     */
    public function restore($id, Request $request)
    {
        if ($this->authenticatedSessionService->validate($request)) {
            $confirm = $this->symptomService->restoreSymptom($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }

            return redirect()->route('backend.organization.symptoms.index');
        }
        abort(403, 'Wrong user credentials');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return string|StreamedResponse
     *
     * @throws IOException
     * @throws InvalidArgumentException
     * @throws UnsupportedTypeException
     * @throws WriterNotOpenedException
     * @throws Exception
     */
    public function export(Request $request)
    {
        $counter = 1;

        $filters = $request->except('page');

        $symptomExport = $this->symptomService->exportSymptom($filters);

        $filename = 'Symptom-'.date('Ymd-His').'-'.$request->get('filter').'.'.($filters['format'] ?? 'xlsx');

        return $symptomExport->download($filename, function ($symptom) use ($symptomExport, &$counter) {
            $symptom->counter = $counter;
            $counter++;

            return $symptomExport->map($symptom);
        });
    }

    /**
     * Display a detail of the resource.
     *
     * @param  Request  $request
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function ajax(Request $request): JsonResponse
    {
        $filters = $request->except('page');

        $symptoms = $this->symptomService->getAllSymptoms($filters);

        if (count($symptoms) > 0) {
            foreach ($symptoms as $index => $symptom) {
                $symptoms[$index]->update_route = route('backend.organization.symptoms.update', $symptom->id);
                $symptoms[$index]->survey_id = $symptom->surveys->pluck('id')->toArray();
                $symptoms[$index]->prev_post_state_id = $symptom->previousPostings->pluck('id')->toArray();
                $symptoms[$index]->future_post_state_id = $symptom->futurePostings->pluck('id')->toArray();
                unset($symptoms[$index]->surveys, $symptoms[$index]->previousPostings, $symptoms[$index]->futurePostings);
            }

            $jsonReturn = ['status' => true, 'data' => $symptoms];
        } else {
            $jsonReturn = ['status' => false, 'data' => []];
        }

        return response()->json($jsonReturn, 200);
    }
}
