@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'staff'
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
                <div class="card">
                    <div class="card-footer" style="position: absolute;right: 2rem;top: 4rem;">
                        <div class="text-center">
                            <select id="filtre" style="width: 232px; height: 32px;" onchange="Filtre()">
                                <option value="staff">All positions</option>
                                @foreach($positions as $p)
                                    <option value="{{ $p->position}}">{{ $p->position }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card-header">
                        <h3 class="card-title">Staff</h3>
                        <p class="card-category">Modify the staff details from here.</p>
                    </div>
                    <div class="card-body ">
                        @if(empty($staff))
                            <h3>There are no staff in the system</h3>
                            @else
                                <div class="col-md-12">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class=" text-primary">
                                                <th>
                                                    Staff Number
                                                </th>
                                                <th>
                                                    Name
                                                </th>
                                                <th class="text-right">
                                                    Telephone
                                                </th>
                                                <th class="text-right">
                                                    Permit Number
                                                </th>
                                                <th class="text-right">
                                                    Actions
                                                </th>

                                            </thead>
                                            <tbody>
                                                @foreach($staff as $s)
                                                    <tr class="staff {{ $s-> position }}">
                                                        <td>
                                                            {{ $s->staffNo }}
                                                        </td>
                                                        <td>
                                                            {{ $s->name}}
                                                        </td>
                                                        <td class="text-right">
                                                            {{ $s->telephone }}
                                                        </td>
                                                        <td class="text-right">
                                                            {{ $s->permitNo }}
                                                        </td>
                                                        <td class="text-right">
                                                            <div class="text-right">
                                                                <button id="delete" class="btn btn-warning btn-round mb-3" onclick="Delete('{{ $s->staffNo }}')">{{ __('Delete') }}</button>                                           
                                                                <button id="edit" class="btn btn-warning btn-round mb-3" onclick="Edit('{{ $s->staffNo }}')">{{ __('Edit') }}</button>
                                                            </div>
                                                        </td>
                                                    </tr>                                                    
                                                    <div id="delete_{{ $s->staffNo  }}" class="popup">
                                                        <div class="popup-content">
                                                            <p>Are you sure you want to delete this staff member from the system?</p>
                                                            <div class="button-container">
                                                                <button id="yesbutton" class="btn btn-danger btn-round mb-3" onclick= "event.preventDefault(); window.location.href='{{ route('deletestaff',['staff'=>$s->staffNo ]) }}';">Yes</button>
                                                                <button class="btn btn-primary btn-round mb-3" onclick="var popup = document.getElementById('delete_{{ $s->staffNo  }}') ;popup.style.display = 'none';">No</button>
                                                            </div>
                                                        </div>
                                                    </div>                                                    
                                                    <div id="edit_{{ $s->staffNo }}" class="popup">
                                                        <div class="popup-content" style="width: 40%;">                        
                                                            <div class="row" style="justify-content:center;display: contents;">
                                                                    <form class="form" method="POST" action="{{ route('updatestaff',['staff'=>$s->staffNo]) }}">
                                                                        @csrf
                                                                        <div class="row card-login" style="justify-content:center;display: contents;" >
                                                                            <div class="column text-centre">
                                                                                <h5 class="card-title">Edit staff member details: </h5>
                                                                            </div>
                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                        <i class="nc-icon nc-single-02"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}" placeholder="{{ __('Staff Name') }}" type="text" name="name" value="{{ $s->name }}" required>
                                                                                
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
                                                                                <select name="position" class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}">
                                                                                        <option value="{{ $s->position }}">{{ $s->position }}</option>
                                                                                        <option value="Driver">Driver</option>
                                                                                        <option value="Co-driver">Co-driver</option>
                                                                                </select>
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
                                                                                <input class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}" placeholder="{{ __('Telephone') }}" type="text" name="telephone" maxlength=10 value="{{ $s->telephone}}" required>
                                                                                
                                                                                @if ($errors->has('text'))
                                                                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                                                                        <strong>{{ $errors->first('text') }}</strong>
                                                                                    </span>
                                                                                @endif
                                                                            </div> 
                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">
                                                                                        <i class="nc-icon nc-badge"></i>
                                                                                    </span>
                                                                                </div>
                                                                                <input class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}" placeholder="{{ __('Permit Number') }}" type="text" name="permitNo" maxlength=15 value="{{ $s->permitNo }}" required>
                                                                                
                                                                                @if ($errors->has('text'))
                                                                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                                                                        <strong>{{ $errors->first('text') }}</strong>
                                                                                    </span>
                                                                                @endif
                                                                            </div> 
                                                                            <button type="submit" class="btn btn-warning btn-round mb-3">{{ __('Update') }}</button>
                                                                        </div>
                                                                    </form>
                                                                        <button class="btn btn-primary btn-round mb-3" onclick="var popup = document.getElementById('edit_{{ $s->staffNo }}') ;popup.style.display = 'none';">{{ __('Cancel') }}</button>
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
                        <div class="row">
                                <form class="form" method="POST" action="{{ route('addstaff') }}">
                                    @csrf
                                    <div class="row card-login" style="display: -webkit-inline-box; margin-left:2rem;">
                                        <div class="column text-centre">
                                            <h5 class="card-title">Add a staff member: </h5>
                                        </div>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="nc-icon nc-single-02"></i>
                                                </span>
                                            </div>
                                            <input class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}" placeholder="{{ __('Staff Name') }}" type="text" name="name" value="{{ old('text') }}" required>
                                            
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
                                            <select name="position" class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}">
                                                    <option value="">Position</option>
                                                    <option value="Driver">Driver</option>
                                                    <option value="Co-driver">Co-driver</option>
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
                                                    <i class="nc-icon nc-badge"></i>
                                                </span>
                                            </div>
                                            <input class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}" placeholder="{{ __('Permit Number') }}" type="text" name="permitNo" maxlength=15 value="{{ old('text') }}" required>
                                            
                                            @if ($errors->has('text'))
                                                <span class="invalid-feedback" style="display: block;" role="alert">
                                                    <strong>{{ $errors->first('text') }}</strong>
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
    </div>
@endsection

@push('scripts')
    <script>

    function Filtre () {
        var busrecords = document.getElementsByClassName('staff');
        var filtre = document.getElementById('filtre').value;

        var selected = document.getElementsByClassName(filtre);

        for (var i = 0; i < busrecords.length; i++) {
            busrecords[i].style.display = "none";
        }

        for(var i = 0; i < selected.length; i++){
            selected[i].style.display = "table-row";
        }
    }

    function Delete(staffNo) {
            let str = "delete_";
            var staff = str.concat(staffNo);
            var mypopup = document.getElementById(staff);
            var nobutton = document.getElementById("nobutton");

            mypopup.style.display = "block";
        }
        
        function Edit(staffNo) {
            let str = "edit_";
            var staff = str.concat(staffNo);
            var mypopup = document.getElementById(staff);
            var nobutton = document.getElementById("close");

            mypopup.style.display = "block";         
        }

  </script>
@endpush