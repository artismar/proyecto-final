<x-app-layout>
    <script src="{{ asset('node_modules/tinymce/tinymce.js') }}"></script>
    @livewire('competencias.show', ['idCompetencia' => $idCompetencia])
</x-app-layout>
