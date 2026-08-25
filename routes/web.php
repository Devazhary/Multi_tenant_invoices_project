<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoiceAttachmentsController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\InvoiceReportController;
use App\Http\Controllers\CustomerReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::group(['middleware' => ['permission:الفواتير|قائمة الفواتير']], function () {
        Route::resource('invoices', InvoiceController::class);
        Route::get('/invoices/details/{id}', [InvoicesDetailsController::class, 'show'])->name('invoices.details');
        Route::resource('invoice-attachments', InvoiceAttachmentsController::class);
        Route::get('/show-attachments/{id}', [InvoicesDetailsController::class, 'showInvoiceAttachment'])->name('invoices.show_file');
        Route::get('/download-attachments/{id}', [InvoicesDetailsController::class, 'downloadInvoiceAttachment'])->name('invoices.download_file');
    });

    Route::group(['middleware' => ['permission:حالة الدفع']], function () {
        Route::get('/invoices/status/{id}', [InvoiceController::class, 'status_show'])->name('invoices.status_show');
        Route::post('/invoices/status/{id}', [InvoiceController::class, 'status_update'])->name('invoices.status_update');
    });

    Route::get('/section/{id}', [InvoiceController::class, 'getproducts'])->name('invoices.getproducts'); // API endpoint for dependent dropdown

    // Sections
    Route::get('sections', [SectionController::class, 'index'])->name('sections.index')->middleware('permission:الاقسام');
    Route::post('sections', [SectionController::class, 'store'])->name('sections.store')->middleware('permission:اضافة قسم');
    Route::put('sections/{section}', [SectionController::class, 'update'])->name('sections.update')->middleware('permission:تعديل قسم');
    Route::patch('sections/{section}', [SectionController::class, 'update'])->name('sections.update')->middleware('permission:تعديل قسم');
    Route::delete('sections/{section}', [SectionController::class, 'destroy'])->name('sections.destroy')->middleware('permission:حذف قسم');

    // Products
    Route::get('products', [ProductController::class, 'index'])->name('products.index')->middleware('permission:المنتجات');
    Route::post('products', [ProductController::class, 'store'])->name('products.store')->middleware('permission:اضافة منتج');
    Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update')->middleware('permission:تعديل منتج');
    Route::patch('products/{product}', [ProductController::class, 'update'])->name('products.update')->middleware('permission:تعديل منتج');
    Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy')->middleware('permission:حذف منتج');

    Route::group(['middleware' => ['permission:الفواتير المدفوعة']], function () {
        Route::get('/paid-invoices', [InvoiceController::class, 'paidInvoices'])->name('invoices.paid');
    });

    Route::group(['middleware' => ['permission:الفواتير الغير مدفوعة']], function () {
        Route::get('/unpaid-invoices', [InvoiceController::class, 'unpaidInvoices'])->name('invoices.unpaid');
    });

    Route::group(['middleware' => ['permission:الفواتير المدفوعة جزئيا']], function () {
        Route::get('/partial-paid-invoices', [InvoiceController::class, 'partialPaidInvoices'])->name('invoices.partial');
    });

    Route::group(['middleware' => ['permission:قائمة الفواتير المؤرشفة']], function () {
        Route::get('/archived-invoices', [InvoiceController::class, 'archivedInvoices'])->name('invoices.archived');
    });

    Route::group(['middleware' => ['permission:ارشيف فاتورة']], function () {
        Route::get('/invoices-archive/{id}', [InvoiceController::class, 'archiveInvoice'])->name('invoices.archive');
    });

    Route::group(['middleware' => ['permission:الغاء ارشيف فاتورة']], function () {
        Route::get('/invoices-restore/{id}', [InvoiceController::class, 'unArchiveInvoice'])->name('invoices.restore');
    });

    Route::group(['middleware' => ['permission:حذف الفواتير المؤرشفة']], function () {
        Route::delete('/archived-invoices-delete/{id}', [InvoiceController::class, 'deleteArchivedInvoice'])->name('archived-invoices.delete');
    });

    Route::group(['middleware' => ['permission:طباعة فاتورة']], function () {
        Route::get('/print-invoice/{id}', [InvoiceController::class, 'printInvoice'])->name('invoices.print');
    });

    Route::group(['middleware' => ['permission:تصدير اكسيل']], function () {
        Route::get('/invoices-export', [InvoiceController::class, 'export'])->name('invoices.export');
    });

    Route::group(['middleware' => ['permission:المستخدمين']], function () {
        Route::resource('users', UserController::class);
    });

    Route::group(['middleware' => ['permission:صلاحيات المستخدمين']], function () {
        Route::resource('roles', \App\Http\Controllers\RoleController::class);
    });

    // Reports
    Route::group(['middleware' => ['permission:تقرير الفواتير']], function () {
        Route::get('/reports/invoices', [InvoiceReportController::class, 'index'])->name('reports.invoices');
    });

    Route::group(['middleware' => ['permission:تقرير العملاء']], function () {
        Route::get('/reports/customers', [CustomerReportController::class, 'index'])->name('reports.customers');
    });
});
    
require __DIR__.'/auth.php';

Route::get('/{page}', [AdminController::class, 'index']);