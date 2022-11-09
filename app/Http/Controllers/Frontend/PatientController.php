<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\Auth\AuthenticatedSessionService;
use App\Services\Backend\Organization\PatientService;
use App\Supports\Utility;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class PatientController extends Controller
{
    /**
     * @var AuthenticatedSessionService
     */
    private $authenticatedSessionService;

    /**
     * @var PatientService
     */
    private $patientService;

    /**
     * PatientController Constructor
     *
     * @param  AuthenticatedSessionService  $authenticatedSessionService
     * @param  PatientService  $patientService
     */
    public function __construct(AuthenticatedSessionService $authenticatedSessionService,
                                PatientService $patientService)
    {
        $this->authenticatedSessionService = $authenticatedSessionService;
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
        $patients = $this->patientService->patientPaginate($filters);

        return view('frontend.patient.index', [
            'patients' => $patients,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('frontend.patient.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return RedirectResponse
     *
     * @throws Throwable
     */
    public function store(Request $request): RedirectResponse
    {
        $confirm = $this->patientService->storePatient($request->except('_token'));
        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);

            return redirect()->route('backend.organization.patients.index');
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
        if ($patient = $this->patientService->getPatientById($id)) {
            return view('frontend.patient.show', [
                'patient' => $patient,
                'timeline' => Utility::modelAudits($patient),
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
     * @throws Exception
     */
    public function edit($id)
    {
        if ($patient = $this->patientService->getPatientById($id)) {
            return view('frontend.patient.edit', [
                'patient' => $patient,
            ]);
        }

        abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PatientRequest  $request
     * @param    $id
     * @return RedirectResponse
     *
     * @throws Throwable
     */
    public function update(PatientRequest $request, $id): RedirectResponse
    {
        $confirm = $this->patientService->updatePatient($request->except('_token', 'submit', '_method'), $id);

        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);

            return redirect()->route('backend.organization.patients.index');
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
     * @throws Throwable
     */
    public function destroy($id, Request $request)
    {
        if ($this->authenticatedSessionService->validate($request)) {
            $confirm = $this->patientService->destroyPatient($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }

            return redirect()->route('backend.organization.patients.index');
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
     * @throws Throwable
     */
    public function restore($id, Request $request)
    {
        if ($this->authenticatedSessionService->validate($request)) {
            $confirm = $this->patientService->restorePatient($id);

            if ($confirm['status'] == true) {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            } else {
                notify($confirm['message'], $confirm['level'], $confirm['title']);
            }

            return redirect()->route('backend.organization.patients.index');
        }
        abort(403, 'Wrong user credentials');
    }

    /**
     * Display a listing of the resource.
     *
     * @return string|StreamedResponse
     *
     * @throws Exception
     */
    public function export(Request $request)
    {
        $filters = $request->except('page');

        $patientExport = $this->patientService->exportPatient($filters);

        $filename = 'Patient-'.date('Ymd-His').'.'.($filters['format'] ?? 'xlsx');

        return $patientExport->download($filename, function ($patient) use ($patientExport) {
            return $patientExport->map($patient);
        });
    }

    /**
     * Return an Import view page
     *
     * @return Application|Factory|View
     */
    public function import()
    {
        return view('frontend.patientimport');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     *
     * @throws Exception
     */
    public function importBulk(Request $request)
    {
        $filters = $request->except('page');
        $patients = $this->patientService->getAllPatients($filters);

        return view('frontend.patientindex', [
            'patients' => $patients,
        ]);
    }

    /**
     * Display a detail of the resource.
     *
     * @return StreamedResponse|string
     *
     * @throws Exception
     */
    public function print(Request $request)
    {
        $filters = $request->except('page');

        $patientExport = $this->patientService->exportPatient($filters);

        $filename = 'Patient-'.date('Ymd-His').'.'.($filters['format'] ?? 'xlsx');

        return $patientExport->download($filename, function ($patient) use ($patientExport) {
            return $patientExport->map($patient);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function apply()
    {
        return view('frontend.patient.apply');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register()
    {
        //
    }
}
