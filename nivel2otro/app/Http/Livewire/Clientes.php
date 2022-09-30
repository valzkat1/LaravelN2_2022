<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Cliente;
use Khsing\World\Models\Continent;

class Clientes extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $nombre, $apellidos, $direccion, $email;
    public $updateMode = false;
    public $countries;


    // @gmail.com

    protected function rules(){
        return [
            'nombre' => 'required|min:3',
		    'apellidos' => 'required|min:3',
		    'direccion' => 'required',
		    'email' => 'regex:/^[\w.+\-]+@gmail\.com$/'
        ];
    }


    public function mount(){
        $asia = Continent::getByCode('AS');
        $countries = $asia->countries()->get();
        // or use children method
        $countries = $asia->children();
    }


    public function render()
    {


        $asia = Continent::getByCode('AS');
        $countries = $asia->countries()->get();

		$keyWord = '%'.$this->keyWord .'%';
        return view('livewire.clientes.view', [
            'clientes' => Cliente::latest()
						->orWhere('nombre', 'LIKE', $keyWord)
						->orWhere('apellidos', 'LIKE', $keyWord)
						->orWhere('direccion', 'LIKE', $keyWord)
						->orWhere('email', 'LIKE', $keyWord)
						->paginate(10),
                        'countries'=>$countries,
                        'country'=>0,
                        'city'=>0
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
