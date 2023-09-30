@extends('layouts.app', [
    'class' => 'login-page',
    'elementActive' => ''
])

@section('content')
    <style>
        .slideshow-container {
        position: relative;
        width: 100%;
        height: 400px;
        overflow: hidden;
        }

        .slide {
        position: absolute;
        width: 100%;
        height: 100%;
        opacity: 0;
        transition: opacity 1s ease-in-out;
        }

        .slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        }

        .slide.active {
        opacity: 1;
        }

    </style>

    <div class="content col-md-12 ml-auto mr-auto">
        <div class="header py-5 pb-7 pt-lg-9">
            <div class="container col-md-10">
                <div class="header-body text-center mb-7">
                    <div class="row justify-content-center" style="align-items: center;">
                        <div class="col-lg-5 col-md-5 ml-auto text-right">
                            <h1 class="@if(Auth::guest()) text-white @endif">{{ __('Welcome to the Johnson Bus Pass and Route Managment System.') }}</h1>

                            <h5 class="@if(Auth::guest()) text-white @endif text-lead mt-3 mb-0">
                                {{ __('Get a pass with us and discover seamless bus travel. Embark on unforgettable journeys with us.') }}
                            </h5>
                        </div>
                        <div class="col-lg-5 col-md-5 ml-auto text-left">
                            <div class="card ">
                                <div class="card-header" style="padding-bottom: 15px;">
                                    <div class="text-center"><div class="slideshow-container">
                                        <div class="slide section-image active" data-image="{{ asset('paper') . '/' . ($backgroundImagePath ?? "img/bg/1.jpg") }}">
                                        </div>
                                        <div class="slide section-image" data-image="{{ asset('paper') . '/' . ($backgroundImagePath ?? "img/bg/2.jpg") }}">
                                        </div>
                                        <div class="slide section-image" data-image="{{ asset('paper') . '/' . ($backgroundImagePath ?? "img/bg/3.jpg") }}">
                                        </div>
                                    </div>
                                    <div class="card-footer" style="z-index: 3;position: absolute;right: 0.5rem;top: 22rem;">
                                        <div class="text-center">
                                            <button id="print" class="btn btn-primary btn-round mb-3" onclick= "event.preventDefault(); window.location.href='{{ route('createpass') }}';">{{ __('Create a Pass') }}</button>
                                        </div>
                                    </div>
                                    </div>
                                </div>
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

        document.addEventListener("DOMContentLoaded", function() {
        const slides = document.querySelectorAll(".slide");
        let currentSlide = 0;

        function showSlide(index) {
            slides.forEach(function(slide) {
            slide.classList.remove("active");
            });

            slides[index].classList.add("active");
        }

        function nextSlide() {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        }

        setInterval(nextSlide, 3000); // Change slide every 3 seconds
        });

    </script>
@endpush
