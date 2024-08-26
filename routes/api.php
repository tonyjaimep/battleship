<?php

Route::post('/board/{board_id}/piece', 'PieceController@place');
Route::get('/board/{board_id}/pieces', 'BoardController@getPieces');

Route::post('/board/{target_board_id}/attack', 'AttackController@create');
Route::get('/board/{target_board_id}/attacks', 'BoardController@getAttacks');

Route::get('/game-match/{game_match_id}/state', 'GameMatchController@getState');
Route::get('/game-match/{game_match_id}/winner', 'GameMatchController@getWinner');
Route::get('/game-match/{game_match_id}/turn', 'GameMatchController@getTurn');

Route::post('login', 'UserController@login');
