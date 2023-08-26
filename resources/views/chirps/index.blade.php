<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">

        <div class="text-center">
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }} <i class="fas fa-thumbs-up"></i>
            </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }} <i class="fas fa-thumbs-down"></i></li>
                        @endforeach
                    </ul>
                </div>
            @endif   
        </div> 

        <form method="POST" action="{{ route('chirps.store') }}">
            @csrf

            <div class="flex space-x-4">
                <div class="w-1/2">
                    <label for="dt_ini" class="block font-medium text-gray-700">Data Inicial</label>
                    <input type="date" name="dt_ini" id="dt_ini" value="{{ old('dt_ini') }}" class="mt-1 p-2 border rounded-md w-full">
                </div>
                <div class="w-1/2">
                    <label for="dt_end" class="block font-medium text-gray-700">Data Final</label>
                    <input type="date" name="dt_end" id="dt_end" value="{{ old('dt_end') }}" class="mt-1 p-2 border rounded-md w-full">
                </div>
            </div>
            <br>

            <label for="dt_end" class="block font-medium text-gray-700">Destino/Observação</label>

            <textarea
                name="texto"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >{{ old('texto') }}</textarea>
            <x-input-error :messages="$errors->get('texto')" class="mt-2" />
            <x-primary-button class="mt-4">{{ __('Salvar') }}</x-primary-button>
        </form>

        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
            @foreach ($chirps as $chirp)
                <div class="p-6 flex space-x-2">
                    {{-- <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg> --}}
                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-gray-800">Criado em:</span>
                                <small class="ml-2 text-sm text-gray-600">{{ $chirp->created_at->format('j M Y, g:i a') }}</small>

                                <span class="text-gray-800">Data Inicial:</span>
                                <small class="ml-2 text-sm text-gray-600">{{ \Carbon\Carbon::parse($chirp->dt_ini)->format('d/m/Y') }}</small>

                                <span class="text-gray-800">Término:</span>
                                <small class="ml-2 text-sm text-gray-600">{{ \Carbon\Carbon::parse($chirp->dt_end)->format('d/m/Y') }}</small>
                                {{-- @unless ($chirp->created_at->eq($chirp->updated_at))
                                    <small class="text-sm text-gray-600"> &middot; {{ __('edited') }}</small>
                                @endunless --}}
                                <br>
                                <br>
                                <span class="text-gray-800">Destino/Observação:</span>
                                <small class="ml-2 text-sm text-gray-600">{{ $chirp->texto }}</small>
                            </div>
                            
                            {{-- @if ($chirp->user->is(auth()->user()))
                                <x-dropdown>
                                    <x-slot name="trigger">
                                        <button>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>
                                    </x-slot>
                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('chirps.edit', $chirp)">
                                            {{ __('Edit') }}
                                        </x-dropdown-link>
                                    </x-slot>
                                </x-dropdown>
                            @endif --}}
                        </div>

                        <p class="mt-4 text-lg text-gray-900">{{ $chirp->message }}</p>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</x-app-layout>