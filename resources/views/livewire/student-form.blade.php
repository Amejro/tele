<div>
    <form wire:submit="create" class='space-y-5'>
        {{ $this->form }}
        {{ $this->publishAction }}

        <!-- <button type="submit"
            class="py-2.5 px-5 me-2 mt-10 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 ">Submit</button> -->

        <!-- <button type="submit" class='border w-20'>
            Submit
        </button> -->
    </form>



    <x-filament-actions::modals />
</div>