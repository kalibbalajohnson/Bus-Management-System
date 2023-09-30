@extends('layouts.app', [
    'class' => 'login-page',
    'elementActive' => ''
])

@section('content')
    <style>
        .stop {
            display: none;
        }

        .bus {
            display:none;
        }

        .cost {
            display:none;
        }

        .seat {
            display:none;
        }
    </style>
    <div class="content col-md-12">
        <div class="header py-5 pb-7 pt-lg-9">
            <div class="container col-md-10">
                <div class="header-body text-center mb-7">
                    <div class="row justify-content-center" style="align-items: center;">
                        <div class="col-lg-4 col-md-6">
                            <div class="card card-signup text-center" style="padding: 2rem;">
                                <form class="form" method="POST" action="{{ route('printpass') }}">
                                    @csrf
                                    <div class="row card-login" style="justify-content:center;display: contents;">
                                        <div class="column text-centre">
                                            <h5 class="card-title">Create a pass: </h5>
                                        </div>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="nc-icon nc-single-02"></i>
                                                </span>
                                            </div>
                                            <input class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}" placeholder="{{ __('Passenger Name') }}" type="text" name="name" value="{{ old('text') }}" required>
                                            
                                            @if ($errors->has('text'))
                                                <span class="invalid-feedback" style="display: block;" role="alert">
                                                    <strong>{{ $errors->first('text') }}</strong>
                                                </span>
                                            @endif
                                        </div> 
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="nc-icon nc-mobile"></i>
                                                </span>
                                            </div>
                                            <input class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}" placeholder="{{ __('Telephone') }}" type="text" name="telephone" maxlength=10 value="{{ old('text') }}" required>
                                            
                                            @if ($errors->has('text'))
                                                <span class="invalid-feedback" style="display: block;" role="alert">
                                                    <strong>{{ $errors->first('text') }}</strong>
                                                </span>
                                            @endif
                                        </div> 
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="nc-icon nc-bookmark-2"></i>
                                                </span>
                                            </div>
                                            <select id='route' class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}" onchange="FiltreStops()">
                                                    <option value="">Select the route</option>
                                                    @foreach($routes as $r)
                                                        <option value="{{ $r->routeNo }}">Route to {{ $r->destination }}</option>
                                                    @endforeach
                                            </select>
                                            @if ($errors->has('number'))
                                                <span class="invalid-feedback" style="display: block;" role="alert">
                                                    <strong>{{ $errors->first('number') }}</strong>
                                                </span>
                                            @endif
                                        </div> 
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="nc-icon nc-bookmark-2"></i>
                                                </span>
                                            </div>
                                            <select name="stop" id='stop' class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}" onchange="SetCost()" name="stop">
                                                    <option value="">Select the stop</option>
                                                    @foreach($stops as $s)
                                                        <option class="stop {{ $s->routeNo }}" value="{{ $s->stop }}">{{ $s->stop }}</option>
                                                    @endforeach
                                            </select>
                                            @if ($errors->has('number'))
                                                <span class="invalid-feedback" style="display: block;" role="alert">
                                                    <strong>{{ $errors->first('number') }}</strong>
                                                </span>
                                            @endif
                                        </div> 
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="nc-icon nc-bookmark-2"></i>
                                                </span>
                                            </div>
                                            <select  name="bus" id='bus' class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}" onchange="FiltreSeats()">
                                                    <option value="">Select the bus</option>
                                                    @foreach($buses as $b)
                                                        <option class="bus {{ $b->routeNo }}" value="{{ $b->numberPlate }}">{{ $b->numberPlate }}</option>
                                                    @endforeach
                                            </select>
                                            @if ($errors->has('number'))
                                                <span class="invalid-feedback" style="display: block;" role="alert">
                                                    <strong>{{ $errors->first('number') }}</strong>
                                                </span>
                                            @endif
                                        </div> 
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="nc-icon nc-bookmark-2"></i>
                                                </span>
                                            </div>
                                            <select class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}" name="seatNo">
                                                    <option value="">Select the seat</option>
                                                    @foreach($seats as $s)
                                                        <option class="seat {{ $s->numberPlate }}" value="{{ $s->seatNo }}">{{ $s->seatNo }}</option>
                                                    @endforeach
                                            </select>
                                            @if ($errors->has('number'))
                                                <span class="invalid-feedback" style="display: block;" role="alert">
                                                    <strong>{{ $errors->first('number') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="nc-icon nc-bookmark-2"></i>
                                                </span>
                                            </div>
                                            <select class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}" name="cost">
                                                    <option value="">Cost</option>
                                                    @foreach($stops as $s)
                                                        <option class="cost {{ $s->stop }}" value="{{ $s->cost }}">{{ $s->cost }}</option>
                                                    @endforeach
                                            </select>
                                            @if ($errors->has('number'))
                                                <span class="invalid-feedback" style="display: block;" role="alert">
                                                    <strong>{{ $errors->first('number') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <button type="submit" class="btn btn-warning btn-round mb-3">{{ __('Create pass') }}</button>
                                    </div>
                                </form>
                            </div>     
                        </div>           
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            demo.checkFullPageBackgroundImage();
        });
    
        function FiltreStops () {
            var otherStops = document.getElementsByClassName('stop');
            var otherBuses = document.getElementsByClassName('bus');
            var filtre = document.getElementById('route').value;

            var selected = document.getElementsByClassName(filtre);

            for (var i = 0; i < otherStops.length; i++) {
                otherStops[i].style.display = "none";
            }

            for (var i = 0; i < otherBuses.length; i++) {
                otherBuses[i].style.display = "none";
            }

            for(var i = 0; i < selected.length; i++){
                selected[i].style.display = "table-row";
            }
        }

        function FiltreSeats () {
            var otherSeats = document.getElementsByClassName('seat');
            var filtre = document.getElementById('bus').value;

            var selected = document.getElementsByClassName(filtre);

            for (var i = 0; i < otherSeats.length; i++) {
                otherSeats[i].style.display = "none";
            }

            for(var i = 0; i < selected.length; i++){
                selected[i].style.display = "table-row";
            }
        }

        function SetCost () {
            var otherCosts = document.getElementsByClassName('cost');
            var filtre = document.getElementById('stop').value;

            var selected = document.getElementsByClassName(filtre);

            for (var i = 0; i < otherCosts.length; i++) {
                otherCosts[i].style.display = "none";
            }

            for(var i = 0; i < selected.length; i++){
                selected[i].style.display = "table-row";
            }
        }

    </script>
@endpush
