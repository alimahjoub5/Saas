<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'dashboard')->name('dashboard');
Route::view('/leads', 'leads.index')->name('leads.index');
Route::view('/leads/{lead}', 'leads.show')->name('leads.show');
Route::view('/proposals/generator', 'proposals.generator')->name('proposals.generator');
Route::view('/profile', 'profile.index')->name('profile.index');
Route::view('/settings', 'settings.index')->name('settings.index');
