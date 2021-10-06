<?php

namespace RadDB\Http\Livewire;

use Livewire\Component;
use RadDB\Machine;

class Testtables extends Component
{
    public function render()
    {
        return view('livewire.testtables', [
            'machines' => Machine::active()->get(),
        ])
            ->extends('layouts.app')
            ->section('content');
    }
}
