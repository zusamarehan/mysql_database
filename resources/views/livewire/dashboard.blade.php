<div class="p-10">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-5 gap-4 pb-10">
            <x-jet-input class="col-span-4" placeholder="Search Connection"></x-jet-input>
            <div>
                <a class="h-full justify-center flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150"
                   href="{{route('connection.new')}}">New Connection</a>
            </div>
        </div>
        <div class="grid grid-cols-3 gap-4">
            @foreach($connections as $connection)
                <div class="flex justify-between items-center p-4 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div>
                        {{$connection->name}}
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('connection.show', ['connection' => $connection->uuid]) }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </a>
                        <div wire:click="destroy('{{$connection->uuid}}')" class="cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
