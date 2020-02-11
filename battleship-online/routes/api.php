<?php

Route::put('/match/{match_id}/piece', 'PieceController@place');
Route::put('/match/{match_id}/attack', 'AttackController@save');
