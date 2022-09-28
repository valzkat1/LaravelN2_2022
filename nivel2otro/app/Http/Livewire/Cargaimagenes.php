<?php

namespace App\Http\Livewire;
use Livewire\WithFileUploads;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Cargaimagene;

class Cargaimagenes extends Component
{
    use WithPagination;
    use WithFileUploads;

	protected $paginationTheme = 'bootstrap';
    public $selected_id, $keyWord, $nombreimagen, $imagen;
    public $updateMode = false;

    public function render()
    {
		$keyWord = '%'.$this->keyWord .'%';
        return view('livewire.cargaimagenes.view', [
            'cargaimagenes' => Cargaimagene::latest()
						->orWhere('nombreimagen', 'LIKE', $keyWord)
						->orWhere('imagen', 'LIKE', $keyWord)
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
		$this->nombreimagen = null;
		$this->imagen = null;
    }

    public function store()
    {
        $this->validate([
		'nombreimagen' => 'required',
		'imagen' => 'required|image|mimes:png,jpg|max:4096',
        ]);

        Cargaimagene::create([
			'nombreimagen' => $this-> nombreimagen,
			'imagen' => 'img_'.$this->nombreimagen.'.png'
        ]);

        $this->imagen->storeAs('public/imagenes/', 'img_'.$this->nombreimagen.'.png');

        $this->resetInput();
		$this->emit('closeModal');
		session()->flash('message', 'Cargaimagene Successfully created.');
    }

    public function edit($id)
    {
        $record = Cargaimagene::findOrFail($id);

        $this->selected_id = $id;
		$this->nombreimagen = $record-> nombreimagen;
		$this->imagen = $record-> imagen;

        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate([
		'nombreimagen' => 'required',
		'imagen' => 'required',
        ]);

        if ($this->selected_id) {
			$record = Cargaimagene::find($this->selected_id);
            $record->update([
			'nombreimagen' => $this-> nombreimagen,
			'imagen' => $this-> imagen
            ]);

            $this->resetInput();
            $this->updateMode = false;
			session()->flash('message', 'Cargaimagene Successfully updated.');
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Cargaimagene::where('id', $id);
            $record->delete();
        }
    }
}
