@extends('layouts.app')
@section('title', "Inicio")

@section('app')
    <div class="container login-container">
        <div class="row">
            <div class="offset-xl-3 col-xl-6 text-center">
                <img src="/images/logo.png" alt="Battleship Online" class="img-fluid">
            </div>
        </div>
        <div class="row pt-5">
            <div class="offset-lg-4 col-lg-4 offset-md-3 col-md-6">
                <a href="{{ route('match') }}" class="btn btn-block btn-primary">Join match</a>
            </div>
        </div>
    </div>
@endsection
