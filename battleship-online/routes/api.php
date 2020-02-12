<?php

Route::post('/match/{match_id}/piece', 'PieceController@place');
Route::put('/match/{match_id}/attack', 'AttackController@save');
Route::get('/match/{match_id}/state', 'MatchController@getState');
