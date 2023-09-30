@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'dashboard'
])

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="nc-icon nc-pin-3 text-warning"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Stops</p>
                                    <p class="card-title">{{ count($stops) }}<p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr>
                        <div class="stats">
                            Across {{ count($routes) }} routes
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="nc-icon nc-money-coins text-success"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Revenue</p>
                                    <p class="card-title">Shs. {{ $sum[0]->sum }}
                                        <p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr>
                        <div class="stats">
                            From {{ count($passes) }} passes.
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="nc-icon nc-bus-front-12 text-danger"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Buses</p>
                                    <p class="card-title">{{ count($buses) }}<p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr>
                        <div class="stats">
                            With {{ count($loading) }} loading and {{ count($travelling) }} travelling.
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="nc-icon nc-single-02 text-primary"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category">Customers</p>
                                    <p class="card-title">{{ count($customers) }}
                                        <p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr>
                        <div class="stats">
                            <i class="fa fa-refresh"></i> Update now
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="nc-icon nc-bus-front-12 text-primary"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category"></p>
                                    <p class="card-title">Parked buses<p>
                                </div>
                            </div>
                        </div>
                        <div class="table-reponsive">
                            <table class="table">
                                @foreach($parked as $p)
                                    <tr>
                                        <td class="text-center">
                                            <h5>{{ $p->numberPlate }}</h5>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-primary btn-round mb-3" onclick= "event.preventDefault(); window.location.href='{{ route('loadbus',['bus'=>$p->numberPlate ]) }}';">load</button>
                                        </td>
                                    </tr>                                    
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="nc-icon nc-bus-front-12 text-success"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category"></p>
                                    <p class="card-title">Loading buses<p>
                                </div>
                            </div>
                        </div>
                        <div class="table-reponsive">
                            <table class="table">
                                @foreach($loading as $l)
                                    <tr>                                        
                                        <td class="text-left">
                                            <button class="btn btn-success btn-round mb-3" onclick= "event.preventDefault(); window.location.href='{{ route('parkbus',['bus'=>$l->numberPlate ]) }}';">park</button>
                                        </td>
                                        <td class="text-center">
                                            <h5>{{ $l->numberPlate }}</h5>
                                        </td>
                                        <td class="text-right">
                                            <button class="btn btn-success btn-round mb-3" onclick= "event.preventDefault(); window.location.href='{{ route('setoffbus',['bus'=>$l->numberPlate ]) }}';">Set Off</button>
                                        </td>
                                    </tr>                                    
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-stats">
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-5 col-md-4">
                                <div class="icon-big text-center icon-warning">
                                    <i class="nc-icon nc-bus-front-12 text-warning"></i>
                                </div>
                            </div>
                            <div class="col-7 col-md-8">
                                <div class="numbers">
                                    <p class="card-category"></p>
                                    <p class="card-title">Travelling buses<p>
                                </div>
                            </div>
                        </div>
                        <div class="table-reponsive">
                            <table class="table">
                                @foreach($travelling as $t)
                                    <tr>
                                        <td class="text-center">
                                            <h5>{{ $t->numberPlate }}</h5>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-warning btn-round mb-3" onclick= "event.preventDefault(); window.location.href='{{ route('parkbus',['bus'=>$t->numberPlate ]) }}';">park</button>
                                        </td>
                                    </tr>                                    
                                @endforeach
                            </table>
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
            // Javascript method's body can be found in assets/assets-for-demo/js/demo.js
            demo.initChartsPages();
        });
    </script>
@endpush