<section>
    <nav class="shadow rounded-lg fixed m-4 mx-auto inset-x-0 p-2 container flex justify-between items-center">
        <div class="">
            <img class="h-16" src="{{asset('/images/logo.png')}}" />
        </div>
        
        <x-button :href="route('home')" label="View Survey"/>
        <x-button :href="route('admin.report')" label="View Report"/>
        <x-button :href="route('admin.survey')" label="Manage Survey"/>
    </nav>
    <!-- You must be the change you wish to see in the world. - Mahatma Gandhi -->
</section>