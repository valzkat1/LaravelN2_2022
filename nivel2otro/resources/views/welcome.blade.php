@extends('layouts.app')
@section('title', __('Welcome'))
@section('content')
<div class="container-fluid">
<div class="row justify-content-center">
    <div class="row">
        <div class="card">
            <div class="card-header"><h5><span class="text-center fa fa-home"></span> @yield('title')</h5></div>
            <div class="card-body">
              <h5>
            @guest

                @include('auth.login')

			@else
            <div class="col-md-6">
                @include('livewire.clientes.index')
            </div>
        
            @endif
				</h5>
            </div>

    </div>
</div>
</div>
@endsection
