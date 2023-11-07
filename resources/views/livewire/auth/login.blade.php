@section('title', 'Sign in to your account')
<section class="container m-auto">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <x-logo class="w-auto h-16 mx-auto text-indigo-600" />
    </div>
    <x-debug>
        username : admin<br>
        password : password
    </x-debug>
    <x-debug/>
    <form wire:submit.prevent="authenticate">
    <x-card title="Sign in to your account" cardClasses="max-w-sm m-auto mt-4">
        
            <x-errors class="mb-6" />
            <div>
                <x-input autofocus label="Email/Username" placeholder="your email or username" 
                    wire:model.lazy="email"/>
            </div>
            
            <div class="mt-6">
                <x-inputs.password type="password" label="Password" 
                    wire:model.lazy="password"/>
            </div>

            <div class="flex items-center justify-between mt-6">
                <div class="flex items-center">
                    <x-checkbox id="Remember" label="Remember" wire:model.defer="remember" />
                </div>
                @if (!null == config('mail.mailers.smtp.url') )
                <div class="text-sm leading-5">
                    <x-button flat secondary :href="route('password.request')"
                        label="Forgot your password?" />
                </div>
                @endif
            </div>
        <x-slot name="footer">
            <div class="grid gap-2">
                <x-button primary label="Sign in" type="submit" class="w-full"/>

                @if (Route::has('register'))
                    <x-button flat primary label="create a new account" :href="route('register')"/>
                @endif
            </div>
        </x-slot>
    </x-card>
    </form>
</section>
