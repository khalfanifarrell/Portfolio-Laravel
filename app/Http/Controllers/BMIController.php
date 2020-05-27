<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BMIController extends Controller
{
    const BMI_RANGE_UNDERWEIGHT = 'underweight';
    const BMI_RANGE_HEALTHY = 'healthy';
    const BMI_RANGE_OVERWEIGHT = 'overweight';
    const BMI_RANGE_OBESE = 'obese';

    const BMI_RANGE_FIRST = 18.5;
    const BMI_RANGE_SECOND = 25;
    const BMI_RANGE_THIRD = 30;

    public function bmiPage(Request $request)
    {
        if (empty($request->input())) {
            return view('bmi');
        }

        $validation = $request->validate([
            'height' => ['required', 'integer'],
            'weight' => ['required', 'integer']
        ]);

        $input = $request->input();
        $height = $input['height'] / 100; // cm to m

        $bmi = $input['weight'] / ($height * $height);

        if ($bmi < self::BMI_RANGE_FIRST) {
            $bmiRange = self::BMI_RANGE_UNDERWEIGHT;
        } elseif ($bmi > self::BMI_RANGE_FIRST && $bmi < self::BMI_RANGE_SECOND) {
            $bmiRange = self::BMI_RANGE_HEALTHY;
        } elseif ($bmi > self::BMI_RANGE_SECOND && $bmi < self::BMI_RANGE_THIRD) {
            $bmiRange = self::BMI_RANGE_OVERWEIGHT;
        } else {
            $bmiRange = self::BMI_RANGE_OBESE;
        }

        $data = [
            'bmi' => round($bmi, 2),
            'bmi_range' => $bmiRange
        ];

        return view('bmi', $data);
    }
}
