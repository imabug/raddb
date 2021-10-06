<?php

namespace RadDB\Http\Livewire;

use Livewire\Component;

class Testtables extends Component
{
    public function render()
    {
        return view('livewire.testtables')
            ->extends('layouts.app')
            ->section('content');
    }
}
