<div>

    <div class="form-group">

        <select name="country" wire:model="country" class="form-control">
            @foreach ($countries as $country)
                <option value="{{ $country->id }}" > {{ $country->name }} </option>
            @endforeach

        </select>

    </div>


</div>
