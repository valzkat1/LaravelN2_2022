<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Clientes2;

class Clientes2s extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $nombre, $apellidos, $direccion, $email;
    public $updateMode = false;

    public function render()
    {
		$keyWord = '%'.$this->keyWord .'%';
        return view('livewire.clientes2s.view', [
            'clientes2s' => Clientes2::latest()
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
        $this->validate([
		'nombre' => 'required',
		'apellidos' => 'required',
		'direccion' => 'required',
		'email' => 'required',
        ]);

        Clientes2::create([ 
			'nombre' => $this-> nombre,
			'apellidos' => $this-> apellidos,
			'direccion' => $this-> direccion,
			'email' => $this-> email
        ]);
        
        $this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'Clientes2 Successfully created.');
    }

    public function edit($id)
    {
        $record = Clientes2::findOrFail($id);

        $this->selected_id = $id; 
		$this->nombre = $record-> nombre;
		$this->apellidos = $record-> apellidos;
		$this->direccion = $record-> direccion;
		$this->email = $record-> email;
		
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
		'nombre' => 'required',
		'apellidos' => 'required',
		'direccion' => 'required',
		'email' => 'required',
        ]);

        if ($this->selected_id) {
			$record = Clientes2::find($this->selected_id);
            $record->update([ 
			'nombre' => $this-> nombre,
			'apellidos' => $this-> apellidos,
			'direccion' => $this-> direccion,
			'email' => $this-> email
            ]);

            $this->resetInput();
            $this->updateMode = false;
			session()->flash('message', 'Clientes2 Successfully updated.');
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Clientes2::where('id', $id);
            $record->delete();
        }
    }
}
