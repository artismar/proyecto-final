@if($cantJuecesCompetencia < 3 && Auth::user()->hasRole('Competidor'))
    <div class="bg-red-200 text-red-800 pt-4 m-6 mt-4 mb-4 p-4 text-lg rounded border border-red-300 my-3">
        Por el momento no se puede incribir a esta competencia <br>Por favor, vuelve más tarde para poder inscribirse. <br>
        <a href="{{route('competencias.index')}}" class="font-medium text-red-800 dark:text-red-800 hover:underline">Volver</a>
    </div>
    <div class="p-4 "></div>
    @else
    <div class="info-competencia mt-6 mb-8 pb-8">
        <div>
            <h1 class="text-6xl flex justify-center font-semibold dark:text-gray-400 ">{{ $data['titulo'] }}</h1>
        </div>
        <div class="datos-competencia gap-x-2 flex flex-row justify-center mt-6">
            <div class="flyer max-w-sm mr-4">
                <img class="rounded-t-lg w-auto" src="{{ Storage::url($data['flyer']) }}" alt="flyer" />
            </div>
            @livewire('competencias.formulario-inscripcion', ['competenciaId' => $data['id']])
            <div grid justify-items-center class="flex flex-col align-items-center">
                <div class="data dark:text-gray-400 mb-2" style="height: 80%;">
                    <ul>
                        <li class="dark:bg-gray-800 dark:border-gray-700 rounded-md max-w-md p-2">
                            <h1 class="text-lg font-semibold">Descripción</h1>
                            {!! $data['descripcion'] !!}
                        </li>
                        <li class="dark:bg-gray-800 dark:border-gray-700 rounded-md max-w-md p-2 mt-4">
                            <h1 class="text-lg font-semibold">Dia de inicio</h1>
                            {{ date('d-m-Y', strtotime($data['fecha_inicio'])) }}
                        </li>
                        <li class="dark:bg-gray-800 dark:border-gray-700 rounded-md max-w-md p-2 mt-4">
                            <h1 class="text-lg font-semibold">Dia de finalización</h1>
                            {{ date('d-m-Y', strtotime ($data['fecha_fin']))}}
                        </li>
                        <li class="dark:bg-gray-800 dark:border-gray-700 rounded-md max-w-md p-2 mt-4">
                            <h1 class="text-lg font-semibold">Cantidad de jueces</h1>
                            {{ $cantJuecesCompetencia }}
                        </li>
                        <li class="dark:bg-gray-800 dark:border-gray-700 rounded-md max-w-md p-2 mt-4">
                            <h1 class="text-lg font-semibold">Estado</h1>
                            @switch($data['estado'])
                            @case(1)
                            Inscripcion solo jueces
                            @break
                            @case(2)
                            Inscripciones abiertas.
                            @break
                            @case(3)
                            Inscripciones cerradas.
                            @break
                            @case(4)
                            Competencia en curso.
                            @break
                            @case(5)
                            Competencia finalizada.
                            @break
                            @default
                            Finalizada
                            @endswitch
                        </li>
                    </ul>
                    <img src="storage/app/public/{{$data['flyer']}}" alt="">
                </div>
                <div class="flex flex-row justify-center align-items-center items-end mt-8 text-gray-500" style="height: 20%;">
                    <div class="flex flex-row justify-center">
                        @if(Auth::user()->hasRole('Admin'))
                        <button style="display: none;" id="openModal" disabled type="button" class="relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-green-400 to-blue-600 dark:text-white">
                            <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md">
                                No verificado para inscribirse
                            </span>
                        </button>
                        @elseif ($cantJuecesCompetencia < 3 && Auth::user()->hasRole('Competidor') )
                            <button id="openModal" style="display:none; " type="button" class="relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-green-400 to-blue-600 dark:text-white">
                                <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md">
                                    Inscripción
                                </span>
                            </button>
                        @elseif ($bandera == 0 && $data['estado']< 4)
                            <button id="openModal" type="button" class="relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-green-400 to-blue-600 dark:text-white">
                                <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md">
                                    Inscripcion en proceso
                                </span>
                            </button>
                        @elseif( (Auth::user()->hasRole('Competidor') && $data['estado'] == 2) || (Auth::user()->hasRole('Juez') && $data['estado'] == 1 || Auth::user()->hasRole('Juez') && $data['estado'] == 2) && !$mostrarPoomsaes)
                            <button id="openModal" wire:click="mostrarInscripcion({{$data['id']}})" type="button" class="relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-green-400 to-blue-600 group-hover:from-green-400 group-hover:to-blue-600 hover:text-white dark:text-white">
                                <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                    Inscripción
                                </span>
                            </button>
                        @endif
                            <!-- <button id="openModal" wire:click="mostrarInscripcion({{$data['id']}})" type="button" class="mt-4 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                        Inscribirme
                    </button> -->
                            <a href="{{ Storage::url($data['bases']) }}" target="_blank" rel="noopener noreferrer">
                                <button class="relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-green-400 to-blue-600 group-hover:from-green-400 group-hover:to-blue-600 hover:text-white dark:text-white">
                                    <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                        Bases y condiciones
                                    </span>
                                </button>
                            </a>
                            <a href="{{ Storage::url($data['invitacion']) }}" target="_blank" rel="noopener noreferrer">
                                <button class="relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-green-400 to-blue-600 group-hover:from-green-400 group-hover:to-blue-600 hover:text-white dark:text-white">
                                    <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                        Invitacion
                                    </span>
                                </button>
                            </a>
                            @role('Admin')
                            <a href="{{route('timer', [$data['id']])}}">
                                <button class="relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-green-400 to-blue-600 group-hover:from-green-400 group-hover:to-blue-600 hover:text-white dark:text-white">
                                    <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                        Timer
                                    </span>
                                </button>
                            </a>
                            @endrole
                            @if($data['estado']==4)
                            @role('Juez')
                            <a href="{{route('pulsador')}}">
                                <button class="relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-green-400 to-blue-600 group-hover:from-green-400 group-hover:to-blue-600 hover:text-white dark:text-white">
                                    <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                        Pulsador
                                    </span>
                                </button>
                            </a>
                            @endrole
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modales con los estados del proceso de incripcion de un competidor/juez a una competencia -->
    @if(($inscripcionAceptadaJuez == 0 && $inscripcionAceptadaCompe == null) || ($inscripcionAceptadaCompe == 0 && $inscripcionAceptadaJuez == null))
    <!-- Modal que muestra que la inscripcion fue enviada  -->
    <div id="popup-modal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full ">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="popup-modal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-6 text-center">
                    <svg aria-hidden="true" class="mx-auto mb-4 text-gray-400 w-14 h-14 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Su inscripción fue enviada, se encuentra en proceso de aprobación</h3>
                </div>
            </div>
        </div>
    </div>

    <script>
        const modalButton = document.querySelector('[data-modal-toggle="popup-modal"]');
        const modal = document.querySelector('#popup-modal');
        const botonInscripcion1 = document.getElementById("openModal");

        modalButton.addEventListener('click', () => {
            modal.classList.add('block');
            modal.classList.remove('hidden');
            modal.setAttribute('aria-hidden', 'false');
        });

        const closeButton = modal.querySelector('[data-modal-hide="popup-modal"]');
        closeButton.addEventListener('click', () => {
            modal.classList.remove('block');
            modal.classList.add('hidden');
            modal.setAttribute('aria-hidden', 'true');
            modal.style.display = 'none';
            botonInscripcion1.setAttribute('disabled');
        });
    </script>
    @elseif(($inscripcionAceptadaJuez == 1 && $inscripcionAceptadaCompe == null) || ($inscripcionAceptadaCompe == 1 && $inscripcionAceptadaJuez == null))
    <!-- Modal que muestra que la inscripcion fue aceptada -->
    <div id="popup-modal2" tabindex="-1" style="display:flex; align-items:center;  justify-content: center;" class="fixed flex align-items-center top-0 left-0 right-0 z-50 p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full ">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="popup-modal2">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-6 text-center">
                    <svg aria-hidden="true" class="mx-auto mb-4 text-gray-400 w-14 h-14 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"></path>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Su inscripción fue aceptada</h3>
                </div>
            </div>
        </div>
    </div>

    <script>
        const modal2 = document.querySelector('#popup-modal2');
        const botonInscripcion = document.getElementById("openModal")

        const closeButton2 = modal2.querySelector('[data-modal-hide="popup-modal2"]');
        closeButton2.addEventListener('click', () => {
            modal2.classList.remove('block');
            modal2.classList.add('hidden');
            modal2.setAttribute('aria-hidden', 'true');
            modal2.style.display = 'none';
            botonInscripcion.style.display = 'none';
        });
    </script>
    @elseif(($inscripcionAceptadaJuez == 2 && $inscripcionAceptadaCompe == null) || ($inscripcionAceptadaCompe == 2 && $inscripcionAceptadaJuez == null) )
    <!-- Modal que muestra que la inscripcion fue Rechazada -->
    <div id="popup-modal3" tabindex="-1" style="display:flex; align-items:center;  justify-content: center;" class="fixed flex align-items-center top-0 left-0 right-0 z-50 p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full ">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="popup-modal3">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>

                </button>
                <div class="p-6 text-center">
                    <svg aria-hidden="true" class="mx-auto mb-4 text-gray-400 w-14 h-14 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Su inscripción fue rechazada</h3>
                </div>
            </div>
        </div>
    </div>

    <script>
        const modal3 = document.querySelector('#popup-modal3');
        const botonInscripcion3 = document.getElementById("openModal")

        const closeButton3 = modal3.querySelector('[data-modal-hide="popup-modal3"]');
        closeButton3.addEventListener('click', () => {
            modal3.classList.remove('block');
            modal3.classList.add('hidden');
            modal3.setAttribute('aria-hidden', 'true');
            modal3.style.display = 'none';
            botonInscripcion3.style.display = 'none';
            // botonInscripcion3.setAttribute('disabled');
            // botonInscripcion3.innerHTML = 'Inscripcion Rechazada';
        });
    </script>
    @endif

    @if($mostrarResultados)
    <div class="resultados-competencia" style="margin-top: 5rem;">
        <div class="">
            <h1 class="text-6xl flex justify-center font-semibold dark:text-gray-400">Resultados</h1>
        </div>
        @livewire('competidores.competencia-competidor', ['competenciaId' => $data['id']] )
    </div>
    @endif

    <link rel="stylesheet" href="{{ asset('css/estilosTarjetaPoomsaes.css') }}">
    @if($mostrarPoomsaes && $pasada1!=null)
    <div class="tarjeta-poomsaes">
        <div class="poomsaes">
            <h1 class="titulo-poomsaes">Tus poomsaes</h1>
            <div class="datos-poomsaes">
                <div><b>Primera ronda:</b> {{$pasada1->poomsae->nombre}} </div>
                <div><b>Segunda ronda:</b> {{$pasada2->poomsae->nombre}}</div>
            </div>
        </div>
    </div>
    @endif
@endif
