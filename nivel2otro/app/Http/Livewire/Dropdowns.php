<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Khsing\World\Models\City;
use Khsing\World\Models\Country;


class Dropdowns extends Component
{

    public $country=0;
    public $city=0;
    public $cities=[];


    public function mount($country,$city){

        $this->country=$country;
        $this->city=$city;
    }


    public function render()
    {

        if(!empty($this->country)){
            $this->cities= City::where('country_id',$this->country)->get();
        }
        return view('livewire.dropdowns')->withCountries(Country::orderBy('name')->get());


    }
}
