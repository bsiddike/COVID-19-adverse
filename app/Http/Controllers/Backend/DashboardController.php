<?php

namespace App\Http\Controllers\Backend;

use App\Models\Patient;
use App\Models\Symptom;
use App\Models\Vaccine;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    /**
     * DashboardController constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param  Request  $request
     * @return array|Application|Factory|View|mixed
     *
     * @throws \Exception
     */
    public function __invoke(Request $request)
    {
        return view('backend.dashboard', [
            'patients' => Patient::all()->count(),
            'symptoms' => Symptom::all()->count(),
            'vaccines' => Vaccine::all()->count(),
            'pieData' => $this->getGenderMetrics(),
        ]);
    }

    private function getGenderMetrics()
    {
        $data = Patient::selectRaw('count(id) as aggregate, sex')->groupBy('sex')->get()->toArray();

        $pieChartData = [
            'labels' => ['Female', 'Male', 'Unknown'],
            'datasets' => [
                [
                    'data' => [],
                    'backgroundColor' => ['#f56954', '#00a65a', '#f39c12'],
                ],
            ],
        ];

        foreach ($data as $datum) {
            if ($datum['sex'] == 'F') {
                $pieChartData['datasets'][0]['data'][0] = $datum['aggregate'];
            } elseif ($datum['sex'] == 'M') {
                $pieChartData['datasets'][0]['data'][1] = $datum['aggregate'];
            } else {
                $pieChartData['datasets'][0]['data'][2] = $datum['aggregate'];
            }
        }

        return $pieChartData;
    }
}
