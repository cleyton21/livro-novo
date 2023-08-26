<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- postograd --}}
        <div>
            <x-input-label for="postograd" :value="__('Posto/Graduação')" />
            <select name="postograd" style="border-color: #e5e7eb" id="postograd" class="form-select block mt-1 w-full rounded-md" required autofocus>
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
            <x-text-input id="nome_guerra" class="block mt-1 w-full" type="text" name="nome_guerra" :value="old('nome_guerra')" required autofocus autocomplete="nome_guerra" />
            <x-input-error :messages="$errors->get('nome_guerra')" class="mt-2" />
        </div>

        <!-- Nome completo -->
        <div class="mt-4">
            <x-input-label for="nome_completo" :value="__('Nome Completo')" />
            <x-text-input id="nome_completo" class="block mt-1 w-full" type="text" name="nome_completo" :value="old('nome_completo')" required autofocus autocomplete="nome_completo" />
            <x-input-error :messages="$errors->get('nome_completo')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

         <!-- Cel -->
         <div class="mt-4">
            <x-input-label for="cel" :value="__('Celular')" />
            <x-text-input id="cel" class="block mt-1 w-full" type="tel" name="cel" :value="old('cel')" required autocomplete="cel" />
            <x-input-error :messages="$errors->get('cel')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Já possui cadastro?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Cadastrar') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
