<section >
    <nav class="shadow rounded-lg fixed m-4 mx-auto inset-x-0 p-2 container flex gap-4 items-center bg-white/60 backdrop-blur-md">
        <div class="">
            <img class="h-16" src="{{asset('/images/logo.png')}}" />
        </div>
        <div class="">
        <x-button :href="route('home')" label="View Survey"/>
    </div>
    <div class="">
        <x-button :href="route('admin.report')" label="View Report"/>
    </div>
    <div class="">
        <x-button :href="route('admin.survey')" label="Manage Survey"/>
    </div>
    <div class="ml-auto">
        <x-btn-logout label="Logout"/>
    </div>
    </nav>
    <!-- You must be the change you wish to see in the world. - Mahatma Gandhi -->
</section>