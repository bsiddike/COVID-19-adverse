<?php

namespace App\Http\Controllers\Backend;

use App\Models\Patient;
use App\Models\Symptom;
use App\Models\Vaccine;
use App\Services\Backend\Organization\PatientService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    private PatientService $patientService;

    /**
     * DashboardController constructor.
     * @param PatientService $patientService
     */
    public function __construct(PatientService $patientService)
    {
        $this->patientService = $patientService;
    }

    /**
     * @param Request $request
     * @return array|Application|Factory|View|mixed
     *
     * @throws \Exception
     */
    public function __invoke(Request $request)
    {
        $filters = $request->except('page');

        return view('backend.dashboard', [
            'patients' => Patient::all()->count(),
            'symptoms' => Symptom::all()->count(),
            'vaccines' => Vaccine::all()->count(),
            'affectedGender' => $this->getGenderMetrics($filters),
            'affectedAge' => $this->getAgeMetrics($filters)
        ]);
    }

    private function getGenderMetrics(array $filters = [])
    {
        $filters['metric'] = 'sex';

        $data = $this->patientService->getAllPatients($filters)->toArray();

        return [
            'labels' => array_keys($data[0]),
            'datasets' => [
                [
                    'data' => array_values($data[0]),
                    'backgroundColor' => ['#f56954', '#00a65a', '#f39c12'],
                ],
            ],
        ];
    }


    private function getAgeMetrics(array $filters = [])
    {
        $filters['metric'] = 'age_yrs';

        $data = $this->patientService->getAllPatients($filters)->toArray();

        return [
            'labels' => array_keys($data[0]),
            'datasets' => [
                [
                    'data' => array_values($data[0]),
                    'backgroundColor' => ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de', '#a2d6de'],
                ],
            ],
        ];
    }
}
