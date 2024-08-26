@extends('layouts.app')
@section('title', "Match")

@section('app')
    <game-match :game-match-id="{{ $game_match_id }}" :own-board='@json($own_board)' :enemy-board='@json($enemy_board)' user-id='{{ $user_id }}'></match>
@endsection
