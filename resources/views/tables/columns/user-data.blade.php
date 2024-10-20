<div>
    <div class="p-2 lg:w-1/3 md:w-1/2 w-full">
        <div class="h-full flex items-center rounded-lg gap-3">
            <img alt="team" class="w-10 h-10 bg-gray-100 object-cover object-center flex-shrink-0 rounded-full"
                src="{{ isset($getRecord()->profile_image) ? asset("storage/" . $getRecord()->profile_image) : asset('images/blank.png') }}">
            <div class="flex-grow">
                <h2 class="fi-ta-text-item-label text-sm leading-6 text-gray-950 dark:text-white">{{ $getRecord()->first_name }} {{ $getRecord()->last_name }}</h2>
                <p class="fi-ta-text-item-label text-sm leading-6 text-gray-950 dark:text-white">{{ $getRecord()->email }}</p>
            </div>
        </div>
    </div>
</div>
