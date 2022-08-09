<?php

namespace App\Http\Controllers;

use App\Models\TestDate;
use Illuminate\Support\Facades\DB;

class SurveyCalendarController extends Controller
{
    /*
     * Show a page of Google Calendar Charts for each year of surveys.
     */
    public function index()
    {
        $years = TestDate::select(DB::raw('year(test_date) as years'))
            ->distinct()
            ->orderBy('years', 'desc')
            ->get();

        // Collect survey count data for each year in the database
        foreach ($years as $y) {
            // Create an array of data tables for each year
            $surveyCalendar = \Lava::DataTable();
            $surveyCalendar->addDateColumn('Date')
                ->addNumberColumn('Num Surveys');

            // Get the number of surveys for each day of the current year $y
            // Exclude these type_ids
            // 8 - Other
            // 10 - Calibration
            $chartData = TestDate::year($y->years)
                ->whereNotIn('type_id', [8, 10])
                ->get()
                ->countBy('test_date');

            // Add survey date and count data to the data table
            foreach ($chartData as $d=>$count) {
                $surveyCalendar->addRow(
                    [$d, $count]
                );
            }

            // Create a column chart
            \Lava::CalendarChart(
                'Daily survey count - '.$y->years,
                $surveyCalendar,
                [
                    'title'          => 'Daily survey counts - '.$y->years,
                    'titleTextStyle' => [
                        'fontSize' => 14,
                        'color'    => 'black', ],
                    'yearLabel' => [
                        'color' => 'black', ],
                    'legend' => [
                        'position' => 'top', ],
                    'colorAxis' => [
                        'colors' => ['#c0d4ff', '#4273e0'],
                    ],
                ]
            );

            // Clear variables for the next loop iteration
            unset($surveyCalendar);
            unset($chartData);
        }

        return view('dashboard.survey_calendar', [
            'years' => $years,
        ]);
    }
}
