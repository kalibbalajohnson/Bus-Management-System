@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'routes'
])

@section('content')
    @if(!empty($result))
        <script>
            alert("<?php echo ($result)?>")
        </script>
    @endif
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Routes and Stops</h3>
                        <p class="card-category">Add, delete and update routes and stops here based on the route destination.</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if(empty($routes))
                            <h2 class="card-title" style="margin-left: 1rem;">No routes in the system.</h2>
                            @else
                                @foreach($routes as $c)
                                <div class="col-lg-3 col-md-6 col-sm-6">
                                    <div class="card card-stats">
                                        <div class="card-body ">
                                            <div class="numbers card-title" style="text-align: left; color: black;">                                   
                                                <a href= "{{ route('stops',['route'=>$c->routeNo]) }}" style="color: black;" >{{ $c->destination }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    
                    <div class="row">
                            <form class="form" method="POST" action="{{ action('App\Http\Controllers\RoutesController@add') }}">
                                @csrf
                                <div class="row card-login" style="display: -webkit-inline-box; margin-left:2rem;">
                                    <div class="column text-centre">
                                        <h5 class="card-title">Add destination</h5>
                                    </div>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="nc-icon nc-world-2"></i>
                                            </span>
                                        </div>
                                        <input class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}" placeholder="{{ __('Destination name') }}" type="text" name="destination" value="{{ old('text') }}" required style="background: transparent; padding-left: 2rem;">
                                        
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
                                        <input class="form-control{{ $errors->has('number') ? ' is-invalid' : '' }}" placeholder="{{ __('Distance to stop') }}" type="number" name="distance" value="{{ old('number') }}" required style="background: transparent; padding-left: 2rem;">
                                        
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
                                        <input class="form-control{{ $errors->has('number') ? ' is-invalid' : '' }}" placeholder="{{ __('Cost') }}" type="number" name="cost" value="{{ old('number') }}" required style="background: transparent; padding-left: 2rem;">
                                        
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
@endsection

@push('scripts')
    <script>
        function SelectText(element) {
            var doc = document,
                text = element,
                range, selection;
            if (doc.body.createTextRange) {
                range = document.body.createTextRange();
                range.moveToElementText(text);
                range.select();
            } else if (window.getSelection) {
                selection = window.getSelection();
                range = document.createRange();
                range.selectNodeContents(text);
                selection.removeAllRanges();
                selection.addRange(range);
            }
        }
        window.onload = function () {
            var iconsWrapper = document.getElementById('icons-wrapper'),
                listItems = iconsWrapper.getElementsByTagName('li');
            for (var i = 0; i < listItems.length; i++) {
                listItems[i].onclick = function fun(event) {
                    var selectedTagName = event.target.tagName.toLowerCase();
                    if (selectedTagName == 'p' || selectedTagName == 'em') {
                        SelectText(event.target);
                    } else if (selectedTagName == 'input') {
                        event.target.setSelectionRange(0, event.target.value.length);
                    }
                }

                var beforeContentChar = window.getComputedStyle(listItems[i].getElementsByTagName('i')[0], '::before').getPropertyValue('content').replace(/'/g, "").replace(/"/g, ""),
                    beforeContent = beforeContentChar.charCodeAt(0).toString(16);
                var beforeContentElement = document.createElement("em");
                beforeContentElement.textContent = "\\" + beforeContent;
                listItems[i].appendChild(beforeContentElement);

                //create input element to copy/paste chart
                var charCharac = document.createElement('input');
                charCharac.setAttribute('type', 'text');
                charCharac.setAttribute('maxlength', '1');
                charCharac.setAttribute('readonly', 'true');
                charCharac.setAttribute('value', beforeContentChar);
                listItems[i].appendChild(charCharac);
            }
        }
    </script>
@endpush