<div>
    @auth
        <x-button.circle primary lg spinner :href="route('admin.report')" icon="finger-print"
            class="fixed top-1 right-1"/>
    @endauth
    <section class="w-screen h-screen grid items-center bg-[url('{{asset('/images/body_bg.jpg')}}')] bg-center bg-cover"
        style="background: url('{{asset('images/body_bg.jpg')}}');">
        
        {{-- <x-notifications position="top-center" timeout="500"/> --}}
        <x-dialog />

        <div class="container m-auto">
            <img src="{{asset('/images/logo.png')}}" class="w-64 m-auto"/>
            <div class="max-w-screen-xl mx-auto my-4">
                <h1 class="text-center text-7xl font-bold font-Taviraj text-white shadow">
                    {{$question->Question}}
                </h1>
            </div>
            
            <div class="{{$udid?'opacity-0':'opacity-100'}} mx-32 my-10">
                <x-input wire:model.lazy="udid" id="udid" 
                class="text-center border-transparent  
                    focus:ring-transparent focus:outline-none focus:border-transparent"
                placeholder="Tab here to scan your wrist band" autofocus/>
            </div>

            @if ($udid)
            <div class="w-full h-40 flex justify-around items-center my-16">
                <x-button  wire:click="save(1)" spinner="save" loading-delay="longest"
                class="servey-btn">
                    <img class="w-52" src="{{asset('/images/score-1.svg')}}" alt="">
                </x-button>
                <x-button  wire:click="save(2)" spinner="save" loading-delay="longest"
                class="servey-btn">
                    <img class="w-52" src="{{asset('/images/score-2.svg')}}" alt="">
                </x-button>
                <x-button  wire:click="save(3)" spinner="save" loading-delay="longest"
                class="servey-btn">
                    <img class="w-52" src="{{asset('/images/score-3.svg')}}" alt="">
                </x-button>
                <x-button  wire:click="save(4)" spinner="save" loading-delay="longest"
                class="servey-btn">
                    <img class="w-52" src="{{asset('/images/score-4.svg')}}" alt="">
                </x-button>
                <x-button  wire:click="save(5)" spinner="save" loading-delay="longest"
                class="servey-btn">
                    <img class="w-52" src="{{asset('/images/score-5.svg')}}" alt="">
                </x-button>
            </div>
            @endif

        </div>
    </section>
</div>
