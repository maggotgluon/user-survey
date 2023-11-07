<section>
    <nav class="shadow rounded-lg fixed m-4 mx-auto inset-x-0 p-2 container flex justify-between items-center">
        <div class="rounded-full bg-white w-min -my-6 aspect-square shadow">
            <x-logo class="h-16 p-2"/>
        </div>
        @if (Route::has('login'))
        <div>

            @auth            
            <x-button :href="route('home')" label="Home"/>
            <x-btn-logout positive icon="x" label="oout"/>
            @else
                <x-button :href="route('login')" label="Log in"/>

                @if (Route::has('register'))
                    <x-button :href="route('register')" label="Register"/>
                @endif
            @endauth
        </div>
        @endif
    </nav>
    <!-- You must be the change you wish to see in the world. - Mahatma Gandhi -->
</section>