<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response('Please interact with the API through the provided endpoints.', 200);
});
