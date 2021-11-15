<?php

declare(strict_types=1);

namespace App\Charts;

use App\Models\TestDate;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SurveyGraph extends BaseChart
{
    // /**
    //  * Display a bar chart showing the count of surveys per month for the specified year.
    //  * Uses the ConsoleTVs/Charts package from https://erik.cat/projects/Charts.
    //  * URI: /dashboard/surveyGraph
    //  * Method: GET.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function surveyGraph()
    // {
    //     // Get a list of all the years there are surveys for
    //     $years = TestDate::select(DB::raw('year(test_date) as years'))
    //         ->distinct()
    //         ->orderBy('years', 'desc')
    //         ->get();
    //     // Create a bar chart for each year
    //     foreach ($years as $y) {
    //         $chartData = DB::select('select count(*) from testdates where year(test_date)=:y group by month(test_date)', $y);
    //         $yearCharts[$y->years] = new SurveyGraph;
    //         $yearCharts[$y->years]->labels(['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']);
    //         $yearCharts[$y->years]->dataset($y, 'bar', $chartData);
    //             // Charts::database(TestDate::year($y->years)->get(), 'bar', 'google')
    //             // ->dateColumn('test_date')
    //             // ->title('Monthly survey count for '.$y->years)
    //             // ->elementLabel('Number of surveys')
    //             // ->dimensions(1000, 700)
    //             // ->monthFormat('M Y')
    //             // ->groupByMonth($y->years, true);
    //     }
    //     // Create a bar chart showing total number of surveys done in each year
    //     // $allYears = Charts::database(TestDate::get(), 'bar', 'google')
    //     //     ->dateColumn('test_date')
    //     //     ->title('Survey count for all years')
    //     //     ->elementLabel('Number of surveys')
    //     //     ->dimensions(1000, 700)
    //     //     ->groupByYear($years->count());

    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $surveyCountsChart = Chartisan::build()
            ->labels(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']);

        $years = TestDate::select(DB::raw('year(test_date) as years'))
            ->distinct()
            ->orderBy('years', 'asc')
            ->get();

        foreach ($years as $y) {
            $c = []; // Temporary array used to hold survey counts by month
            $chartData = DB::select('select count(*) as c from testdates where year(test_date)=:y group by month(test_date)', [$y->years]);
            // DB::select returns an array where each array element is a PHP stdClass object with the query result.
            // Convert this to an array with plain numeric elements.
            foreach ($chartData as $cd) {
                $c[] = $cd->c;
            }
            $surveyCountsChart->dataset((string) $y->years, $c);
            // Get rid of the array variable before the loop starts over.
            unset($c);
        }

        return $surveyCountsChart;
    }
}
