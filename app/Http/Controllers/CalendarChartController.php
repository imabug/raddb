<?php

namespace RadDB\Http\Controllers;

use DB;
use Charts;
use RadDB\TestDate;
use Illuminate\Http\Request;

class CalendarChartController extends Controller
{
    public function index(int $year = null)
    {
        $errors = null;
        if (is_null($year)) {
            // If no year was specified, use the current year.
            $year = date('Y');
        }
        // SELECT test_date, count(test_date) FROM `testdates` WHERE year(test_date)='2017' group by test_date
        // $testDates = TestDate::year($year)->groupBy('test_date')->get();
        $testDates = DB::table('testdates')
            ->selectRaw('test_date,count(test_date) as num')
            ->whereRaw('year(test_date)='.$year)
            ->groupBy('test_date')->get();

        foreach ($testDates as $td) {
            $labels[] = $td->test_date;
            $data[] = $td->num;
        }
        $calChart = Charts::create('calendar', 'google')
            ->labels($labels)
            ->values($data);

        return view('test.calendar', [
            'calChart' => $calChart,
        ]);
    }
}
