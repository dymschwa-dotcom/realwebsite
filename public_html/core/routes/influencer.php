<?php

use Illuminate\Support\Facades\Route;

// --- 1. Public AJAX Validation ---
Route::namespace('Influencer\Auth')->name('influencer.')->group(function () {
    Route::controller('RegisterController')->group(function () {
        Route::post('check-user', 'checkUser')->name('checkUser');
        Route::post('check-email', 'checkEmail')->name('checkEmail');
    });
});

// --- 2. Guest Only Routes ---
Route::namespace('Influencer\Auth')->name('influencer.')->middleware('guest')->group(function () {
    Route::controller('RegisterController')->group(function () {
        Route::get('register', 'showRegistrationForm')->name('register');
        Route::post('register', 'register');
    });

    Route::controller('LoginController')->group(function () {
        Route::get('/login', 'showLoginForm')->name('login');
        Route::post('/login', 'login');
    });

    Route::controller('ForgotPasswordController')->prefix('password')->name('password.')->group(function () {
        Route::get('reset', 'showLinkRequestForm')->name('request');
        Route::post('email', 'sendResetCodeEmail')->name('email');
        Route::get('code-verify', 'codeVerify')->name('code.verify');
        Route::post('verify-code', 'verifyCode')->name('verify.code');
    });

    Route::controller('ResetPasswordController')->group(function () {
        Route::post('password/reset', 'reset')->name('password.update');
        Route::get('password/reset/{token}', 'showResetForm')->name('password.reset');
    });
});

// --- 3. Authenticated Influencer Routes ---
Route::middleware('influencer')->name('influencer.')->group(function () {

    Route::get('logout', [App\Http\Controllers\Influencer\Auth\LoginController::class, 'logout'])->name('logout');

    // Onboarding Step 2
    Route::get('influencer-data', [App\Http\Controllers\Influencer\Auth\RegisterController::class, 'influencerData'])->name('data');
    Route::post('influencer-data-submit', [App\Http\Controllers\Influencer\Auth\RegisterController::class, 'influencerDataSubmit'])->name('data.submit');

    // Authorization & Verification Logic
    Route::middleware('influencer.registration.complete')->namespace('Influencer')->controller('AuthorizationController')->group(function () {
        Route::get('authorization', 'authorizeForm')->name('authorization');
        Route::get('resend-verify/{type}', 'sendVerifyCode')->name('send.verify.code');
        Route::post('verify-email', 'emailVerification')->name('verify.email');
        Route::post('verify-mobile', 'mobileVerification')->name('verify.mobile');
        Route::post('verify-g2fa', 'g2faVerification')->name('2fa.verify');
    });

    // Fully Verified & Profile Complete Routes
    Route::middleware(['influencer.check', 'influencer.registration.complete'])->group(function () {

        Route::namespace('Influencer')->group(function () {

            Route::controller('InfluencerController')->group(function () {
                
                // Package Management (Step 3 Onboarding)
                Route::get('services/add', 'addServices')->name('services.add');
                Route::post('services/save-initial', 'serviceSave')->name('services.save');
                Route::get('services/delete/{id}', 'serviceDelete')->name('services.delete');

                // Locked Routes (Gated by active services check)
                Route::middleware('check.services')->group(function () {
                    Route::get('dashboard', 'home')->name('home');
                    Route::get('download-attachments/{file_hash}', 'downloadAttachment')->name('download.attachment');

                    // --- REAL-TIME MESSAGING & WORK VERIFICATION ---
                    Route::prefix('conversation')->name('conversation.')->group(function () {
                        Route::get('/', 'conversations')->name('index');
                        Route::get('view/{id}', 'viewChat')->name('view');
                        Route::get('get-new/{id}', 'getNewMessages')->name('getNewMessages');
                        
                        // Handlers for sending messages and submitting files
                        Route::post('send', 'sendMessage')->name('send');
                        Route::post('submit-work', 'submitWork')->name('submitWork');
                    });

                    // Security & Reports
                    Route::get('twofactor', 'show2faForm')->name('twofactor');
                    Route::post('twofactor/enable', 'create2fa')->name('twofactor.enable');
                    Route::post('twofactor/disable', 'disable2fa')->name('twofactor.disable');
                    Route::get('kyc-form', 'kycForm')->name('kyc.form');
                    Route::get('kyc-data', 'kycData')->name('kyc.data');
                    Route::post('kyc-submit', 'kycSubmit')->name('kyc.submit');
                    Route::get('transactions', 'transactions')->name('transactions');
                    Route::get('reviews', 'reviews')->name('reviews.list');
                });
            });

            // Profile Settings
            Route::middleware('check.services')->controller('ProfileController')->group(function () {
                Route::get('profile-setting', 'profile')->name('profile.setting');
                Route::post('profile-setting', 'submitProfile')->name('profile.setting.submit');
                Route::get('change-password', 'changePassword')->name('change.password');
                Route::post('change-password', 'submitPassword');
            });

            // Campaign Management
            Route::middleware(['check.services', 'influencer_kyc'])->controller('CampaignController')->name('campaign.')->prefix('campaign')->group(function () {
                Route::get('invite', 'invite')->name('invite');
                Route::get('log', 'log')->name('log');
                Route::get('detail/{id}', 'detail')->name('detail');
                Route::post('deliver/{id}', 'deliver')->name('deliver');
            });

            // Withdrawals
            Route::middleware('check.services')->controller('WithdrawController')->prefix('withdraw')->name('withdraw')->group(function () {
                Route::middleware('influencer_kyc')->group(function () {
                    Route::get('/', 'withdrawMoney');
                    Route::post('/', 'withdrawStore')->name('.money');
                    Route::get('preview', 'withdrawPreview')->name('.preview');
                    Route::post('preview', 'withdrawSubmit')->name('.submit');
                });
                Route::get('history', 'withdrawLog')->name('.history');
            });
        });

        // Support Tickets
        Route::namespace('Influencer')->controller('TicketController')->prefix('ticket')->name('ticket.')->group(function () {
            Route::get('/', 'supportTicket')->name('index');
            Route::get('new', 'openSupportTicket')->name('open');
            Route::post('create', 'storeSupportTicket')->name('store');
            Route::get('view/{ticket}', 'viewTicket')->name('view');
            Route::post('reply/{id}', 'replyTicket')->name('reply');
        });
    });
});