<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Livewire\Component;

class Login extends Component
{
    /** @var string */
    public $email = '';

    /** @var string */
    public $password = '';

    /** @var bool */
    public $remember = false;

    protected $rules = [
        'email' => ['required'],
        'password' => ['required'],
    ];

    public function authenticate()
    {
        $this->validate();
        
        if( Auth::attempt(['name' => $this->email, 'password' => $this->password], $this->remember)||
            Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember) ){
                return redirect()->intended(route('home'));
            }
        
        return $this->addError('email', trans('auth.failed'));
        
    }

    public function render()
    {
        return view('livewire.auth.login')->extends('layouts.auth');
    }
}
