@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'buses'
])

@section('content')
    <style>
        .popup {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .popup-content {
            background-color: white;
            margin: 20% auto;
            padding: 20px;
            border-radius: 5px;
            width: 50%;
            text-align: center;
        }

        .button-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .popup button {
            margin: 10px;
            padding: 10px 20px;
            border-radius: 5px;
            color: white;
            font-weight: bold;
            border: none;
            cursor: pointer;
        }
    </style>
    @if(!empty($result))
        <script>
            alert("<?php echo ($result)?>");
        </script>
    @endif
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                        <div class="card-footer" style="position: absolute;right: 2rem;top: 4rem;">
                            <div class="text-center">
                                <select id="filtre" style="width: 232px; height: 32px;" onchange="Filtre()">
                                    <option value="bus">All destinations</option>
                                    @foreach($routes as $r)
                                        <option value="{{ $r->routeNo }}">{{ $r->destination }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="card-header ">                        
                            <h2 class="card-title">Buses</h2>
                            <p class="card-category">Add, delete and update buses here.</p>
                        </div>
                        <div class="card-body ">
                            @if(empty($buses))
                                <h3>There are no buses in the system</h3>
                                @else
                                    <div class="col-md-12">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead class=" text-primary">
                                                    <th>
                                                        Number Plate
                                                    </th>
                                                    <th class="text-right">
                                                        Driver
                                                    </th>
                                                    <th class="text-right">
                                                        Co-driver
                                                    </th>
                                                    <th class="text-right">
                                                        Actions
                                                    </th>

                                                </thead>
                                                <tbody>
                                                    @foreach($buses as $b)
                                                        <tr class="bus {{ $b-> routeNo }}">
                                                            <td>
                                                                {{ $b->numberPlate }}
                                                            </td>
                                                            <td class="text-right">
                                                                {{ $b-> driver}}
                                                            </td>
                                                            <td class="text-right">
                                                                {{ $b-> codriver }}
                                                            </td>
                                                            <td>
                                                                <div class="text-right">
                                                                    <button id="delete" class="btn btn-warning btn-round mb-3" onclick="Delete('{{ $b->numberPlate }}')">{{ __('Delete') }}</button>                                           
                                                                    <button id="edit" class="btn btn-warning btn-round mb-3" onclick="Edit('{{ $b->numberPlate }}')">{{ __('Edit') }}</button>
                                                                </div>
                                                            </td>
                                                        </tr>                                                    
                                                        <div id="delete_{{ $b->numberPlate }}" class="popup">
                                                            <div class="popup-content">
                                                                <p>Are you sure you want to delete this bus from the system?</p>
                                                                <div class="button-container">
                                                                    <button id="yesbutton" class="btn btn-danger btn-round mb-3" onclick= "event.preventDefault(); window.location.href='{{ route('deletebus',['plate'=>$b->numberPlate]) }}';">Yes</button>
                                                                    <button class="btn btn-primary btn-round mb-3" onclick="var popup = document.getElementById('delete_{{ $b->numberPlate }}') ;popup.style.display = 'none';">No</button>
                                                                </div>
                                                            </div>
                                                        </div>                                                    
                                                        <div id="edit_{{ $b->numberPlate }}" class="popup">
                                                            <div class="popup-content" style="width: 40%;">
                                                                    <div class="row" style="justify-content:center;display: contents;">
                                                                        <form class="form" method="POST" action="{{ route('updatebus',['plate'=>$b->numberPlate]) }}">
                                                                            @csrf
                                                                            <div class="row card-login" style = "justify-content:center;">
                                                                                <div class="column text-centre">
                                                                                    <h5 class="card-title">Edit bus details: </h5>
                                                                                </div>
                                                                                <div class="input-group">
                                                                                    <div class="input-group-prepend">
                                                                                        <span class="input-group-text">
                                                                                            <i class="nc-icon nc-world-2"></i>
                                                                                        </span>
                                                                                    </div>
                                                                                    <input class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}" placeholder="{{ __('Number plate') }}" type="text" name="plate" value="{{ $b->numberPlate }}" required>
                                                                                    
                                                                                    @if ($errors->has('text'))
                                                                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                                                                            <strong>{{ $errors->first('text') }}</strong>
                                                                                        </span>
                                                                                    @endif
                                                                                </div> 
                                                                                <div class="input-group">
                                                                                    <div class="input-group-prepend">
                                                                                        <span class="input-group-text">
                                                                                            <i class="nc-icon nc-delivery-fast"></i>
                                                                                        </span>
                                                                                    </div>
                                                                                    <select name="routeNo" class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}">
                                                                                        <option value="">Select a destination</option>
                                                                                        @foreach($routes as $r)
                                                                                            <option value="{{ $r->routeNo }}">{{ $r->destination }}</option>
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
                                                                                            <i class="nc-icon nc-single-02"></i>
                                                                                        </span>
                                                                                    </div>
                                                                                    <select name="driver" class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}">
                                                                                        <option value="{{ $b->driver }}">{{ $b->driver }}</option>
                                                                                        @foreach($drivers as $r)
                                                                                            <option value="{{ $r->staffNo }}">{{ $r->name }}</option>
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
                                                                                            <i class="nc-icon nc-single-02"></i>
                                                                                        </span>
                                                                                    </div>
                                                                                    <select name="codriver" class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}">
                                                                                        <option value="{{ $b->codriver }}">{{ $b->codriver }}</option>
                                                                                        @foreach($codrivers as $r)
                                                                                            <option value="{{ $r->staffNo }}">{{ $r->name }}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                    @if ($errors->has('number'))
                                                                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                                                                            <strong>{{ $errors->first('number') }}</strong>
                                                                                        </span>
                                                                                    @endif
                                                                                </div> 
                                                                                <button type="submit" class="btn btn-warning btn-round mb-3">{{ __('Update') }}</button>
                                                                            </div>
                                                                        </form>
                                                                        <button id="close" class="btn btn-primary btn-round mb-3" onclick="var popup = document.getElementById('edit_{{ $b->numberPlate }}') ;popup.style.display = 'none';">{{ __('Cancel') }}</button>
                                                                    </div>       
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif
                        </div>
                        <div class="row">
                                <form class="form" method="POST" action="{{ route('addbus') }}">
                                    @csrf
                                    <div class="row card-login" style="display: -webkit-inline-box; margin-left:2rem;">
                                        <div class="column text-centre">
                                            <h5 class="card-title">Add a bus</h5>
                                        </div>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="nc-icon nc-world-2"></i>
                                                </span>
                                            </div>
                                            <input class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}" placeholder="{{ __('Number plate') }}" type="text" name="plate" value="{{ old('text') }}" required>
                                            
                                            @if ($errors->has('text'))
                                                <span class="invalid-feedback" style="display: block;" role="alert">
                                                    <strong>{{ $errors->first('text') }}</strong>
                                                </span>
                                            @endif
                                        </div> 
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="nc-icon nc-delivery-fast"></i>
                                                </span>
                                            </div>
                                            <select name="routeNo" class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}">
                                                <option value="">Select a destination</option>
                                                @foreach($routes as $r)
                                                    <option value="{{ $r->routeNo }}">{{ $r->destination }}</option>
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
                                                    <i class="nc-icon nc-single-02"></i>
                                                </span>
                                            </div>
                                            <select name="driver" class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}">
                                                <option value="">Driver staff number</option>
                                                @foreach($drivers as $r)
                                                    <option value="{{ $r->staffNo }}">{{ $r->name }}</option>
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
                                                    <i class="nc-icon nc-single-02"></i>
                                                </span>
                                            </div>
                                            <select name="codriver" class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}">
                                                <option value="">Co-driver staff number</option>
                                                @foreach($codrivers as $r)
                                                    <option value="{{ $r->staffNo }}">{{ $r->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('number'))
                                                <span class="invalid-feedback" style="display: block;" role="alert">
                                                    <strong>{{ $errors->first('number') }}</strong>
                                                </span>
                                            @endif
                                        </div> 
                                        <button type="submit" class="btn btn-warning btn-round mb-3">{{ __('Add') }}</button>
                                    </div>
                                </form>
                            </div>                
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>

    function Filtre () {
        var busrecords = document.getElementsByClassName('bus');
        var filtre = document.getElementById('filtre').value;

        var selected = document.getElementsByClassName(filtre);

        for (var i = 0; i < busrecords.length; i++) {
            busrecords[i].style.display = "none";
        }

        for(var i = 0; i < selected.length; i++){
            selected[i].style.display = "table-row";
        }
    }

    function Delete(plate) {
            let str = "delete_";
            var bus = str.concat(plate);
            var mypopup = document.getElementById(bus);
            var nobutton = document.getElementById("nobutton");

            mypopup.style.display = "block";
        }
        
        function Edit(plate) {
            let str = "edit_";
            var bus = str.concat(plate);
            var mypopup = document.getElementById(bus);
            var nobutton = document.getElementById("close");

            mypopup.style.display = "block";         
        }

  </script>
@endpush