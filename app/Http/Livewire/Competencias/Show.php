<?php

namespace App\Http\Livewire\Competencias;

use App\Models\Competencia;
use App\Models\CompetenciaCategoria;
use App\Models\PoomsaeCompetenciaCategoria;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;


class Show extends Component {

    use WithFileUploads;

    public $competencia;
    public $msj;
    public $titulo, $flyer, $bases, $descripcion, $invitacion, $fecha_inicio, $fecha_fin, $estado, $estadoProximo; //variables para el manejo de los datos del form


    protected $listeners = ['render'=>'render'];


    public function render() {
        $competencia = $this->competencia;
        $seModifico = false;
        $datosModificados = array();
        $msj = '';

        // Validamos que el nuevo dato sea diferente al actual para cambiarlo.
        if ($this->titulo != $competencia->titulo){
            // $competencia->titulo = $this->titulo;
            $seModifico = true;
            $datosModificados[] = 'titulo';
        }

        if ($this->descripcion != $competencia->descripcion){
            // $competencia->descripcion = $this->descripcion;
            $seModifico = true;
            $datosModificados[] = 'descripcion';
        }

        if ($this->fecha_inicio != $competencia->fecha_inicio){
            // $competencia->fecha_inicio = $this->fecha_inicio;
            $seModifico = true;
            $datosModificados[] = 'fecha inicio';
        }

        if ($this->fecha_fin != $competencia->fecha_fin){
            // $competencia->fecha_fin = $this->fecha_fin;
            $seModifico = true;
            $datosModificados[] = 'fecha fin';
        }

        if ($this->invitacion != null){
            // Storage::disk('public')->delete($competencia->invitacion);
            $urlInvitacion = $this->invitacion->store('competencias/invitacion', 'public');
            // $competencia->invitacion = $urlInvitacion;
            $seModifico = true;
            $datosModificados[] = 'invitacion';
        }

        if ($this->bases != null && $this->bases != ''){
            // Storage::disk('public')->delete($competencia->bases);
            $urlBases = $this->bases->store('competencias/bases', 'public');
            // $competencia->bases = $urlBases;
            $seModifico = true;
            $datosModificados[] = 'bases';
        }

        if ($this->flyer != null){
            // Storage::disk('public')->delete($competencia->flyer);
            $urlImagen = $this->flyer->store('competencias', 'public');
            // $competencia->flyer = $urlImagen;
            $seModifico = true;
            $datosModificados[] = 'flyer';
        }


        if ($seModifico){
            if (count($datosModificados) > 1){
                $items = collect($datosModificados)->slice(0, -1)->implode(', ');
                $items .= ' y ' . last($datosModificados);
            } else{
                $items = $datosModificados[0];
            }
            $msj = "$items";
        }

        $this->estados();
        return view('livewire.competencias.edit', ['competencia' => $this->competencia, 'campos' => $msj, 'modifico' => $seModifico]);
    }

    public function mount($idCompetencia) {
        $competencia = Competencia::find($idCompetencia);
        $this->competencia = $competencia;
        $this->titulo = $competencia->titulo;
        $this->descripcion = $competencia->descripcion;
        $this->fecha_inicio = $competencia->fecha_inicio;
        $this->fecha_fin = $competencia->fecha_fin;
        $this->estados();
    }

    public function estados(){
        if ($this->competencia->estado == 0){
            $this->estado = 'Deshabilitado';
            $this->estadoProximo = 'Habilitar';
        } elseif ($this->competencia->estado == 1){
            $this->estado = 'Buscando jueces';
            $this->estadoProximo = 'Abrir inscripciones';
        } elseif ($this->competencia->estado == 2){
            $this->estado = 'Inscripciones abiertas';
            $this->estadoProximo = 'Cerrar inscripciones';
        } elseif ($this->competencia->estado == 3){
            $this->estado = 'Inscripciones cerradas';
            $this->estadoProximo = 'Iniciar competencia';
        } elseif ($this->competencia->estado == 4){
            $this->estado = 'En curso';
            $this->estadoProximo = 'Finalizar competencia';
        } elseif ($this->competencia->estado == 5){
            $this->estado = 'Competencia finalizada';
            $this->estadoProximo = 'Archivar';
        }
    }

    public function descargarArchivo($nombre)
    {
        if ($nombre == 'invitacion'){
            $rutaArchivo = $this->competencia->invitacion;
            $formato = pathinfo($rutaArchivo, PATHINFO_EXTENSION);
            $nombreArchivo = 'invitacion.'.$formato;
        } elseif ($nombre == 'bases'){
            $rutaArchivo = $this->competencia->bases;
            $formato = pathinfo($rutaArchivo, PATHINFO_EXTENSION);
            $nombreArchivo = 'bases.'.$formato;
        } else{
            $rutaArchivo = $this->competencia->flyer;
            $formato = pathinfo($rutaArchivo, PATHINFO_EXTENSION);
            $nombreArchivo = 'flyer.'.$formato;
        }

        return response()->download(public_path(Storage::url($rutaArchivo)), $nombreArchivo);
    }

    public function limpiarArchivo($file){
        if ($file == 'invitacion') {
            $this->invitacion = '';
        } elseif ($file == 'bases') {
            $this->bases = '';
        } else {
            $this->invitacion = '';
        }
        $this->render();
    }

    public function cambiarEstado($estadoActual){
        if ($this->competencia->estado < 5 && $this->competencia->estado >= 0){
            $this->competencia->estado++;
        } elseif ($this->competencia->estado == 5){
            $this->competencia->estado = 0;
        }
        $this->competencia->save();
        $this->render();
    }

    public function volver(){
        return to_route('competencias.administrar-competencias');
    }

    public function update()
    {
        $this->validate([
            'titulo' => ['required', 'max:120', 'unique:competencias,titulo,' . $this->competencia->id],
            'descripcion' => ['required', 'max:120'],
            'fecha_inicio' => ['required', 'date', 'after_or_equal:today', 'before:fecha_fin'],
            'fecha_fin' => ['required', 'date', 'after:fecha_inicio'],
            'bases' => ['nullable', 'mimes:pdf,docx'],
            'flyer' => ['nullable', 'image', 'max:2048'],
            'invitacion' => ['nullable', 'mimes:pdf,docx'],
        ]);

        // Lógica para guardar los cambios en la base de datos o hacer cualquier otra acción

        $this->msj = 'Cambios guardados exitosamente.';
    }

    public function delete($id) {
        $competencia = Competencia::find($id);
        $competencia->estado = 0;
        $competencia->save();
        return to_route('competencias.administrar-competencias');
    }
}
