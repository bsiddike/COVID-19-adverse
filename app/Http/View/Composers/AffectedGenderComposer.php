<?php

namespace App\Http\View\Composers;

use App\Models\Patient;
use Illuminate\View\View;

class AffectedGenderComposer
{
    /**
     * Bind data to the view.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
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

        $view->with('pieData', $pieChartData);
    }
}
