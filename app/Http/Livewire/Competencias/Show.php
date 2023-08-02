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
            $seModifico = true;
            $datosModificados[] = 'titulo';
        }

        if ($this->descripcion != $competencia->descripcion){
            $seModifico = true;
            $datosModificados[] = 'descripcion';
        }

        if ($this->fecha_inicio != $competencia->fecha_inicio){
            $seModifico = true;
            $datosModificados[] = 'fecha inicio';
        }

        if ($this->fecha_fin != $competencia->fecha_fin){
            $seModifico = true;
            $datosModificados[] = 'fecha fin';
        }

        if ($this->invitacion != null && $this->invitacion != ''){
            $seModifico = true;
            $datosModificados[] = 'invitacion';
        }

        if ($this->bases != null && $this->bases != ''){
            $seModifico = true;
            $datosModificados[] = 'bases';
        }

        if ($this->flyer != null && $this->flyer != ''){
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
        $this->emit('editorActualizado');
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
            $this->flyer = '';
        }
        $this->render();
    }

    public function cambiarEstado($estadoActual){
        if ($this->competencia->estado < 5 && $this->competencia->estado >= 0){
            $this->competencia->estado++;
            if ($this->competencia->estado == 4){
                $this->ActualizarFecha('inicio');
            } elseif($this->competencia->estado == 5){
                $this->ActualizarFecha('fin');
            }
        }
        $this->competencia->save();
        $this->render();
    }

    public function ActualizarFecha($tipo){
        $today = date('Y-m-d');
        if ($tipo == 'inicio'){
            $this->competencia->fecha_inicio = $today;
            $this->fecha_inicio = $today;
        } else{
            $this->competencia->fecha_fin = $today;
            $this->fecha_fin = $today;
        }
        $this->competencia->save();
    }

    public function volver(){
        return to_route('competencias.administrar-competencias');
    }

    public function save()
    {
        $competencia = $this->competencia;
        $this->validate([
            'titulo' => ['required', 'max:120', 'unique:competencias,titulo,' . $this->competencia->id],
            'descripcion' => ['nullable'],
            'fecha_inicio' => ['required', 'date', 'after_or_equal:today', 'before:fecha_fin'],
            'fecha_fin' => ['required', 'date', 'after:fecha_inicio'],
            'bases' => ['nullable', 'mimes:pdf,docx'],
            'flyer' => ['nullable', 'image', 'max:2048'],
            'invitacion' => ['nullable', 'mimes:pdf,docx'],
        ]);

        // Validamos que el nuevo dato sea diferente al actual para cambiarlo.
        if ($this->titulo != $competencia->titulo){
            $competencia->titulo = $this->titulo;
        }

        if ($this->descripcion != $competencia->descripcion){
            $competencia->descripcion = $this->descripcion;
        }

        if ($this->fecha_inicio != $competencia->fecha_inicio){
            $competencia->fecha_inicio = $this->fecha_inicio;
        }

        if ($this->fecha_fin != $competencia->fecha_fin){
            $competencia->fecha_fin = $this->fecha_fin;
        }

        if ($this->invitacion != null && $this->invitacion != ''){
            Storage::disk('public')->delete($competencia->invitacion);
            $urlInvitacion = $this->invitacion->store('competencias/invitacion', 'public');
            $competencia->invitacion = $urlInvitacion;
        }

        if ($this->bases != null && $this->bases != ''){
            Storage::disk('public')->delete($competencia->bases);
            $urlBases = $this->bases->store('competencias/bases', 'public');
            $competencia->bases = $urlBases;
        }

        if ($this->flyer != null && $this->flyer != ''){
            Storage::disk('public')->delete($competencia->flyer);
            $urlImagen = $this->flyer->store('competencias', 'public');
            $competencia->flyer = $urlImagen;
        }

        $competencia->save();

        return to_route('competencias.administrar-competencias')->with('status', 'Competencia editada.');
    }

    public function delete($id) {
        $competencia = Competencia::find($id);
        $competencia->estado = 0;
        $competencia->save();
        return to_route('competencias.administrar-competencias')->with('status', 'competencia eliminada');
    }
}
