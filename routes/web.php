<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FleetController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\BookingAdminController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\MaintenanceController;
use App\Http\Controllers\Admin\TourPackageController;
use App\Http\Controllers\Admin\TravelController;
use App\Http\Controllers\Admin\WeddingController;
use App\Http\Controllers\Admin\PromoController;
use App\Http\Controllers\Admin\CmsController;
use App\Http\Controllers\Admin\CustomerAdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ActivityLogController as AdminLogController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\NotificationController;

/*
|--------------------------------------------------------------------------
| Public Website
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang-kami', [HomeController::class, 'about'])->name('about');
Route::get('/layanan', [HomeController::class, 'services'])->name('services');
Route::get('/layanan/{slug}', [HomeController::class, 'serviceDetail'])->name('services.show');
Route::get('/armada', [HomeController::class, 'fleet'])->name('fleet.index');
Route::get('/armada/{fleet}', [HomeController::class, 'fleetDetail'])->name('fleet.show');
Route::get('/paket-wisata', [HomeController::class, 'tours'])->name('tours.index');
Route::get('/paket-wisata/{tour}', [HomeController::class, 'tourDetail'])->name('tours.show');
Route::get('/travel-antar-kota', [HomeController::class, 'travel'])->name('travel');
Route::get('/wedding-car', [HomeController::class, 'wedding'])->name('wedding');
Route::get('/galeri', [HomeController::class, 'gallery'])->name('gallery');
Route::get('/testimoni', [HomeController::class, 'testimonials'])->name('testimonials');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
Route::get('/blog', [HomeController::class, 'blogIndex'])->name('blog.index');
Route::get('/blog/{blog:slug}', [HomeController::class, 'blogShow'])->name('blog.show');
Route::get('/kontak', [HomeController::class, 'contact'])->name('contact');
Route::post('/kontak', [HomeController::class, 'contactSend'])->name('contact.send');

// Booking
Route::get('/booking', [BookingController::class, 'create'])->name('booking');
Route::post('/booking/check-price', [BookingController::class, 'checkPrice'])->name('booking.check');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::get('/booking/success/{booking}', [BookingController::class, 'success'])->name('booking.success');

// Tracking
Route::get('/tracking', [TrackingController::class, 'index'])->name('tracking');
Route::post('/tracking', [TrackingController::class, 'search'])->name('tracking.search');

// SEO
Route::get('/sitemap.xml', [HomeController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [HomeController::class, 'robots'])->name('robots');

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Customer Portal
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/', [CustomerController::class, 'dashboard'])->name('dashboard');
    Route::get('/bookings', [CustomerController::class, 'bookings'])->name('bookings');
    Route::get('/bookings/{booking}', [CustomerController::class, 'bookingDetail'])->name('bookings.show');
    Route::post('/bookings/{booking}/cancel', [CustomerController::class, 'cancel'])->name('bookings.cancel');
    Route::get('/payments', [CustomerController::class, 'payments'])->name('payments');
    Route::get('/payments/{payment}', [CustomerController::class, 'paymentDetail'])->name('payments.show');
    Route::post('/payments', [CustomerController::class, 'storePayment'])->name('payments.store');
    Route::get('/profile', [CustomerController::class, 'profile'])->name('profile');
    Route::post('/profile', [CustomerController::class, 'updateProfile'])->name('profile.update');
    Route::get('/bookings/{booking}/invoice', [CustomerController::class, 'invoice'])->name('bookings.invoice');
    Route::get('/bookings/{booking}/kuitansi', [CustomerController::class, 'kuitansi'])->name('bookings.kuitansi');
});

/*
|--------------------------------------------------------------------------
| Admin Internal
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'staff'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/chart-data', [DashboardController::class, 'chartData'])->name('chart-data');

    // Fleets
    Route::resource('fleets', FleetController::class);
    Route::get('fleet-categories', [FleetController::class, 'categories'])->name('fleet-categories');

    // Drivers
    Route::resource('drivers', DriverController::class);

    // Bookings
    Route::resource('bookings', BookingAdminController::class);
    Route::post('bookings/{booking}/status', [BookingAdminController::class, 'updateStatus'])->name('bookings.status');

    // Payments
    Route::resource('payments', PaymentController::class);
    Route::post('payments/{payment}/verify', [PaymentController::class, 'verify'])->name('payments.verify');
    Route::post('payments/{payment}/reject', [PaymentController::class, 'reject'])->name('payments.reject');

    // Maintenance
    Route::resource('maintenances', MaintenanceController::class);

    // Tours
    Route::resource('tours', TourPackageController::class);
    Route::post('tours/{tour}/schedules', [TourPackageController::class, 'storeSchedule'])->name('tours.schedules');

    // Travel
    Route::resource('travel', TravelController::class);

    // Wedding
    Route::resource('weddings', WeddingController::class);

    // Promos
    Route::resource('promos', PromoController::class);

    // CMS
    Route::get('cms', [CmsController::class, 'index'])->name('cms.index');
    Route::get('cms/banners', [CmsController::class, 'banners'])->name('cms.banners');
    Route::get('cms/banners/create', [CmsController::class, 'bannerCreate'])->name('cms.banners.create');
    Route::post('cms/banners', [CmsController::class, 'bannerStore'])->name('cms.banners.store');
    Route::get('cms/banners/{banner}/edit', [CmsController::class, 'bannerEdit'])->name('cms.banners.edit');
    Route::put('cms/banners/{banner}', [CmsController::class, 'bannerUpdate'])->name('cms.banners.update');
    Route::delete('cms/banners/{banner}', [CmsController::class, 'bannerDestroy'])->name('cms.banners.destroy');

    Route::get('cms/services', [CmsController::class, 'services'])->name('cms.services');
    Route::get('cms/services/create', [CmsController::class, 'serviceCreate'])->name('cms.services.create');
    Route::post('cms/services', [CmsController::class, 'serviceStore'])->name('cms.services.store');
    Route::get('cms/services/{service}/edit', [CmsController::class, 'serviceEdit'])->name('cms.services.edit');
    Route::put('cms/services/{service}', [CmsController::class, 'serviceUpdate'])->name('cms.services.update');
    Route::delete('cms/services/{service}', [CmsController::class, 'serviceDestroy'])->name('cms.services.destroy');

    Route::get('cms/blogs', [CmsController::class, 'blogs'])->name('cms.blogs');
    Route::get('cms/blogs/create', [CmsController::class, 'blogCreate'])->name('cms.blogs.create');
    Route::post('cms/blogs', [CmsController::class, 'blogStore'])->name('cms.blogs.store');
    Route::get('cms/blogs/{blog}/edit', [CmsController::class, 'blogEdit'])->name('cms.blogs.edit');
    Route::put('cms/blogs/{blog}', [CmsController::class, 'blogUpdate'])->name('cms.blogs.update');
    Route::delete('cms/blogs/{blog}', [CmsController::class, 'blogDestroy'])->name('cms.blogs.destroy');

    Route::get('cms/faqs', [CmsController::class, 'faqs'])->name('cms.faqs');
    Route::get('cms/faqs/create', [CmsController::class, 'faqCreate'])->name('cms.faqs.create');
    Route::post('cms/faqs', [CmsController::class, 'faqStore'])->name('cms.faqs.store');
    Route::get('cms/faqs/{faq}/edit', [CmsController::class, 'faqEdit'])->name('cms.faqs.edit');
    Route::put('cms/faqs/{faq}', [CmsController::class, 'faqUpdate'])->name('cms.faqs.update');
    Route::delete('cms/faqs/{faq}', [CmsController::class, 'faqDestroy'])->name('cms.faqs.destroy');

    Route::get('cms/testimonials', [CmsController::class, 'testimonials'])->name('cms.testimonials');
    Route::get('cms/testimonials/create', [CmsController::class, 'testimonialCreate'])->name('cms.testimonials.create');
    Route::post('cms/testimonials', [CmsController::class, 'testimonialStore'])->name('cms.testimonials.store');
    Route::get('cms/testimonials/{testimonial}/edit', [CmsController::class, 'testimonialEdit'])->name('cms.testimonials.edit');
    Route::put('cms/testimonials/{testimonial}', [CmsController::class, 'testimonialUpdate'])->name('cms.testimonials.update');
    Route::delete('cms/testimonials/{testimonial}', [CmsController::class, 'testimonialDestroy'])->name('cms.testimonials.destroy');

    Route::get('cms/galleries', [CmsController::class, 'galleries'])->name('cms.galleries');
    Route::get('cms/galleries/create', [CmsController::class, 'galleryCreate'])->name('cms.galleries.create');
    Route::post('cms/galleries', [CmsController::class, 'galleryStore'])->name('cms.galleries.store');
    Route::get('cms/galleries/{gallery}/edit', [CmsController::class, 'galleryEdit'])->name('cms.galleries.edit');
    Route::put('cms/galleries/{gallery}', [CmsController::class, 'galleryUpdate'])->name('cms.galleries.update');
    Route::delete('cms/galleries/{gallery}', [CmsController::class, 'galleryDestroy'])->name('cms.galleries.destroy');

    // Customers
    Route::resource('customers', CustomerAdminController::class)->only(['index', 'show', 'destroy']);

    // Reports
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/booking', [ReportController::class, 'booking'])->name('reports.booking');
    Route::get('reports/revenue', [ReportController::class, 'revenue'])->name('reports.revenue');
    Route::get('reports/expense', [ReportController::class, 'expense'])->name('reports.expense');
    Route::get('reports/profit-loss', [ReportController::class, 'profitLoss'])->name('reports.profit-loss');
    Route::get('reports/fleet', [ReportController::class, 'fleet'])->name('reports.fleet');
    Route::get('reports/driver', [ReportController::class, 'driver'])->name('reports.driver');
    Route::get('reports/customer', [ReportController::class, 'customer'])->name('reports.customer');
    Route::get('reports/fleet-profit', [ReportController::class, 'fleetProfit'])->name('reports.fleet-profit');
    Route::get('reports/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.export-pdf');
    Route::get('reports/export-excel', [ReportController::class, 'exportExcel'])->name('reports.export-excel');

    // Activity logs
    Route::get('activity-logs', [AdminLogController::class, 'index'])->name('logs.index');

    // Notifications
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::post('notifications/read', [NotificationController::class, 'readAll'])->name('notifications.read');
    Route::post('notifications/{notification}/read', [NotificationController::class, 'read'])->name('notifications.read-one');

    // Settings & users (super admin)
    Route::resource('users', UserController::class)->middleware('can:users.manage');
    Route::get('settings', [SettingController::class, 'index'])->middleware('can:settings.manage')->name('settings');
    Route::post('settings', [SettingController::class, 'update'])->middleware('can:settings.manage')->name('settings.update');

    // Payments PDF
    Route::get('payments/{payment}/invoice', [PaymentController::class, 'invoice'])->name('payments.invoice');
    Route::get('payments/{payment}/kuitansi', [PaymentController::class, 'kuitansi'])->name('payments.kuitansi');
});
