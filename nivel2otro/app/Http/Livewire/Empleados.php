<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Empleado;

class Empleados extends Component
{
    use WithPagination;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $nombre, $edad;
    public $updateMode = false;

    protected $rules =[
        'nombre' => 'required',
		'edad' => 'required|digits_between:1,2'

    ];

    protected $messages=[
        'required' => 'Campo Obligado',
        'digits_between'=>'No mayores a 99..'
    ];

    public function render()
    {
		$keyWord = '%'.$this->keyWord .'%';
        return view('livewire.empleados.view', [
            'empleados' => Empleado::latest()
						->orWhere('nombre', 'LIKE', $keyWord)
						->orWhere('edad', 'LIKE', $keyWord)
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
		$this->edad = null;
    }

    public function store()
    {

        $this->validate();
      /*   $this->validate([
		'nombre' => 'required',
		'edad' => 'required',
        ]); */

        Empleado::create([
			'nombre' => $this-> nombre,
			'edad' => $this-> edad
        ]);

        $this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'Empleado Successfully created.');
    }

    public function edit($id)
    {
        $record = Empleado::findOrFail($id);

        $this->selected_id = $id;
		$this->nombre = $record-> nombre;
		$this->edad = $record-> edad;

        $this->updateMode = true;
    }


    public function updated($propertyname){

        $this->validateOnly($propertyname);
    }

    public function guardarEmpleado(){

        $validateData=$this->validate();
        Empleados::create($validateData);

    }

    public function update()
    {
        $this->validate();
        /*   $this->validate([
          'nombre' => 'required',
          'edad' => 'required',
          ]); */

        if ($this->selected_id) {
			$record = Empleado::find($this->selected_id);
            $record->update([
			'nombre' => $this-> nombre,
			'edad' => $this-> edad
            ]);

            $this->resetInput();
            $this->updateMode = false;
			session()->flash('message', 'Empleado Successfully updated.');
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Empleado::where('id', $id);
            $record->delete();
        }
    }
}
