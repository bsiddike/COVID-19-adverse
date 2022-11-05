<?php

namespace App\Http\Controllers\Backend\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Organization\CreateVaccineRequest;
use App\Http\Requests\Backend\Organization\UpdateVaccineRequest;
use App\Services\Auth\AuthenticatedSessionService;
use App\Services\Backend\Organization\PatientService;
use App\Services\Backend\Organization\VaccineService;
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
use Throwable;

/**
 * @class VaccineController
 */
class VaccineController extends Controller
{
    /**
     * @var AuthenticatedSessionService
     */
    private $authenticatedSessionService;

    /**
     * @var VaccineService
     */
    private $vaccineService;

    /**
     * @var PatientService
     */
    private $patientService;

    /**
     * VaccineController Constructor
     *
     * @param AuthenticatedSessionService $authenticatedSessionService
     * @param VaccineService $vaccineService
     * @param PatientService $surveyService
     */
    public function __construct(AuthenticatedSessionService $authenticatedSessionService,
                                VaccineService              $vaccineService,
                                PatientService              $patientService)
    {
        $this->authenticatedSessionService = $authenticatedSessionService;
        $this->vaccineService = $vaccineService;
        $this->patientService = $patientService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|Factory|View
     *
     * @throws Exception
     */
    public function index(Request $request)
    {
        $filters = $request->except('page');

        $vaccines = $this->vaccineService->vaccinePaginate($filters);

        return view('backend.organization.vaccine.index', [
            'vaccines' => $vaccines,
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
        return view('backend.organization.vaccine.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateVaccineRequest $request
     * @return RedirectResponse
     *
     * @throws Exception|Throwable
     */
    public function store(CreateVaccineRequest $request): RedirectResponse
    {
        $inputs = $request->except('_token');

        $confirm = $this->vaccineService->storeVaccine($inputs);

        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);

            return redirect()->route('backend.organization.vaccines.index');
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
        if ($vaccine = $this->vaccineService->getVaccineById($id)) {
            return view('backend.organization.vaccine.show', [
                'vaccine' => $vaccine,
                'timeline' => Utility::modelAudits($vaccine),
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
        if ($vaccine = $this->vaccineService->getVaccineById($id)) {
            return view('backend.organization.vaccine.edit', [
                'vaccine' => $vaccine,
            ]);
        }

        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateVaccineRequest $request
     * @param    $id
     * @return RedirectResponse
     *
     * @throws Throwable
     */
    public function update(UpdateVaccineRequest $request, $id): RedirectResponse
    {
        $inputs = $request->except('_token', 'submit', '_method');
        $confirm = $this->vaccineService->updateVaccine($inputs, $id);

        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);

            return redirect()->route('backend.organization.vaccines.index');
        }

        notify($confirm['message'], $confirm['level'], $confirm['title']);

        return redirect()->back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @param Request $request
     * @return RedirectResponse
     *
     * @throws Throwable
     */
    public function destroy($id, Request $request)
    {
        if ($this->authenticatedSessionService->validate($request)) {
            $confirm = $this->vaccineService->destroyVaccine($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }

            return redirect()->route('backend.organization.vaccines.index');
        }
        abort(403, 'Wrong user credentials');
    }

    /**
     * Restore a Soft Deleted Resource
     *
     * @param $id
     * @param Request $request
     * @return RedirectResponse|void
     *
     * @throws Throwable
     */
    public function restore($id, Request $request)
    {
        if ($this->authenticatedSessionService->validate($request)) {
            $confirm = $this->vaccineService->restoreVaccine($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }

            return redirect()->route('backend.organization.vaccines.index');
        }
        abort(403, 'Wrong user credentials');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
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

        $vaccineExport = $this->vaccineService->exportVaccine($filters);

        $filename = 'Vaccine-' . date('Ymd-His') . '-' . $request->get('filter') . '.' . ($filters['format'] ?? 'xlsx');

        return $vaccineExport->download($filename, function ($vaccine) use ($vaccineExport, &$counter) {
            $vaccine->counter = $counter;
            $counter++;

            return $vaccineExport->map($vaccine);
        });
    }

    /**
     * Display a detail of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function ajax(Request $request): JsonResponse
    {
        $filters = $request->except('page');

        $vaccines = $this->vaccineService->getAllVaccines($filters);

        if (count($vaccines) > 0) {
            foreach ($vaccines as $index => $vaccine) {
                $vaccines[$index]->update_route = route('backend.organization.vaccines.update', $vaccine->id);
                $vaccines[$index]->survey_id = $vaccine->surveys->pluck('id')->toArray();
                $vaccines[$index]->prev_post_state_id = $vaccine->previousPostings->pluck('id')->toArray();
                $vaccines[$index]->future_post_state_id = $vaccine->futurePostings->pluck('id')->toArray();
                unset($vaccines[$index]->surveys, $vaccines[$index]->previousPostings, $vaccines[$index]->futurePostings);
            }

            $jsonReturn = ['status' => true, 'data' => $vaccines];
        } else {
            $jsonReturn = ['status' => false, 'data' => []];
        }

        return response()->json($jsonReturn, 200);
    }
}
