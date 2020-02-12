@extends('layouts.app')
@section('title', "Match")

@section('app')
    <match :match-id="{{ $match_id }}"></match>
@endsection
