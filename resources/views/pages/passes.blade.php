@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'passes'
])

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-footer" style="position: absolute;right: 2rem;top: 4rem;">
                        <div class="text-center">
                            <select id="filtre" style="width: 232px; height: 32px;" onchange="Filtre()">
                                <option value="staff">All journeys</option>
                                @foreach($passes as $p)
                                    <option value="{{ $p->journey}}">{{ $p->journey }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card-header">
                        <h3 class="card-title">Passes</h3>
                        <p class="card-category">View the passes made.</p>
                    </div>
                    <div class="card-body ">
                        @if(empty($passes))
                            <h3>There are no passes in the system</h3>
                            @else
                                <div class="col-md-12">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class=" text-primary">
                                                <th class="text-center">
                                                    Pass Number
                                                </th>
                                                <th class="text-center">
                                                    Date and time
                                                </th>
                                                <th class="text-center">
                                                    Name
                                                </th>
                                                <th class="text-center">
                                                    Telephone
                                                </th>
                                                <th class="text-center">
                                                    Journey
                                                </th>                                                
                                                <th class="text-center">
                                                    Bus
                                                </th>
                                                <th class="text-center">
                                                    Seat Number
                                                </th>                                                
                                                <th class="text-right">
                                                    Cost
                                                </th>
                                                <th class="text-right">
                                                    Actions
                                                </th>
                                            </thead>
                                            <tbody>
                                                @foreach($passes as $p)
                                                    <tr class="pass {{ $p->journey }}">
                                                        <td class="text-center">
                                                            {{ $p->passNo }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $p->date }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $p->name }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $p->telephone }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $p->journey }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $p->bus }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $p->seatNo }}
                                                        </td>
                                                        <td class="text-right">
                                                            {{ $p->cost }}
                                                        </td>
                                                        <td class="text-right">
                                                            <div class="text-right">                                          
                                                                <button id="print" class="btn btn-primary btn-round mb-3" onclick= "event.preventDefault(); window.location.href='{{ route('printpass',['pass'=>$p->passNo ]) }}';">{{ __('Print') }}</button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>

    function Filtre () {
        var busrecords = document.getElementsByClassName('pass');
        var filtre = document.getElementById('filtre').value;

        var selected = document.getElementsByClassName(filtre);

        for (var i = 0; i < busrecords.length; i++) {
            busrecords[i].style.display = "none";
        }

        for(var i = 0; i < selected.length; i++){
            selected[i].style.display = "table-row";
        }
    }

  </script>
@endpush