<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Administrar Competencias') }}
        </h2>
    </x-slot>
    <div class='max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8'>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            @if (!empty($msj))
            @if ($msj[1])
            <div id="alert-border-3" class="flex p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-800 dark:border-green-800" role="alert">
                <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <div class="ml-3 text-sm font-medium">
                    {{$msj[0]}}
                </div>
            </div>
            @else
            <div id="alert-border-3" class="flex p-4 mb-4 text-red-800 border-t-4 border-red-300 bg-red-50 dark:text-red-400 dark:bg-gray-800 dark:border-red-800" role="alert">
                <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <div class="ml-3 text-sm font-medium">
                    {{$msj[0]}}
                </div>
            </div>
            @endif


            @endif
            <div class="py-3 flex justify-between items-center ">
                <x-input class="w-25" wire:model='filtro' type='text' placeholder='Buscar...' />

                <button class="relative inline-flex items-center justify-center p-0.5 mb-2 mr-5 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-yellow-500 to-purple-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800" wire:click='agregarCompetencia()'>
                    <span @popper(Agregar competencia) class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                </button>

            </div>
            @livewire('competencias.agregar')

            @if (count($competencias) > 0)

            <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400">

                <thead class="text-md text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            <span class="cursor-pointer">
                                #
                            </span>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="cursor-pointer">
                                Titulo
                            </span>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="cursor-pointer">
                                Descripcion
                            </span>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="cursor-pointer">
                                Estado
                            </span>
                        </th>

                        <th scope="col" class=" px-6 py-3 flex justify-center">
                            ---
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php $cant = 1; ?>
                    @foreach ($competencias as $competencia )
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="px-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$cant++}}
                        </th>
                        <td class="px-2">
                            {{$competencia->titulo}}
                        </td>
                        <td class="px-2">
                            {{$competencia->descripcion}}
                        </td>
                        <td class="px-2 ">
                            @switch($competencia->estado)
                            @case(0)
                            <div class="w-1/2 m-auto">
                                Deshabilitado
                            </div>
                            @break

                            @case(1)
                            <div class="w-1/2 m-auto">
                                Buscando jueces
                            </div>
                            @break

                            @case(2)
                            <div class="w-1/2 m-auto">
                                Inscripciones abiertas
                            </div>
                            @break

                            @case(3)
                            <div class="w-1/2 m-auto">
                                Inscripciones cerradas
                            </div>
                            @break

                            @case(4)
                            <div class="w-1/2 m-auto">
                                <span style="color: #d97706;">En curso</span>
                            </div>
                            @break

                            @case(5)
                            <div class="w-1/2 m-auto">
                                Finalizada
                            </div>
                            @break
                            @endswitch
                        </td>
                        <td class="px-6 py-4 flex justify-end items-center">
                            <a href="{{route('solicitudes-inscriptos', $competencia->id)}}">
                                <button class="relative inline-flex items-center justify-center p-0.5 mb-2 ml-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-cyan-500 to-blue-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800 mt-2">
                                    <span @popper(Inscripciones) class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                        </svg>                                              
                                    </span>
                                </button>
                            </a>
                            <a href="{{route('competencias.show', $competencia->id)}}">
                                <button class="relative inline-flex items-center justify-center p-0.5 mb-2 ml-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-cyan-500 to-blue-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800 mt-2">
                                    <span  @popper(Editar competencia) class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>                                          
                                    </span>
                                </button>
                            </a>
                            <a href="{{route('competencias.ver-una-competencia', $competencia->id)}}" target="_blank" rel="noopener noreferrer">
                                <button class="relative inline-flex items-center justify-center p-0.5 mb-2 ml-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-cyan-500 to-green-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800 mt-2">
                                    <span @popper(Ver competencia) class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </span>
                                </button>
                            </a>
                        </td>
                    </tr>
                    @endforeach


                </tbody>
            </table>
            @else
            <div class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 px-6 py-3 text-dark">
                <h3>
                    No hay ninguna competencia por el momento.
                </h3>
            </div>

            @endif
        </div>

        <hr class="m-5">

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            @if (count($competenciasFinalizadas) > 0)
            Finalizadas
            <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400">
                <thead class="text-md text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            <span class="cursor-pointer">
                                #
                            </span>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="cursor-pointer">
                                Titulo
                            </span>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="cursor-pointer">
                                Descripcion
                            </span>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="cursor-pointer">
                                Estado
                            </span>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="cursor-pointer">
                                Fecha inicio
                            </span>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="cursor-pointer">
                                Fecha fin
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php $cant = 1; ?>
                    @foreach ($competenciasFinalizadas as $competencia )
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$cant++}}
                        </th>
                        <td class="px-6 py-3">
                            {{$competencia->titulo}}
                        </td>
                        <td class="px-6 py-3">
                            {{$competencia->descripcion}}
                        </td>
                        <td class="px-6 py-3 ">
                            Finalizada
                        </td>
                        <td class="px-6 py-3">
                            <?php $fechaInicio = date('d/m/Y', strtotime($competencia->fecha_inicio)) ?>
                            {{$fechaInicio}}
                        </td>
                        <td class="px-6 py-3">
                            <?php $fechaFin = date('d/m/Y', strtotime($competencia->fecha_fin)) ?>
                            {{$fechaFin}}
                        </td>
                    </tr>
                    @endforeach


                </tbody>
            </table>
            @endif
        </div>
    </div>
    <x-formulario-competencia></x-formulario-competencia>
</div>