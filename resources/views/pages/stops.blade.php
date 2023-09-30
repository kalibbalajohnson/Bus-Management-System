@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'routes'
])

@section('content')
    @if(!empty($result))
        <script>
            alert("<?php echo ($result)?>");
        </script>
    @endif
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
    <div class="content">
        <div class="row">
            <div class="card col-md-12">
                <div>
                    <div class="card-header">
                        <div class="card-footer" style="position: absolute;right: 1rem;">
                            <div class="text-center">
                                <button id="delete_route" class="btn btn-warning btn-round mb-3">{{ __('Delete route') }}</button>
                                <button id="edit_route" class="btn btn-warning btn-round mb-3">{{ __('Edit route') }}</button>
                            </div>
                        </div>
                        <h5 class="card-title">Route to <?php echo $route[0]->destination; ?></h5>
                        <p class="card-category">Add, delete and update routes and stops here based on the route destination.</p>
                    </div>
                    <div id="myPopup" class="popup">
                        <div class="popup-content">
                            <p>Are you sure you want to delete the route to <?php echo $route[0]->destination; ?></p>
                            <div class="button-container">
                                <button id="yesButton" class="btn btn-danger btn-round mb-3" onclick= "event.preventDefault(); window.location.href='{{ route('deleteroute',['route'=>$route[0]->routeNo]) }}';">Yes</button>
                                <button id="noButton" class="btn btn-primary btn-round mb-3">No</button>
                            </div>
                        </div>
                    </div>
                    <div id="edit" class="popup" >
                        <div class="popup-content" style="width: 40%;">
                                <div class="row" style="justify-content:center;display: contents;">
                                    <form class="form" method="POST" action="{{ route('updateroute',['route'=>$route[0]->routeNo]) }}">
                                        @csrf
                                        <div class="row card-login" style="justify-content:center;display: contents;">
                                            <div class="column text-centre">
                                                <h5 class="card-title">Update destination details:</h5>
                                            </div>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="nc-icon nc-world-2"></i>
                                                    </span>
                                                </div>
                                                <input class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}" placeholder="{{ __('Destination') }}" type="text" name="destination" value="{{ $route[0]->destination }}" required style="background: transparent; padding-left: 2rem;">
                                                
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
                                                <input class="form-control{{ $errors->has('number') ? ' is-invalid' : '' }}" placeholder="{{ __('Distance') }}" type="number" name="distance" value="{{ $route[0]->distance }}" required style="background: transparent; padding-left: 2rem;">
                                                
                                                @if ($errors->has('number'))
                                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                                        <strong>{{ $errors->first('number') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="nc-icon nc-money-coins"></i>
                                                    </span>
                                                </div>
                                                <input class="form-control{{ $errors->has('number') ? ' is-invalid' : '' }}" placeholder="{{ __('Cost') }}" type="number" name="cost" value="{{ $route[0]->cost }}" required style="background: transparent; padding-left: 2rem;">
                                                
                                                @if ($errors->has('number'))
                                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                                        <strong>{{ $errors->first('number') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                            <button type="submit" class="btn btn-warning btn-round mb-3">{{ __('Update') }}</button>
                                    </form>
                                            <button id="cancel" class="btn btn-primary btn-round mb-3">{{ __('Cancel') }}</button>
                                </div>                    
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if(empty($stops))
                                <h3 class="card-title" style="margin-left: 1rem;">There is no stop along this route.</h3>
                            @else
                                <div class="col-md-12">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class=" text-primary">
                                                <th>
                                                    Stop
                                                </th>
                                                <th>
                                                    Distance
                                                </th>
                                                <th class="text-right">
                                                    Cost
                                                </th>
                                                <th class="text-right">
                                                    Actions
                                                </th>
                                            </thead>
                                            <tbody>
                                                @foreach($stops as $c)
                                                    <tr>
                                                        <td>
                                                            {{ $c->stop }}
                                                        </td>
                                                        <td>
                                                            {{ $c->distance }}km
                                                        </td>
                                                        <td class="text-right">
                                                            Shs. {{ $c->cost }}
                                                        </td>
                                                        <td>
                                                            <div class="text-right">
                                                                <button id="delete" class="btn btn-warning btn-round mb-3" onclick="Delete({{ $route[0]->routeNo }},'{{ $c->stop }}')">{{ __('Delete') }}</button>                                           
                                                                <button id="edit" class="btn btn-warning btn-round mb-3" onclick="Edit({{ $route[0]->routeNo }},'{{ $c->stop }}')">{{ __('Edit') }}</button>
                                                            </div>
                                                        </td>
                                                    </tr>                                                    
                                                    <div id="delete_{{ $c->stop }}" class="popup">
                                                        <div class="popup-content">
                                                            <p>Are you sure you want to delete this stop?</p>
                                                            <div class="button-container">
                                                                <button id="yesbutton" class="btn btn-danger btn-round mb-3" onclick= "event.preventDefault(); window.location.href='{{ route('deletestop',['route'=>$route[0]->routeNo,'stop'=>$c->stop]) }}';">Yes</button>
                                                                <button class="btn btn-primary btn-round mb-3" onclick="var mypopup = document.getElementById('delete_{{ $c->stop }}') ;mypopup.style.display = 'none';">No</button>
                                                            </div>
                                                        </div>
                                                    </div>                                                    
                                                    <div id="edit_{{ $c->stop }}" class="popup">                                                        
                                                        <div class="popup-content" style="width: 40%;">
                                                                <div class="row" style="justify-content:center;display: contents;">
                                                                    <form class="form" method="POST" action="{{ route('updatestop',['route'=>$route[0]->routeNo,'stop'=>$c->stop]) }}">
                                                                        @csrf
                                                                        <div class="row card-login" style="display: contents;margin-left:2rem;">
                                                                            <div class="column text-centre">
                                                                                <h5 class="card-title">Edit destination</h5>
                                                                            </div>
                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                        <i class="nc-icon nc-bus-front-12"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}" placeholder="{{ __('Destination') }}" type="text" name="stop" value="{{ ($c->stop) }}" required style="background: transparent; padding-left: 2rem;">
                                                                                
                                                                                @if ($errors->has('text'))
                                                                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                                                                        <strong>{{ $errors->first('text') }}</strong>
                                                                                    </span>
                                                                                @endif
                                                                            </div>
                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                        <i class="nc-icon nc-pin-3"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input class="form-control{{ $errors->has('number') ? ' is-invalid' : '' }}" placeholder="{{ __('Distance') }}" type="number" name="distance" min="10" max="<?php echo $route[0]->distance ?>" value="{{ ($c->distance) }}" required style="background: transparent; padding-left: 2rem;">
                                                                                
                                                                                @if ($errors->has('number'))
                                                                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                                                                        <strong>{{ $errors->first('number') }}</strong>
                                                                                    </span>
                                                                                @endif
                                                                            </div>
                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                        <i class="nc-icon nc-money-coins"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input class="form-control{{ $errors->has('number') ? ' is-invalid' : '' }}" placeholder="{{ __('Cost') }}" type="number" name="cost" value="{{ ($c->cost) }}" required style="background: transparent; padding-left: 2rem;">
                                                                                
                                                                                @if ($errors->has('number'))
                                                                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                                                                        <strong>{{ $errors->first('number') }}</strong>
                                                                                    </span>
                                                                                @endif
                                                                            </div>
                                                                            <button type="submit" class="btn btn-warning btn-round mb-3">{{ __('Update') }}</button>
                                                                        </div>
                                                                    </form>
                                                                    <button id="close" class="btn btn-primary btn-round mb-3">{{ __('Cancel') }}</button>
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
                    </div>
                        <div class="row">
                            <form class="form" method="POST" action="{{ route('addstop',['route'=>$route[0]->routeNo]) }}">
                                @csrf
                                <div class="row card-login" style="display: -webkit-inline-box; margin-left:2rem;">
                                    <div class="column text-centre">
                                        <h5 class="card-title">Add stop along this route.</h5>
                                    </div>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="nc-icon nc-bus-front-12"></i>
                                            </span>
                                        </div>
                                        <input class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}" placeholder="{{ __('Stop name') }}" type="text" name="stop" value="{{ old('text') }}" required style="background: transparent; padding-left: 2rem;">
                                        
                                        @if ($errors->has('text'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $errors->first('text') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="nc-icon nc-pin-3"></i>
                                            </span>
                                        </div>
                                        <input class="form-control{{ $errors->has('number') ? ' is-invalid' : '' }}" placeholder="{{ __('Distance to stop') }}" type="number" name="distance" min="10" max="{{ $route[0]->distance }}" value="{{ old('number') }}" required style="background: transparent; padding-left: 2rem;">
                                        
                                        @if ($errors->has('number'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $errors->first('number') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="nc-icon nc-money-coins"></i>
                                            </span>
                                        </div>
                                        <input class="form-control{{ $errors->has('number') ? ' is-invalid' : '' }}" placeholder="{{ __('Cost') }}" type="number" name="cost" value="{{ old('number') }}" max="{{ $route[0]->cost }}" required style="background: transparent; padding-left: 2rem;">
                                        
                                        @if ($errors->has('number'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $errors->first('number') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <button type="submit" class="btn btn-warning btn-round mb-3">{{ __('Add stop') }}</button>
                                </div>
                            </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>

        function Delete(id,stop) {
            let str = "delete_";
            stop = str.concat(stop);
            var mypopup = document.getElementById(stop);
            var nobutton = document.getElementById("nobutton");

            mypopup.style.display = "block";        
        }
        
        function Edit(id,stop) {
            let str = "edit_";
            stop = str.concat(stop);
            var mypopup = document.getElementById(stop);
            var nobutton = document.getElementById("close");

            mypopup.style.display = "block";

            nobutton.onclick = function() {
            mypopup.style.display = "none";
            };         
        }
        const myButton = document.getElementById("delete_route");
        const myPopup = document.getElementById("myPopup");
        const noButton = document.getElementById("noButton");

        myButton.onclick = function() {
        myPopup.style.display = "block";
        };

        noButton.onclick = function() {
        myPopup.style.display = "none";
        };

        const button = document.getElementById("edit_route");
        const popup = document.getElementById("edit");
        const cancel = document.getElementById("cancel");

        button.onclick = function() {
        popup.style.display = "block";
        };

        cancel.onclick = function() {
        popup.style.display = "none";
        };
    </script>
@endpush