@extends('site.layouts.master')
@section('title')
@endsection
@section('description')
@endsection
@section('image')
@endsection
@section('css')
    <style>
        .page-home {
            position: relative;
            height: 100%;
            width: 100%;
            background: url('/site/images/home/bg-home.jpg') no-repeat center center;
            background-size: cover;
        }

        .btn-demo-vr360 {
            position: absolute;
            top: 60%;
            left: 15%;
            background: #c21a1a;
            padding: 20px 50px;
            border-radius: 0;
            border-top-left-radius: 30px;
            border-bottom-right-radius: 30px;
            text-decoration: none;
            color: #fff;
            box-shadow: 0 0 20px 0 rgba(225, 118, 118, 0.5);
            font-size: 24px;
            font-weight: 600;
            transition: all 0.3s ease;
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            font-style: italic;
            animation: shake 2s infinite;

            &:hover {
                background: #f8cb2e;
                color: #000;
                box-shadow: 0 0 20px 0 rgba(225, 118, 118, 0.5);
            }

            ;
            /* Rung lắc */
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            20% {
                transform: translateX(-3px);
            }

            40% {
                transform: translateX(3px);
            }

            60% {
                transform: translateX(-3px);
            }

            80% {
                transform: translateX(3px);
            }
        }

        @keyframes pulseWave {
            0% {
                transform: scale(1);
                opacity: 0.6;
            }

            100% {
                transform: scale(2.5);
                opacity: 0;
            }
        }
    </style>
@endsection
@section('content')
    <div class="page-home">
        <a href="{{ route('front.demo-vr360') }}" class="btn-demo-vr360">Khám phá ngay</a>
    </div>
@endsection
@push('script')
@endpush
