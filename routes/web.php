<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\User\PermissionController;
use App\Http\Controllers\User\RoleController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Organization\OrganizationController;
use App\Http\Controllers\Organization\OrganizationMemberController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\Payment\PaymentMethodController;
use App\Http\Controllers\Payment\PaymentHistoryController;
use App\Http\Controllers\Payment\TransactionController;
use App\Http\Controllers\Payment\ChargeController;
use App\Http\Controllers\Payment\ReceiptController;
use App\Http\Controllers\Payment\PaymentReminderController;
use App\Http\Controllers\Incident\IncidentController;
use App\Http\Controllers\Incident\IncidentImageController;
use App\Http\Controllers\Contribution\ContributionController;
use App\Http\Controllers\Notification\NotificationController;
use App\Http\Controllers\Setting\SettingController;
use App\Http\Controllers\Audit\AuditLogController;
use App\Http\Controllers\Activity\UserActivityLogController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Status\StatusController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogTagController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\Admin\AdminDonationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

    // Public Routes
    // Route::get('/', [SiteController::class, 'index'])->name('home');

    // Frontend Routes

    // Static Sites
    Route::get('/about', [SiteController::class, 'about'])->name('about');
    Route::get('/blog', [SiteController::class, 'blog'])->name('blog');
    Route::get('/blog/{blog}', [SiteController::class, 'blog_detail'])->name('blog.detail');
    Route::get('/contact', [SiteController::class, 'contact'])->name('contact');

    // Donation Routes
    Route::prefix('donation')->group(function () {
        Route::get('/', [SiteController::class, 'donation'])->name('donation');
        Route::get('/success', [DonationController::class, 'success'])->name('donation.success');
        Route::post('/checkout', [DonationController::class, 'checkout'])->name('donation.checkout');
        Route::post('/process', [DonationController::class, 'createPaymentIntent'])->name('donation.process');
        Route::get('/pending', [DonationController::class, 'pending'])->name('donation.pending');
        Route::post('/complete', [DonationController::class, 'completeDonation'])->name('donation.complete');
        Route::get('/{incident}', [SiteController::class, 'donation_detail'])->name('donation.detail');
    });
    // Route::get('/donation/pending', [DonationController::class, 'pending'])->name('donation.pending');



    Route::get('/event', [SiteController::class, 'event'])->name('event');
    Route::get('/event-detail', [SiteController::class, 'event_detail'])->name('event.detail');
    Route::get('/faq', [SiteController::class, 'faq'])->name('faq');
    // Route::get('/pricing', [SiteController::class, 'pricing'])->name('pricing');
    // Route::get('/project', [SiteController::class, 'project'])->name('project');
    // Route::get('/project-detail', [SiteController::class, 'project_detail'])->name('project.detail');
    Route::get('/services', [SiteController::class, 'services'])->name('services');
    // Route::get('/service-detail', [SiteController::class, 'service_detail'])->name('service.detail');
    // Route::get('/teams', [SiteController::class, 'teams'])->name('teams');
    // Route::get('/team-detail', [SiteController::class, 'team_detail'])->name('team.detail');
    Route::get('/search', [SiteController::class, 'search'])->name('search');
    Route::get('/gallery', [GalleryController::class, 'publicIndex'])->name('gallery');

    // Authentication Routes
    Auth::routes(['verify' => true]);

    // User Dashboard
    Route::get('/home', function () {
        return redirect()->route('home');
    });

    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])
        ->name('home') ;

    // Contact Routes
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

    // Admin Routes
    Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified','user-payment'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // User Management
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::get('/roles/permissions/{roleIds}', [UserController::class, 'getRolePermissions'])->name('roles.permissions');

    // Organization Management
    Route::resource('organizations', OrganizationController::class);
    
    // change the leader from selecting the memeber.
    Route::get('organization/change',[OrganizationController::class,'change'])->name('organizations.change');
    Route::post('organization/change',[OrganizationController::class,'change_post'])->name('organizations.change');
    Route::get('organization/members',[OrganizationController::class,'getOrganizationMembers'])->name('organizations.members');

    Route::resource('organizations.members', OrganizationMemberController::class);

    // Payment Management
    Route::resource('payment-methods', PaymentMethodController::class);

    // member member ship payment
    // step 1: show form + step 2: store form
    Route::get('payments/registration', [PaymentController::class, 'registration'])->name('payments.registration_index');
    Route::post('payments/registration', [PaymentController::class, 'registration_store'])->name('payments.registration_store');

    // step 2: organization create form
    Route::get('payments/organizations', [PaymentController::class, 'organization'])->name('payments.organization_index');
    Route::post('payments/organizations', [PaymentController::class, 'organization_store'])->name('payments.organization_store');

    Route::get('payments', [PaymentController::class, 'index'])->name('payments.index');          // list
    Route::get('payments/create', [PaymentController::class, 'create'])->name('payments.create'); // form
    Route::post('payments', [PaymentController::class, 'store'])->name('payments.store');         // save
    Route::get('payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');  // detail
    Route::get('payments/{payment}/edit', [PaymentController::class, 'edit'])->name('payments.edit'); // edit form
    Route::put('payments/{payment}', [PaymentController::class, 'update'])->name('payments.update');  // update
    Route::delete('payments/{payment}', [PaymentController::class, 'destroy'])->name('payments.destroy'); // delete


    Route::resource('payment-histories', PaymentHistoryController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('charges', ChargeController::class);
    Route::resource('receipts', ReceiptController::class);
    Route::resource('payment-reminders', PaymentReminderController::class);

    // Incident Management
    Route::get('incidents/deceased', [IncidentController::class,'deceased'])->name('incidents.deceased');
    Route::get('incidents/healthcare', [IncidentController::class,'healthcare'])->name('incidents.healthcare');
    Route::post('incidents/{incident}/verify', [IncidentController::class,'verify'])->name('incidents.verify');
    Route::resource('incidents', IncidentController::class);
    Route::resource('incident-images', IncidentImageController::class);

    // Contribution Management
    Route::resource('contributions', ContributionController::class);
    Route::get('contributions/{contribution}/pay', [ContributionController::class, 'pay'])->name('contributions.pay');
    Route::post('contributions/{contribution}/process-payment', [ContributionController::class, 'processPayment'])->name('contributions.process-payment');
    Route::post('contributions/{contribution}/mark-as-paid', [ContributionController::class, 'markAsPaid'])->name('contributions.mark-as-paid');
    Route::post('contributions/{contribution}/create-stripe-payment-intent', [ContributionController::class, 'createStripePaymentIntent'])->name('contributions.create-stripe-payment-intent');

    // Notification Management
    Route::resource('notifications', NotificationController::class);
    Route::post('notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');

    // System Management
    Route::prefix('settings')->name('settings.')->group(function () {
    Route::get('/', [SettingController::class, 'index'])->name('index');
    Route::get('/create', [SettingController::class, 'create'])->name('create');
    Route::post('/', [SettingController::class, 'store'])->name('store');
    Route::get('/{setting}/edit', [SettingController::class, 'edit'])->name('edit');
    Route::put('/{setting}', [SettingController::class, 'updateSetting'])->name('update');
    Route::delete('/{setting}', [SettingController::class, 'destroy'])->name('destroy');
    Route::put('/', [SettingController::class, 'update'])->name('bulk-update');
    Route::post('/clear-cache', [SettingController::class, 'clearCache'])->name('clear-cache');});

    Route::resource('audit-logs', AuditLogController::class)->except(['create', 'store', 'edit', 'update']);
    Route::delete('audit-logs/clear', [AuditLogController::class, 'clear'])->name('audit-logs.clear');
    Route::resource('activity-logs', UserActivityLogController::class);
    Route::delete('activity-logs/clear', [UserActivityLogController::class, 'clear'])->name('activity-logs.clear');

    // Status Management
    Route::resource('statuses', StatusController::class);

    Route::resource('banners', BannerController::class);

    // Contact Management
    Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/{contact}', [ContactController::class, 'show'])->name('contacts.show');
    Route::post('/contacts/{contact}/reply', [ContactController::class, 'reply'])->name('contacts.reply');
    Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');

    // Blog Routes
    Route::resource('blogs', BlogController::class);
    Route::post('blogs/upload-image', [BlogController::class, 'uploadImage'])->name('blogs.upload-image');
    Route::get('blogs/image/{path}', [BlogController::class, 'getImage'])->name('blogs.image')->where('path', '.*');

    // Blog Categories Routes
    Route::resource('blog-categories', BlogCategoryController::class);

    // Blog Tags Routes
    Route::resource('blog-tags', BlogTagController::class);
    Route::resource('gallery', GalleryController::class);
    Route::resource('members', MemberController::class)->except(['show']);});

    // Admin routes for managing donations
    Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/donations/pending', [AdminDonationController::class, 'pending'])->name('donations.pending');
    Route::get('/donations', [AdminDonationController::class, 'index'])->name('donations.index');
    Route::get('/donations/create', [AdminDonationController::class, 'create'])->name('donations.create');
    Route::post('/donations', [AdminDonationController::class, 'store'])->name('donations.store');
    Route::get('/donations/{donation}', [AdminDonationController::class, 'show'])->name('donations.show');
    Route::get('/donations/{donation}/edit', [AdminDonationController::class, 'edit'])->name('donations.edit');
    Route::put('/donations/{donation}', [AdminDonationController::class, 'update'])->name('donations.update');
    Route::delete('/donations/{donation}', [AdminDonationController::class, 'destroy'])->name('donations.destroy');
    Route::post('/donations/{donation}/approve', [AdminDonationController::class, 'approve'])->name('donations.approve');
    Route::post('/donations/{donation}/reject', [AdminDonationController::class, 'reject'])->name('donations.reject');
});

