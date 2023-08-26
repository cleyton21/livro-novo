<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cadastro de novo usuário') }}
        </h2>
    </x-slot>

    <div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">

            <div class="text-center">
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

    <form method="post" action="{{ route('user.store') }}" class="space-y-6">
        @csrf
        @method('post')

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            {{-- postograd --}}
        <div class="mt-4">
            <x-input-label for="postograd" :value="__('Posto/Graduação')" />
            <select name="postograd" value="{{ old('postograd') }}" style="border-color: #e5e7eb" id="postograd" class="form-select block mt-1 w-full rounded-md" autofocus>
                <option value="" selected>Selecione seu posto ou graduação</option>
                <option value="Cel">Cel</option>
                <option value="Ten Cel">Ten Cel</option>
                <option value="Maj">Maj</option>
                <option value="Cap">Cap</option>
                <option value="1º Ten">1° Ten</option>
                <option value="2º Ten">2° Ten</option>
                <option value="Asp">Asp</option>
                <option value="ST">ST</option>
                <option value="1º Sgt">1º Sgt</option>
                <option value="2º Sgt">2º Sgt</option>
                <option value="3º Sgt">3º Sgt</option>
                <option value="Cb">Cb</option>
                <option value="Sd">Sd</option>
            </select>
            <x-input-error :messages="$errors->get('postograd')" class="mt-2" />
        </div>

        <!-- Name -->
        <div class="mt-4">
            <x-input-label for="nome_guerra" :value="__('Nome de Guerra')" />
            <x-text-input id="nome_guerra" class="block mt-1 w-full" type="text" name="nome_guerra" :value="old('nome_guerra')" autofocus autocomplete="nome_guerra" />
            <x-input-error :messages="$errors->get('nome_guerra')" class="mt-2" />
        </div>

        <!-- Nome completo -->
        <div class="mt-4">
            <x-input-label for="nome_completo" :value="__('Nome Completo')" />
            <x-text-input id="nome_completo" class="block mt-1 w-full" type="text" name="nome_completo" :value="old('nome_completo')" autofocus autocomplete="nome_completo" />
            <x-input-error :messages="$errors->get('nome_completo')" class="mt-2" />
        </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <x-input-label for="cel" :value="__('Celular')" />
                <x-text-input id="cel" name="cel" value="{{ old('cel') }}" type="tel" class="mt-1 block w-full" autocomplete="cel" />
                <x-input-error :messages="$errors->get('cel')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" name="email" value="{{ old('email') }}" type="email" class="mt-1 block w-full" autocomplete="email" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="perfil" :value="__('Perfil')" />
                <select name="perfil" id="perfil" class="form-select block mt-1 w-full rounded-md" required>
                    <option value="" selected>Selecione o perfil</option>
                    @foreach ($allowedProfiles as $profile)
                        <option value="{{ $profile }}" {{ old('perfil') === $profile ? 'selected' : '' }}>{{ ucfirst($profile) }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('perfil')" class="mt-2" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">

            <button id="gravar-livro" class="btn btn-primary btn-block">
                Cadastrar Usuário
                <i class="fas fa-save"></i>
            </button>
        </div>
    </form>
</div>
</div>
        </div>
    </div>
</x-app-layout>
