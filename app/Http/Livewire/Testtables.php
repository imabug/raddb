<?php

namespace App\Http\Livewire;

use App\Machine;
use Livewire\Component;

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
