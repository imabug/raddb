<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Machine;

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
