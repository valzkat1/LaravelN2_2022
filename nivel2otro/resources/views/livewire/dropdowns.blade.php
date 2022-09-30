<div>

    <div class="form-group">

        <select name="country" wire:model="country" class="form-control">
            @foreach ($countries as $country)
                <option value="{{ $country->id }}" > {{ $country->name }} </option>
            @endforeach

        </select>

    </div>

    @if(count($cities)>0)
    <div class="form-group">
        <select name="city" wire:model="city" class="form-control">
            <option value=''>Seleccionar Depto</option>
            @foreach($cities as $city)
                <option value={{ $city->id }}>{{ $city->name }}</option>
            @endforeach
        </select>


    </div>
    @endif

</div>
