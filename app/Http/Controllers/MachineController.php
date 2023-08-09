<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateMachineRequest;
use App\Models\Location;
use App\Models\Machine;
use App\Models\Manufacturer;
use App\Models\Modality;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class MachineController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Only apply auth middleware to these methods
        $this->middleware('auth')->only([
            'create',
            'edit',
            'store',
            'update',
            'destroy',
        ]);
    }

    /**
     * Display a listing of all active machines.
     *
     * \App\Http\Livewire\MachineListTable component is used to display the
     * list of machines.
     *
     * URI: /machines
     *
     * Method: GET.
     */
    public function index(): View
    {
        return view('machine.index');
    }

    /**
     * Show form for adding a new machine.
     *
     * URI: /machines/create
     *
     * Method: GET.
     */
    public function create(): View
    {
        // Return data from lookup tables to use in the form
        return view('machine.machines_create', [
            'modalities'    => Modality::get(),
            'manufacturers' => Manufacturer::get(),
            'locations'     => Location::get(),
        ]);
    }

    /**
     * Save machine data to the database.
     *
     * Form data is validated in \App\Http\Requests\UpdateMachineRequest
     * before being stored in the database.  Then the user is redirected
     * to a form for adding a new tube for the machine.
     *
     * URI: /machines
     *
     * Method: POST.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function store(UpdateMachineRequest $request, Machine $machine): RedirectResponse
    {
        // Check if action is allowed
        $this->authorize(Machine::class);

        $message = '';

        // $machine = new Machine();
        $machine->modality_id = $request->modality;
        $machine->description = $request->description;
        $machine->manufacturer_id = $request->manufacturer;
        $machine->vend_site_id = $request->has('vendSiteID') ? $request->vendSiteID : null;
        $machine->model = $request->model;
        $machine->serial_number = $request->serialNumber;
        $machine->software_version = $request->softwareVersion;
        $machine->manuf_date = $request->has('manufDate') ? $request->manufDate : null;
        $machine->install_date = $request->has('installDate') ? $request->installDate : null;
        $machine->location_id = $request->location;
        $machine->room = $request->room;
        $machine->machine_status = $request->status;
        $machine->notes = $request->has('notes') ? $request->notes : null;

        if ($machine->save()) {
            $status = 'success';
            $message = 'New machine created: Machine ID '.$machine->id.'.';
            Log::info($message);
        } else {
            $status = 'fail';
            $message = 'Error creating new machine.';
            Log::error($message);
        }

        return redirect()
            ->route('tubes.createTubeFor', $machine->id)
            ->with($status, $message);
    }

    /**
     * Display the information for machine $id.
     *
     * URI: /machines/$id
     *
     * Method: GET.
     *
     * @param string $id Machine ID to display
     */
    public function show($id): View
    {
        $machine = Machine::with([
            'tube',
            'opnote',
            'testdate',
            'recommendation',
        ])
            ->findOrFail((int) $id);

        $machinePhotos = $machine->getMedia('machine_photos');

        return view('machine.detail', [
            'machine'         => $machine,
            'photos'          => $machinePhotos,
            'tubes'           => $machine->tube,
            'opnotes'         => $machine->opnote,
            'surveys'         => $machine->testdate->sortBy('test_date'),
            'recommendations' => $machine->recommendation,
        ]);
    }

    /**
     * Show the form for editing a machine.
     *
     * URI: /machines/$id/edit
     *
     * Method: GET.
     *
     * @param string $id Machine ID to edit
     */
    public function edit($id): View
    {
        return view('machine.machines_edit', [
            'modalities'    => Modality::get(),
            'manufacturers' => Manufacturer::get(),
            'locations'     => Location::get(),
            'machine'       => Machine::findOrFail((int) $id),
        ]);
    }

    /**
     * Update machine details.
     *
     * Form data is validated by App\Http\Requests\UpdateMachineRequest before
     * being stored in the database.  User is then redirected back to the machine
     * information page.
     *
     * URI: /machines/$id
     *
     * Method: PUT
     *
     * @param \Illuminate\Http\Request $request
     * @param string                   $id
     */
    public function update(UpdateMachineRequest $request, $id): RedirectResponse
    {
        // Check if action is allowed
        $this->authorize(Machine::class);

        $message = '';

        // Retrieve the model for the machine to be edited
        $machine = Machine::find((int) $id);

        $machine->modality_id = $request->modality;
        $machine->description = $request->description;
        $machine->manufacturer_id = $request->manufacturer;
        $machine->vend_site_id = $request->has('vendSiteID') ? $request->vendSiteID : null;
        $machine->model = $request->model;
        $machine->serial_number = $request->serialNumber;
        $machine->software_version = $request->softwareVersion;
        $machine->manuf_date = $request->has('manufDate') ? $request->manufDate : null;
        $machine->install_date = $request->has('installDate') ? $request->installDate : null;
        $machine->location_id = $request->location;
        $machine->room = $request->room;
        $machine->machine_status = $request->status;
        $machine->notes = $request->has('notes') ? $request->notes : null;

        if ($machine->save()) {
            $status = 'success';
            $message = 'Machine ID '.$machine->id.' updated.';
            Log::info($message);
        } else {
            $status = 'fail';
            $message = 'Error editing machine.';
            Log::error($message);
        }

        return redirect()
            ->route('machines.show', $machine->id)
            ->with($status, $message);
    }

    /**
     * Remove machine $id and associated tubes from the database.
     *
     * URI: /machines/$id
     *
     * Method: DELETE
     *
     * @param string $id
     */
    public function destroy($id): RedirectResponse
    {
        // Check if action is allowed
        $this->authorize(Machine::class);

        $message = '';

        $machine = Machine::find((int) $id)
            ->with('tube');

        // Retrieve active tubes associated with this machine
        $tubes = $machine->tube->where('tube_status', 'Active');

        // Update the status and remove date for the machine
        $machine->machine_status = 'Removed';
        $machine->remove_date = date('Y-m-d');
        $machine->save();

        // Set the delete status for each tube
        foreach ($tubes as $tube) {
            $tube->tube_status = 'Removed';
            $tube->remove_date = date('Y-m-d');
            $tube->save();
            if ($tube->delete()) {
                $message .= 'Tube ID '.$tube->id.' deleted.';
            } else {
                $message .= 'Error deleting tube ID '.$tube->id.'.';
            }
        }

        if ($machine->delete()) {
            $status = 'success';
            $message .= 'Machine ID '.$machine->id.' deleted.';
            Log::info($message);
        } else {
            $status = 'fail';
            $message .= 'Error deleting machine ID '.$machine->id.'.';
            Log::error($message);
        }

        return redirect()
            ->route('machines.index')
            ->with($status, $message);
    }
}
