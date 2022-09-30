<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use App\Models\SurveyScheduleView;
use App\Models\TestDate;
use Illuminate\Support\Facades\DB;
use Khill\Lavacharts\Lavacharts;

class DashboardSurveyCountController extends Controller
{
    /**
     * Show graphs of survey counts using Lavacharts.
     */
    public function index()
    {
        //
        $months = [1 => 'Jan', 2 => 'Feb', 3 => 'Mar',
            4        => 'Apr', 5 => 'May', 6 => 'Jun',
            7        => 'Jul', 8 => 'Aug', 9 => 'Sep',
            10       => 'Oct', 11 => 'Nov', 12 => 'Dec', ];

        $years = TestDate::select(DB::raw('year(test_date) as years'))
            ->distinct()
            ->orderBy('years', 'desc')
            ->get();

        foreach ($years as $y) {
            // Initialize temp array used to hold survey counts by month
            foreach ($months as $m) {
                $c[] = [$m, 0];
            }

            // Get the number of surveys in each month for
            // the current year.  The count will include non-equipment
            // related tests and calibrations, but those numbers are pretty
            // small and won't significantly affect things.
            $chartData = DB::select('select month(test_date) as m, count(*) as c from testdates where year(test_date)=:y group by month(test_date)', [$y->years]);

            // DB::select returns an array where each array element is
            // a PHP stdClass object with the query result.
            // Convert this to an array with plain numeric elements.
            foreach ($chartData as $cd) {
                // Replace the count data for the month in the $c array
                $c[($cd->m) - 1] = [$months[$cd->m], $cd->c];
            }

            // Set up the data table for the chart
            $surveyCounts = \Lava::DataTable()
                ->addStringColumn('Month')
                ->addNumberColumn('Num Surveys')
                ->addRows($c);

            // Create a column chart
            \Lava::ColumnChart(
                'Survey count - '.$y->years,
                $surveyCounts,
                [
                    'title'          => 'Survey counts - '.$y->years,
                    'titleTextStyle' => [
                        'fontSize' => 14, ],
                    'legend' => [
                        'position' => 'none',
                    ],
                ]
            );

            // Clear variables for the next loop iteration
            unset($c);
            unset($surveyCounts);
        }

        // Clear $y temp variable
        unset($y);

        // Get a count of all surveys except for these test type_id's
        // 8 - Other
        // 10 - Calibration
        $yearCounts = TestDate::whereNotIn('type_id', [8, 10])
            ->get()
            ->countBy(function ($item, $key) {
                return substr($item['test_date'], 0, 4);
            })
            ->sortKeys()
            ->toArray();

        // $yearCounts is an associative array.  Need a 2D array
        // to pass to \Lava::DataTable()
        foreach ($yearCounts as $yr => $count) {
            $y[] = [(string) $yr, $count];
        }

        $yearlySurveyCounts = \Lava::DataTable()
            ->addStringColumn('Year')
            ->addNumberColumn('Num Surveys')
            ->addRows($y);

        \Lava::ColumnChart(
            'Yearly Survey Count',
            $yearlySurveyCounts,
            [
                'title'          => 'Yearly survey counts',
                'titleTextStyle' => [
                    'fontSize' => 14, ],
                'legend' => [
                    'position' => 'none',
                ],
            ]
        );

        return view('dashboard.survey_counts', [
            'years' => $years,
        ]);
    }
}
