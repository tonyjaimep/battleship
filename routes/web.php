<?php

use Illuminate\Http\Request;

Route::get('/', function (Request $request) { return view('home'); })->name('greet');

Route::get('/match', 'MatchController@showMatch')->name('match');
