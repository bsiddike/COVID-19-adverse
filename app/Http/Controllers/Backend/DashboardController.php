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
     * @param PatientService $patientService
     * @param SymptomService $symptomService
     * @param VaccineService $vaccineService
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
            'affectedGender' => $this->getGenderMetrics($filters),
            'affectedAge' => $this->getAgeMetrics($filters),
            'affectedMonth' => $this->getPatientLineChart($filters),
            'patientsStateMap' => $this->getPatientMap($filters),
            'vaccineOutcomes' => $this->getTopVaccinesOutcomesMetrics($filters),
        ]);
    }

    private function getGenderMetrics(array $filters = [])
    {
        $filters['metric'] = 'sex';

        $data = $this->patientService->getAllPatients($filters)->toArray();

        return [
            'type' => 'doughnut',
            'data' => [
                'labels' => array_keys($data[0]),
                'datasets' => [
                    [
                        'data' => array_values($data[0]),
                        'backgroundColor' => ['#f56954', '#00a65a', '#f39c12'],
                    ],
                ],
            ],
            'options' => [
                'maintainAspectRatio' => false,
                'responsive' => true,
                'legend' => [
                    'position' => 'left',
                ],
            ],
        ];
    }

    private function getAgeMetrics(array $filters = [])
    {
        $filters['metric'] = 'age_yrs';

        $data = $this->patientService->getAllPatients($filters)->toArray();

        return [
            'type' => 'pie',
            'data' => [
                'labels' => array_keys($data[0]),
                'datasets' => [
                    [
                        'data' => array_values($data[0]),
                        'backgroundColor' => ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de', '#a2d6de'],
                    ],
                ],
            ],
            'options' => [
                'maintainAspectRatio' => false,
                'responsive' => true,
                'legend' => [
                    'position' => 'left',
                ],
            ],
        ];
    }

    private function getPatientLineChart(array $filters = [])
    {
        $years = $this->patientService->getAllPatients(array_merge($filters, ['year_distinct' => true]))
            ->pluck('year')->toArray();

        $months = ['January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December',];

        $datasets = [];

        $filters['metric'] = 'patient_month';

        foreach ($years as $year) {
            $color = random_color();
            $filters['today_year'] = $year;
            $data = $this->patientService->getAllPatients($filters)->toArray();
            $datasets[] = [
                'label' => $year,
                'backgroundColor' => $color,
                'borderColor' => $color,
                'pointRadius' => false,
                'pointColor' => $color,
                'pointStrokeColor' => $color,
                'pointHighlightFill' => '#fff',
                'pointHighlightStroke' => $color,
                'data' => array_values($data[0]),
                'fill' => false,
            ];
        }

        return [
            'type' => 'line',
            'data' => [
                'labels' => $months,
                'datasets' => $datasets,
            ],
            'options' => [
                'datasetFill' => true,
                'maintainAspectRatio' => false,
                'responsive' => true,
                'legend' => [
                    'display' => true,
                ],
                'scales' => [
                    'xAxes' => [
                        [
                            'gridLines' => [
                                'display' => false,
                            ],
                        ],
                    ],
                    'yAxes' => [
                        [
                            'gridLines' => [
                                'display' => false,
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    private function getPatientMap(array $filters = [])
    {
        $filters['metric'] = 'state';
        $states = $this->patientService->getAllPatients($filters)->toArray();
        $areas = [];

        foreach ($states as $state) {
            $state_name = strtoupper($state['state']);
            $state_count = strtonumber($state['aggregate'], 0);
            $areas[$state_name] = [
                'value' => $state_count,
                'href' => '#',
                'tooltip' => [
                    'content' => "<span style='font-weight:bold;'>{$state_name}</span><br/>Patients: {$state_count}",
                ],
            ];
        }

        return [
            'map' => [
                'name' => 'usa_states',
                'zoom' => [
                    'enabled' => true,
                    'maxLevel' => 10,
                ],
                'defaultArea' => [
                    'attrs' => [
                        'stroke' => '#fff',
                        'stroke-width' => 1,
                    ],
                    'attrsHover' => [
                        'stroke-width' => 2,
                    ],
                ],
            ],
            'areas' => $areas,
        ];
    }

    /**
     * @throws \Exception
     */
    private function getTopVaccinesOutcomesMetrics(array $filters = [])
    {
        $filters['metric'] = 'top_10_symptoms';

        $data = $this->vaccineService
            ->getAllVaccines($filters)
            ->toArray();

        $formatData = [];

        foreach ($data as $datum) {
            if (!isset($formatData[$datum['vax_name']])) {
                $formatData[$datum['vax_name']] = [
                    "data" => [],
                    "backgroundColor" => []
                ];
            }
            $formatData[$datum['vax_name']]['data'][] = $datum['aggregate'];
            $formatData[$datum['vax_name']]['backgroundColor'][] = random_color();
        }

        return [
            'type' => 'bar',
            'data' => [
                'labels' => array_keys($formatData),
                'datasets' => array_values($formatData),
            ],
            'options' => [
                'maintainAspectRatio' => false,
                'datasetFill' => false,
                'responsive' => true,
                'legend' => [
                    'display' => false,
                    'position' => 'left',
                ],
                'scales' => [
                    'xAxes' => [[
                        'stacked' => true,
                    ]],
                    'yAxes' => [[
                        'stacked' => true
                    ]],
                ]
            ]
        ];
    }
}
