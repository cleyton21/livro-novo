<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Preencha seu livro aqui') }}
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

                    <form method="post" action="{{ route('livro.store') }}" class="space-y-6">
                        @csrf
                        @method('post')
                
                        <div class="row">
                        <div class="col-md-6">
                            <x-input-label for="dt_ini" :value="__('Data Inicial')" />
                            <x-text-input id="dt_ini" name="dt_ini" value="{{ old('dt_ini') }}" type="date" class="mt-1 block w-full" autocomplete="dt_ini" />
                            <x-input-error :messages="$errors->updatePassword->get('dt_ini')" class="mt-2" />
                        </div>
                
                        <div class="col-md-6">
                            <x-input-label for="dt_end" :value="__('Data Final')" />
                            <x-text-input id="dt_end" name="dt_end" value="{{ old('dt_end') }}" type="date" class="mt-1 block w-full" autocomplete="dt_end" />
                            <x-input-error :messages="$errors->updatePassword->get('dt_end')" class="mt-2" />
                        </div>
                
                        </div>
                
                        <div>
                            <x-input-label for="texto" :value="__('Destino e/ou outra informação relevante')" />
                            <textarea class="form-control" id="texto" name="texto" value="{{ old('texto') }}" rows="4"></textarea>
                            <x-input-error :messages="$errors->updatePassword->get('texto')" class="mt-2" />
                        </div>

                        <button id="gravar-livro" class="btn btn-success btn-block">Gravar Livro
                            <i class="fas fa-save"></i>
                        </button>

                
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
