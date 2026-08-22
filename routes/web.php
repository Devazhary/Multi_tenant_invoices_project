<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoiceAttachmentsController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SectionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::resource('invoices', InvoiceController::class);
    Route::get('/section/{id}', [InvoiceController::class, 'getproducts'])->name('invoices.getproducts');
    Route::resource('sections', SectionController::class);
    Route::resource('products', ProductController::class);
    Route::resource('invoice-attachments', InvoiceAttachmentsController::class);
    Route::get('/invoices/details/{id}', [InvoicesDetailsController::class, 'show'])->name('invoices.details');
    Route::get('/show-attachments/{id}', [InvoicesDetailsController::class, 'showInvoiceAttachment'])->name('invoices.show_file');
    Route::get('/download-attachments/{id}', [InvoicesDetailsController::class, 'downloadInvoiceAttachment'])->name('invoices.download_file');
});
    
require __DIR__.'/auth.php';

Route::get('/{page}', [AdminController::class, 'index']);