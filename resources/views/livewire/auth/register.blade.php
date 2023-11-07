@section('title', 'Create a new account')
<section class="container m-auto">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <x-logo class="w-auto h-16 mx-auto text-indigo-600" />
    </div>
    <form wire:submit.prevent="register">
    <x-card title="Create a new account" cardClasses="max-w-sm m-auto mt-4">
            <x-errors class="mb-6"/>
            <div>
                <x-input autofocus label="Username" placeholder="your username" 
                wire:model.lazy="name"/>
            </div>
                
            <div class="mt-6">
                <x-input label="Email" placeholder="your email" 
                wire:model.lazy="email"/>
            </div>
                
            <div class="mt-6">
                <x-inputs.password type="password" label="Password" 
                    wire:model.lazy="password"/>
            </div>
                
            <div class="mt-6">
                <x-inputs.password type="password" label="ConfirmPassword" 
                    wire:model.lazy="password_confirmation"/>
            </div>
                
            <x-slot name="footer">
                <div class="grid gap-2">
                    <x-button primary label="Register" type="submit" class="w-full" />
                    <x-button flat primary label="Have account?" :href="route('login')"/>
                </div>
            </x-slot>
        </x-card>
    </form>
</section>