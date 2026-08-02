<?php

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Spatie\Multitenancy\Models\Tenant;

Route::get('/', function () {
    dd(User::first());
});
