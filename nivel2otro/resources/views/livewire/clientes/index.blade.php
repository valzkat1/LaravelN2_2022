@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            @livewire('clientes')
        </div>
        <div class="col-md-6">
            @livewire('empleados')
        </div>
    </div>
</div>
@endsection
