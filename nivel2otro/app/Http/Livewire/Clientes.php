<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Cliente;

class Clientes extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $nombre, $apellidos, $direccion, $email;
    public $updateMode = false;



    // @gmail.com

    protected function rules(){
        return [
            'nombre' => 'regex:/w3schools/i',
		    'apellidos' => 'regex:/[a-z0-9](3)/',
		    'direccion' => 'required',
		    'email' => 'regex:^[\w.+\-]+@gmail\.com$
        '
        ];
    }


    public function render()
    {
		$keyWord = '%'.$this->keyWord .'%';
        return view('livewire.clientes.view', [
            'clientes' => Cliente::latest()
						->orWhere('nombre', 'LIKE', $keyWord)
						->orWhere('apellidos', 'LIKE', $keyWord)
						->orWhere('direccion', 'LIKE', $keyWord)
						->orWhere('email', 'LIKE', $keyWord)
						->paginate(10),
        ]);
    }

    public function cancel()
    {
        $this->resetInput();
        $this->updateMode = false;
    }

    private function resetInput()
    {
		$this->nombre = null;
		$this->apellidos = null;
		$this->direccion = null;
		$this->email = null;
    }

    public function store()
    {


        $this->validate();

     /*    $this->validate([
		'nombre' => 'required',
		'apellidos' => 'required',
		'direccion' => 'required',
		'email' => 'required',
        ]); */

        Cliente::create([
			'nombre' => $this-> nombre,
			'apellidos' => $this-> apellidos,
			'direccion' => $this-> direccion,
			'email' => $this-> email
        ]);

        $this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'Cliente Successfully created.');
    }


    public function updated($campoRegistrado){
        $this->validateOnly($campoRegistrado);

    }

    public function guardarCliente(){

        $resultadoValid=$this->validate();
        Clientes::create($resultadoValid);
    }


    public function edit($id)
    {
        $record = Cliente::findOrFail($id);

        $this->selected_id = $id;
		$this->nombre = $record-> nombre;
		$this->apellidos = $record-> apellidos;
		$this->direccion = $record-> direccion;
		$this->email = $record-> email;

        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate();

        /*    $this->validate([
           'nombre' => 'required',
           'apellidos' => 'required',
           'direccion' => 'required',
           'email' => 'required',
           ]); */

        if ($this->selected_id) {
			$record = Cliente::find($this->selected_id);
            $record->update([
			'nombre' => $this-> nombre,
			'apellidos' => $this-> apellidos,
			'direccion' => $this-> direccion,
			'email' => $this-> email
            ]);

            $this->resetInput();
            $this->updateMode = false;
			session()->flash('message', 'Cliente Successfully updated.');
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Cliente::where('id', $id);
            $record->delete();
        }
    }
}
