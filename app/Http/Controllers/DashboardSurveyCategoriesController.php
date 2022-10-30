<?php

namespace App\Http\Controllers;

use App\Models\TestDate;
use App\Models\TestType;
use Illuminate\Support\Facades\DB;

class DashboardSurveyCategoriesController extends Controller
{
    // Show pie charts breaking down the surveys for each year by
    // survey type (routine, acceptance, etc)

    public function index()
    {
        $years = TestDate::select(DB::raw('year(test_date) as years'))
            ->distinct()
            ->orderBy('years', 'desc')
            ->get();

        // Collect survey data for each year in the database
        foreach ($years as $y) {
            // Create an array of data tables for each year
            $surveyCategories = \Lava::DataTable();
            $surveyCategories->addStringColumn('Test Type')
                ->addNumberColumn('Num Surveys');

            // Get the number of surveys for each test type category of the current year $y
            // Exclude these type_ids
            // 8 - Other
            // 10 - Calibration
            $chartData = TestDate::year($y->years)
                ->whereNotIn('type_id', [8, 10])
                ->get()
                ->sortBy('type_id')
                ->countBy('type_id');

            // Add data to the data table
            foreach ($chartData as $d=>$count) {
                $surveyCategories->addRow(
                    [TestType::find($d)->test_type, $count]
                );
            }

            // Create a pie chart
            \Lava::PieChart(
                'Yearly survey counts by test type - '.$y->years,
                $surveyCategories,
                [
                    'is3D' => true,
                    'title' => 'Survey counts - '.$y->years.' ('.TestDate::year($y->years)->count().')',
                    'titleTextStyle' => [
                        'fontSize' => 14,
                        'color' => 'black', ],
                    'legend' => [
                        'position' => 'top', ],
                    'colorAxis' => [
                        'colors' => ['#c0d4ff', '#4273e0'],
                    ],
                ]
            );

            // Clear variables for the next loop iteration
            unset($surveyCategories);
            unset($chartData);
        }

        return view('dashboard.survey_categories', [
            'years' => $years,
        ]);
    }
}
