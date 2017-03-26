<?php

namespace RadDB\Http\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class TestController extends Controller
{
    /**
     * Process a spreadsheet file.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \PhpOffice\PhpSpreadsheet\Reader\IReader
     */
    public function processSpreadsheet($request)
    {
        // $file = 'Trauma1.xlsm';
        //
        // $spreadsheet = $this->loadSpreadsheet($file);
    }

    /**
     * Load a spreadsheet file.
     *
     * @param string $file
     *
     * @return \PhpOffice\PhpSpreadsheet\Reader\IReader
     */
    public function loadSpreadsheet()
    {
        $file = 'Trauma1.xlsm';
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Excel2007();
        $spreadsheet = $reader->load(public_path().'/'.$file);

        return $spreadsheet;
    }
}
