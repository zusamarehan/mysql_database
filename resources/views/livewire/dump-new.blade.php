<div>
    <!-- Page Heading -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            New Connection
        </div>
    </header>
    <div class="space-y-10 pt-10">
        <div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-4">
                        {{-- If your happiness depends on money, you will never be happy with yourself. --}}
                        <div>
                            <x-jet-label for="host" value="{{ __('Host') }}" />
                            <x-jet-input wire:model="connection.host" id="host" class="block mt-1 w-full" type="text" name="host" :value="old('host')" required autofocus />
                            <x-jet-input-error for="connection.host" class="mt-2" />

                        </div>

                        <div class="mt-4">
                            <x-jet-label for="user" value="{{ __('User') }}" />
                            <x-jet-input wire:model="connection.username" id="user" class="block mt-1 w-full" type="text" name="user" :value="old('user')" required autofocus />
                            <x-jet-input-error for="connection.username" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-jet-label for="password" value="{{ __('Password') }}" />
                            <x-jet-input wire:model="connection.password" id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                            <x-jet-input-error for="connection.password" class="mt-2" />
                        </div>

                        <x-jet-action-message class="mr-3" on="testConnectionStatus">
                            @if($connectionStatus)
                                {{ __('Connection Successful.') }}
                            @else
                                {{ __('Unable to Connect to Host.') }}
                            @endif
                        </x-jet-action-message>

                        <div class="flex items-end justify-end mt-4">
                            <x-jet-button wire:click="test">
                                {{ __('Test Connection') }}
                            </x-jet-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($connectionStatus)
            <div>
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-4">
                            {{-- If your happiness depends on money, you will never be happy with yourself. --}}
                            <div>
                                <x-jet-label for="host" value="{{ __('Name') }}" />
                                <x-jet-input wire:model="connection.name" id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                                <x-jet-input-error for="connection.name" class="mt-2" />
                            </div>

                            <x-jet-action-message class="mr-3" on="saved">
                                {{ __('Saved') }}
                            </x-jet-action-message>

                            <div class="flex items-end justify-end mt-4">
                                <x-jet-button wire:click="save">
                                    {{ __('Save Connection') }}
                                </x-jet-button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
