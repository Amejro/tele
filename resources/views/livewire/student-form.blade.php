<div class='' style=' margin-top: 50px;
    margin-bottom: 50px;'>

    <!-- display: flex
;
    flex-direction: column;
    justify-items: center; -->

    <div style='
flex-direction: column; justify-items: center; '>

        <img src="{{URL::asset('uhas-telecel.png')}}" alt="Uhas_telecel logo" height="100" width="100">

        <h1 style='text-align: center;font-size: large; font-weight: 500; padding: 20px;'>
            UHAS-Telecel tertiary SIM records
        </h1>
    </div>

    <form wire:submit="create" class='space-y-5 '>
        {{ $this->form }}
        {{ $this->publishAction }}

        <!-- <button type="submit"
            class="py-2.5 px-5 me-2 mt-10 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 ">Submit</button> -->

        <!-- <button type="submit" class='border w-20'>
            Submit
        </button> -->
    </form>



    <x-filament-actions::modals class='' />
</div>