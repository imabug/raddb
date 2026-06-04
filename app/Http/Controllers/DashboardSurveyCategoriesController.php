<?php

namespace App\Http\Controllers;

use App\Models\TestDate;
use App\Models\TestType;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardSurveyCategoriesController extends Controller
{
    /**
     * Show a page of pie charts breaking down surveys by survey type.
     *
     * Display a pie chart showing the breakdown of surveys by survey type
     * using the Google Chart API for every year that surveys were performed.
     * Charts are generated using Lavacharts ({@link https://lavacharts.com/}).
     *
     * URI: /dashboard/surveyCategories
     *
     * @link https://developers.google.com/chart/interactive/docs/gallery/piechart Google Charts pie charts
     */
    public function index(): View
    {
        /**
         * @var \Illuminate\Database\Eloquent\Collection $years Collection of years that surveys were performed in.
         **/
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
            foreach ($chartData as $d => $count) {
                $surveyCategories->addRow(
                    [TestType::find($d)->test_type, $count]
                );
            }

            // Create a pie chart
            \Lava::PieChart(
                'Yearly survey counts by test type - '.$y->years,
                $surveyCategories,
                [
                    'is3D'           => true,
                    'title'          => 'Survey counts - '.$y->years.' ('.$chartData->sum().')',
                    'titleTextStyle' => [
                        'fontSize' => 14,
                        'color'    => 'black', ],
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
