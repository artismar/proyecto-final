<div class="w-3/4 md:w-2/4 m-auto py-5">
    <div>
        @if ($msj)
            {{$msj}}
        @endif
    </div>
    <div class="min-w-full my-3 py-3 text-gray-200 text-center bg-slate-800">
        <p class="text-green-200">{{$competencia->titulo}}</p>
        <hr class="my-2 border-gray-500 w-1/2 mx-auto">
        <p class="text-green-200">
            {{$estado}}
        </p>
        <p class="text-green-500 hover:text-green-800 cursor-pointer" wire:click="cambiarEstado({{$competencia->estado}})">
            {{$estadoProximo}}
        </p>
    </div>
    <form enctype="multipart/form-data">
        <div class="py-3">
            <x-label class="text-white" for="titulo">Titulo</x-label>
            <x-input class="block mt-1 w-full" wire:model="titulo" type="text" id="titulo"/>
            @error('titulo') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="py-3">
            <x-label class="text-white" for="descripcion">Descripcion</x-label>
            <x-input class="block mt-1 w-full" wire:model="descripcion" type="text" id="descripcion" />
            @error('descripcion') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="py-3">
            <x-label class="text-white" for="fecha_inicio">Fecha inicio</x-label>
            <x-input class="block mt-1 w-full" wire:model="fecha_inicio" type="date" id="fecha_inicio" />
            @error('fecha_inicio') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="py-3">
            <x-label class="text-white" for="fecha_fin">Fecha fin</x-label>
            <x-input class="block mt-1 w-full" wire:model="fecha_fin" type="date" id="fecha_fin" />
            @error('fecha_fin') <span class="error">{{ $message }}</span> @enderror
        </div class="py-3">

        <div class="text-gray-500 py-3">
            <x-label class="text-white" for="invitacion">Invitacion</x-label>

            @if ($invitacion != '')
                <div class="inline-flex my-2 ml-5 px-2 text-green-500 border rounded-xl">
                    <span class="pl-3">
                        Nuevo
                    </span>
                    <span class="mx-2 hover:text-green-800 cursor-pointer" wire:click="limpiarArchivo('invitacion')" wire:key="1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                    @error('invitacion') <span class="error">{{ $message }}</span> @enderror
                </div>
            @else
                {{-- Ver o descargar archivo subido --}}
                <div class="inline-flex my-2 ml-5 text-green-200 border rounded-xl">
                    <span class="pl-3">Invitacion actual: </span>
                    <span class="mx-2 hover:text-green-800">
                        <a href="{{ Storage::url($competencia->invitacion) }}" target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </a>
                    </span>|
                    <span class="mx-2 hover:text-green-800 cursor-pointer" wire:click="descargarArchivo('invitacion')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75l3 3m0 0l3-3m-3 3v-7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                </div>

                <x-input class="block mt-1 w-full" wire:model="invitacion" type="file" id="invitacion" />
            @endif

        </div>

        <div class="text-gray-500 py-3">
            <x-label class="text-white" for="bases">Bases</x-label>

            @if ($bases != "")
                <div class="inline-flex my-2 ml-5 px-2 text-green-500 border rounded-xl">
                    <span class="pl-3">
                        Nuevo
                    </span>
                    <span class="mx-2 hover:text-green-800 cursor-pointer" wire:click="limpiarArchivo('bases')" wire:key="2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                    @error('bases') <span class="error">{{ $message }}</span> @enderror
                </div>
            @else
                {{-- Ver o descargar archivo subido --}}
                <div class="inline-flex my-2 ml-5 text-green-200 border rounded-xl">
                    <span class="pl-3">Bases actual: </span>
                    <span class="mx-2 hover:text-green-800">
                        <a href="{{ Storage::url($competencia->bases) }}" target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </a>
                    </span>|
                    <span class="mx-2 hover:text-green-800 cursor-pointer" wire:click="limpiarArchivo('bases')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75l3 3m0 0l3-3m-3 3v-7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                </div>

                <x-input class="block mt-1 w-full" wire:model="bases" type="file" id="bases" />
            @endif
        </div>

        <div class="text-gray-500 py-3">
            <x-label class="text-white" for="flyer">Flyer</x-label>
            @if ($flyer != '')
                <div class="inline-flex my-2 ml-5 px-2 text-green-500 border rounded-xl">
                    <span class="pl-3">
                        Nuevo
                    </span>
                    <span class="mx-2 hover:text-green-800 cursor-pointer" wire:click="limpiarArchivo('flyer')" wire:key="3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                    @error('flyer') <span class="error">{{ $message }}</span> @enderror
                </div>
            @else
                {{-- Ver o descargar archivo subido --}}
                <div class="inline-flex my-2 ml-5 text-green-200 border rounded-xl">
                    <span class="pl-3">Flyer actual: </span>
                    <span class="mx-2 hover:text-green-800">
                        <a href="{{ Storage::url($competencia->flyer) }}" target="_blank">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </a>
                    </span>|
                    <span class="mx-2 hover:text-green-800 cursor-pointer" wire:click="descargarArchivo('flyer')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75l3 3m0 0l3-3m-3 3v-7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                </div>

                <x-input class="block mt-1 w-full" wire:model="flyer" type="file" id="flyer" />
            @endif
        </div>

        @if ($modifico != '')
        <div class="min-w-full my-3 py-2 text-gray-200 text-center bg-blue-800 bg-opacity-20">
            Por modificar: <span class=" text-green-200">{{$campos}}</span>
        </div>
        @endif


        <div class="flex items-center justify-between my-10 mb-20">
            <div>
                <x-button type='reset' class="bg-red-800 hover:bg-red-700" wire:click='delete({{$competencia->id}})'>
                    <span>
                        <svg fill="none" stroke="currentColor" class="w-5 m-auto" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="false">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path>
                        </svg>
                    </span>
                </x-button>
            </div>
            <div>
                <x-button type='reset' class="bg-gray-900 hover:bg-gray-700" wire:click="volver">
                    {{ __('Volver') }}
                </x-button>
                @if (!$modifico)
                    <x-button type="submit" class="bg-gray-800 ml-2" disabled>
                        {{ __('Guardar') }}
                    </x-button>
                @else
                    <x-button type="submit" class="bg-green-800 hover:bg-green-700 ml-2">
                        {{ __('Guardar') }}
                    </x-button>
                @endif
            </div>
        </div>
    </form>
</div>
