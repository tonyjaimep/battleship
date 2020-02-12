<?php

Route::post('/board/{board_id}/piece', 'PieceController@place');
Route::get('/board/{board_id}/pieces', 'BoardController@getPieces');
Route::put('/match/{match_id}/attack', 'AttackController@save');
Route::get('/match/{match_id}/state', 'MatchController@getState');
