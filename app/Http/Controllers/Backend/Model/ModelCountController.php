<?php

namespace App\Http\Controllers\Backend\Model;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Symptom;
use App\Models\Vaccine;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ModelCountController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param string $model
     * @param Request $request
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function __invoke(string $model, Request $request)
    {
        if ($modelClass = $this->getModelClass($model)) {
            $modelInstance = app()->make($modelClass);
            return response()->json(['status' => true, 'count' => number_format($modelInstance->count())]);
        }
        return response()->json(['status' => false, 'count' => 0]);
    }

    /**
     * @param string $key
     * @return string|null
     */
    private function getModelClass(string $key)
    {
        $models = [
            'patient' => Patient::class,
            'symptom' => Symptom::class,
            'vaccine' => Vaccine::class
        ];

        return $models[$key] ?? null;
    }
}
