<?php

Route::get('users', 'API\UsuariosAPI@index');
Route::post('digitalizar', 'API\DigitalizarAPI@store');
