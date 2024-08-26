<?php

use Illuminate\Http\Request;

Route::get('/', function (Request $request) { return view('home'); })->name('greet');

Route::get('/game-match', 'GameMatchController@showGameMatch')->name('game-match');
