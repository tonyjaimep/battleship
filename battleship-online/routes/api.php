<?php

Route::post('/board/{board_id}/piece', 'PieceController@place');
Route::get('/board/{board_id}/pieces', 'BoardController@getPieces');

Route::post('/board/{target_board_id}/attack', 'AttackController@create');
Route::get('/board/{target_board_id}/attacks', 'BoardController@getAttacks');

Route::get('/match/{match_id}/state', 'MatchController@getState');

Route::post('login', 'UserController@login');
