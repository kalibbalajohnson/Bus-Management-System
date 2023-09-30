@extends('layouts.app', [
    'class' => 'login-page',
    'elementActive' => ''
])

@section('content')
    <div class="content col-md-12">
        <div class="header py-5 pb-7 pt-lg-9">
            <div class="container col-md-10">
                <div class="header-body text-center mb-7">
                    <div class="row justify-content-center" style="align-items: center;">
                        <div class="col-lg-4 col-md-6">
                            <h1 class="@if(Auth::guest()) text-white @endif">{{ __('Thank you for choosing us!') }}</h1>

                            <h5 class="@if(Auth::guest()) text-white @endif text-lead mt-3 mb-0">
                                {{ __('We shall always be ready to share the memorable journies with you.') }}
                            </h5>
                            <button class="btn btn-primary btn-round mb-3" onclick= "event.preventDefault(); window.location.href='{{ route('welcome') }}';">Home</button>    
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

        window.open('pass.html','_blank')
    
    </script>
@endpush
