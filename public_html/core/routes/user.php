<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/

Route::namespace('User\Auth')->name('user.')->middleware('guest')->group(function () {
    Route::controller('LoginController')->group(function () {
        Route::get('/login', 'showLoginForm')->name('login');
        Route::post('/login', 'login');
        Route::get('logout', 'logout')->middleware('auth')->withoutMiddleware('guest')->name('logout');
    });

    Route::controller('RegisterController')->group(function () {
        Route::get('register', 'showRegistrationForm')->name('register');
        Route::post('register', 'register');
        Route::post('check-user', 'checkUser')->name('checkUser')->withoutMiddleware('guest');
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

Route::middleware('auth')->name('user.')->group(function () {
    Route::get('user-data', 'User\UserController@userData')->name('data');
    Route::post('user-data-submit', 'User\UserController@userDataSubmit')->name('data.submit');

    // Authorization
    Route::middleware('registration.complete')->namespace('User')->controller('AuthorizationController')->group(function () {
        Route::get('authorization', 'authorizeForm')->name('authorization');
        Route::get('resend-verify/{type}', 'sendVerifyCode')->name('send.verify.code');
        Route::post('verify-email', 'emailVerification')->name('verify.email');
        Route::post('verify-mobile', 'mobileVerification')->name('verify.mobile');
    });

    Route::middleware(['check.status', 'registration.complete'])->group(function () {
        Route::namespace('User')->group(function () {

            Route::middleware('check.subscription')->group(function () {
            Route::controller('CampaignController')->prefix('campaign')->name('campaign.')->group(function () {
                Route::middleware('kyc')->group(function () {
                    Route::get('create/{step?}/{slug?}/{edit?}', 'create')->name('create');
                    Route::post('basic/{slug?}', 'basic')->name('basic');
                    Route::post('content/{slug}', 'content')->name('content');
                    Route::post('description/{slug}', 'description')->name('description');
                    Route::post('requirement/{slug}', 'requirement')->name('requirement');
                    Route::post('budget/{slug}', 'budget')->name('budget');
                    Route::get('previous/{step?}/{slug?}', 'previous')->name('previous');
                    Route::get('/invite/form/{id}', 'inviteForm')->name('invite.form');
                    Route::get('get/influencer', 'getInfluencerUsername')->name('influencer.username');
                    Route::post('send/invite/{id}', 'sendInviteRequest')->name('send.invite');
                    Route::get('/', 'index')->name('index');
                    Route::get('pending', 'pending')->name('pending');
                    Route::get('approved', 'approved')->name('approved');
                    Route::get('rejected', 'rejected')->name('rejected');
                    Route::get('incomplete', 'incomplete')->name('incompleted');
                    Route::get('view/{id}', 'view')->name('view');
                });
            });

            Route::controller('ParticipantController')->prefix('participant')->name('participant.')->group(function () {
                Route::get('list/{id}', 'list')->name('list');
                Route::post('accept/{id}', 'accept')->name('accept');
                Route::post('reject/{id}', 'reject')->name('reject');
                Route::post('completed/{id}', 'completed')->name('completed');
                Route::post('reported/{id}', 'reported')->name('reported');
                Route::get('detail/{id}', 'detail')->name('detail');
                Route::post('close-inquiry/{id}', 'closeInquiry')->name('close.inquiry');

                Route::prefix('conversation')->name('conversation.')->group(function () {
                    Route::get('inbox/{id}', 'inbox')->name('inbox');
                    Route::any('send-message/{id}', 'sendMessage')->name('send.message');
                    Route::any('view-message', 'viewMessage')->name('view.message');
                    Route::post('send-proposal/{id}', 'sendProposal')->name('send.proposal');
                    Route::post('accept-proposal/{id}', 'acceptProposal')->name('accept.proposal');
                    Route::post('reject-proposal/{id}', 'rejectProposal')->name('reject.proposal');
                    Route::post('deliverable/approve', 'approveDeliverable')->name('deliverable.approve');
                    Route::post('deliverable/reject', 'rejectDeliverable')->name('deliverable.reject');
                });

                Route::post('buy-service/{id}', 'buyService')->name('buy.service');
                Route::get('create-inquiry/{influencerId}', 'createInquiry')->name('create.inquiry');
                Route::post('hire-inquiry/{id}', 'hireFromInquiry')->name('hire.inquiry');
            });
            });

            Route::controller('UserController')->group(function () {
                Route::get('dashboard', 'home')->name('home');
                Route::get('download-attachments/{file_hash}', 'downloadAttachment')->name('download.attachment');
                Route::get('invoice/download/{trx}', 'downloadInvoice')->name('invoice.download');
                // 2FA
                Route::get('twofactor', 'show2faForm')->name('twofactor');
                Route::post('twofactor/enable', 'create2fa')->name('twofactor.enable');
                Route::post('twofactor/disable', 'disable2fa')->name('twofactor.disable');
                // KYC
                Route::get('kyc-form', 'kycForm')->name('kyc.form');
                Route::get('kyc-data', 'kycData')->name('kyc.data');
                Route::post('kyc-submit', 'kycSubmit')->name('kyc.submit');

                // Report
                Route::any('deposit/history', 'depositHistory')->name('deposit.history');
                Route::get('transactions', 'transactions')->name('transactions');
                Route::post('add-device-token', 'addDeviceToken')->name('add.device.token');

                Route::post('subscribe/{id}', 'subscribePlan')->name('subscribe.plan');
            });

            Route::controller('CampaignController')->prefix('campaign')->name('campaign.')->group(function () {
                Route::middleware('kyc')->group(function () {
                    Route::get('create/{step?}/{slug?}/{edit?}', 'create')->name('create');
                    Route::post('basic/{slug?}', 'basic')->name('basic');
                    Route::post('content/{slug}', 'content')->name('content');
                    Route::post('description/{slug}', 'description')->name('description');
                    Route::post('requirement/{slug}', 'requirement')->name('requirement');
                    Route::post('budget/{slug}', 'budget')->name('budget');
                    Route::get('previous/{step?}/{slug?}', 'previous')->name('previous');
                    Route::get('/invite/form/{id}', 'inviteForm')->name('invite.form');
                    Route::get('get/influencer', 'getInfluencerUsername')->name('influencer.username');
                    Route::post('send/invite/{id}', 'sendInviteRequest')->name('send.invite');
                    Route::get('/', 'index')->name('index');
                    Route::get('pending', 'pending')->name('pending');
                    Route::get('approved', 'approved')->name('approved');
                    Route::get('rejected', 'rejected')->name('rejected');
                    Route::get('incomplete', 'incomplete')->name('incompleted');
                    Route::get('view/{id}', 'view')->name('view');
                });
            });

            Route::controller('ReviewController')->prefix('review')->name('review.')->group(function () {
                Route::middleware('kyc')->group(function () {
                    Route::get('index', 'index')->name('index');
                    Route::get('form/{participantId}/{id?}', 'reviewForm')->name('form');
                    Route::post('add/{participantId}/{id?}', 'add')->name('add');
                    Route::post('remove/{id}', 'remove')->name('remove');
            });
            });

            Route::controller('FavoriteController')->prefix('favorite')->name('favorite.')->group(function () {
                Route::get('list', 'favoriteList')->name('list');
                Route::middleware('kyc')->group(function () {
                    Route::post('add', 'addFavorite')->name('add');
                    Route::post('delete', 'delete')->name('delete');
                    Route::post('remove/{id}', 'remove')->name('remove');
            });
        });

            // Profile setting
            Route::controller('ProfileController')->group(function () {
                Route::get('profile-setting', 'profile')->name('profile.setting');
                Route::post('profile-setting', 'submitProfile');
                Route::get('change-password', 'changePassword')->name('change.password');
                Route::post('change-password', 'submitPassword');
            });
        });

        // Payment
        Route::prefix('deposit')->name('deposit.')->controller('Gateway\PaymentController')->group(function () {
            Route::any('/', 'deposit')->name('index');
            Route::post('insert', 'depositInsert')->name('insert');
            Route::get('confirm', 'depositConfirm')->name('confirm');
            Route::get('manual', 'manualDepositConfirm')->name('manual.confirm');
            Route::post('manual', 'manualDepositUpdate')->name('manual.update');
        });
    });
});