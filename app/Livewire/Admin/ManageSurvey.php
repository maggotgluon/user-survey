<?php

namespace App\Livewire\Admin;

use App\Models\answer;
use Livewire\Component;

class ManageSurvey extends Component
{
    public function render()
    {
        return view('livewire.admin.manage-survey')->extends('layouts.app');
    }
    
}
