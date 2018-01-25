<?php

namespace RadDB\Http\Controllers;

use DB;
use Charts;
use RadDB\TestDate;
use Illuminate\Http\Request;

class CalendarChartController extends Controller
{
    public function index()
    {
        // Get a list of all the years there are surveys for
        $years = TestDate::select(DB::raw('year(test_date) as years'))
            ->distinct()
            ->orderBy('years', 'desc')
            ->get();

        foreach ($years as $yr) {
            unset($labels);
            unset($data);
            $testDates = DB::table('testdates')
                ->selectRaw('test_date,count(test_date) as num')
                ->whereRaw('year(test_date)='.$yr->years)
                ->groupBy('test_date')->get();

            foreach ($testDates as $td) {
                $labels[] = $td->test_date;
                $data[] = $td->num;
            }
            $calChart[$yr->years] = Charts::create('calendar', 'google')
                ->labels($labels)
                ->values($data);
        }
        // SELECT test_date, count(test_date) FROM `testdates` WHERE year(test_date)='2017' group by test_date

        return view('test.calendar', [
            'calChart' => $calChart,
        ]);
    }
}
