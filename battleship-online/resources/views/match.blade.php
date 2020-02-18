@extends('layouts.app')
@section('title', "Match")

@section('app')
    <match :match-id="{{ $match_id }}" :own-board='@json($own_board)' :enemy-board='@json($enemy_board)' user-id='{{ $user_id }}'></match>
@endsection
