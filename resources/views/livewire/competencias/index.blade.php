<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Administrar Competencias') }}
        </h2>
    </x-slot>

    @livewire('competencias.agregar')
    <div class='max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8'>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <div class="py-3 flex justify-between al ">
                <x-input class="w-25" wire:model='filtro' type='text' placeholder='Buscar...' />
                <select wire:model='filtroFecha'>
                    <option value="todos" selected>Todos</option>
                    <option value="en-curso">En curso</option>
                    <option value="proximos">Proximos</option>
                    <option value="finalizados">Finalizados</option>
                </select>
            </div>
            @if (count($competencias) > 0)
            <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400">

                <thead class="text-md text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            <span class="cursor-pointer">
                                ID
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
                        </th>
                        <th scope="col" class="px-6 py-3">
                        <button class="relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-cyan-500 to-blue-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800" wire:click='agregarCompetencia()'>
                                <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                    Agregar
                                </span>
                            </button>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($competencias as $competencia )
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{$competencia->id}}
                        </th>
                        <td class="px-6 py-4">
                            {{$competencia->titulo}}
                        </td>
                        <td class="px-6 py-4">
                            {{$competencia->descripcion}}
                        </td>

                        <td class="px-6 py-4">
                            <button class="relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-cyan-500 to-blue-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800" wire:click="mostrarCompetidor({{$competencia->id}})">
                                <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                    Editar
                                </span>
                            </button>
                        </td>
                    </tr>
                    @endforeach


                </tbody>
            </table>
            @else
            <div class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 px-6 py-3 text-dark">
                <h3>
                    No se encuentran solicitudes
                </h3>
            </div>

            @endif
        </div>
    </div>
</div>