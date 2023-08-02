<x-app-layout>
    <script src="{{asset('assets/vendor/ckeditor5/build/ckeditor.js')}}"></script>
    @livewire('competencias.show', ['idCompetencia' => $idCompetencia])
</x-app-layout>
