<?php

use Illuminate\Support\Facades\Route;

Route::namespace('Influencer\Auth')->name('influencer.')->middleware('guest')->group(function () {
    Route::controller('LoginController')->group(function () {
        Route::get('/login', 'showLoginForm')->name('login');
        Route::post('/login', 'login');
        Route::get('logout', 'logout')->middleware('influencer')->withoutMiddleware('influencer.guest')->name('logout');
    });

    Route::controller('RegisterController')->group(function () {
        Route::get('register', 'showRegistrationForm')->name('register');
        Route::post('register', 'register');
        Route::post('check-user', 'checkUser')->name('checkUser')->withoutMiddleware('influencer.guest');
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

Route::middleware('influencer')->name('influencer.')->group(function () {

    Route::get('influencer-data', 'Influencer\InfluencerController@influencerData')->name('data');
    Route::post('influencer-data-submit', 'Influencer\InfluencerController@influencerDataSubmit')->name('data.submit');

    Route::get('packages', 'Influencer\InfluencerController@packages')->name('packages');
    Route::post('packages-submit', 'Influencer\InfluencerController@packagesSubmit')->name('packages.submit');

    //authorization
    Route::middleware('influencer.registration.complete')->namespace('Influencer')->controller('AuthorizationController')->group(function () {
        Route::get('authorization', 'authorizeForm')->name('authorization');
        Route::get('resend-verify/{type}', 'sendVerifyCode')->name('send.verify.code');
        Route::post('verify-email', 'emailVerification')->name('verify.email');
        Route::post('verify-mobile', 'mobileVerification')->name('verify.mobile');
        Route::post('verify-g2fa', 'g2faVerification')->name('2fa.verify');
    });

    Route::middleware(['influencer.check', 'influencer.registration.complete'])->group(function () {

        Route::namespace('Influencer')->group(function () {

            Route::controller('InfluencerController')->group(function () {
                Route::get('dashboard', 'home')->name('home');
                Route::get('download-attachments/{file_hash}', 'downloadAttachment')->name('download.attachment');

                //2FA
                Route::get('twofactor', 'show2faForm')->name('twofactor');
                Route::post('twofactor/enable', 'create2fa')->name('twofactor.enable');
                Route::post('twofactor/disable', 'disable2fa')->name('twofactor.disable');

                //KYC
                Route::get('kyc-form', 'kycForm')->name('kyc.form');
                Route::get('kyc-data', 'kycData')->name('kyc.data');
                Route::post('kyc-submit', 'kycSubmit')->name('kyc.submit');

                //Report
                Route::any('deposit/history', 'depositHistory')->name('deposit.history');
                Route::get('transactions', 'transactions')->name('transactions');
                Route::get('reviews', 'reviews')->name('reviews.list');

                Route::post('add-device-token', 'addDeviceToken')->name('add.device.token');
            });

            //Profile setting
            Route::controller('ProfileController')->group(function () {
                Route::get('profile-setting', 'profile')->name('profile.setting');
                Route::post('profile-setting', 'submitProfile');

                Route::post('submit-skill', 'submitSkill')->name('skill');

                Route::post('add-language/{id?}', 'addLanguage')->name('language.add');
                Route::post('remove-language/{language}', 'removeLanguage')->name('language.remove');

                Route::get('change-password', 'changePassword')->name('change.password');
                Route::post('change-password', 'submitPassword');

                Route::post('upload/image', 'uploadGalleryImage')->name('upload.gallery.image');
                Route::post('image/remove/{id}', 'remove')->name('gallery.image.remove');

                Route::get('social-connect/{provider}', 'socialConnect')->name('social.connect');
                Route::get('connect/callback/{provider}', 'callback')->name('social.connect.callback');


            });

            //Campaign
            Route::middleware('influencer_kyc')->controller('CampaignController')->name('campaign.')->prefix('campaign')->group(function () {
                Route::post('participate/{id}', 'participate')->name('participate');
                Route::get('invite', 'invite')->name('invite');
                Route::get('log', 'log')->name('log');
                Route::get('detail/{id}', 'detail')->name('detail');
                Route::get('view/{id}', 'view')->name('view');
                Route::post('deliver/{id}', 'deliver')->name('deliver');
                Route::post('cancel/{id}', 'cancel')->name('cancel');
                Route::prefix('conversation')->name('conversation.')->group(function () {
                    Route::get('inbox/{id}', 'inbox')->name('inbox');
                    Route::any('send-message/{id}', 'sendMessage')->name('send.message');
                    Route::any('view-message', 'viewMessage')->name('view.message');
                    Route::post('send-proposal/{id}', 'sendProposal')->name('send.proposal');
                    Route::post('accept-proposal/{id}', 'acceptProposal')->name('accept.proposal');
                });
                
            });

            // Withdraw
            Route::controller('WithdrawController')->prefix('withdraw')->name('withdraw')->group(function () {
                Route::middleware('influencer_kyc')->group(function () {
                    Route::get('/', 'withdrawMoney');
                    Route::post('/', 'withdrawStore')->name('.money');
                    Route::get('preview', 'withdrawPreview')->name('.preview');
                    Route::post('preview', 'withdrawSubmit')->name('.submit');
                });
                Route::get('history', 'withdrawLog')->name('.history');
            });
        });

        Route::namespace('Influencer')->controller('TicketController')->prefix('ticket')->name('ticket.')->group(function () {
            Route::get('/', 'supportTicket')->name('index');
            Route::get('new', 'openSupportTicket')->name('open');
            Route::post('create', 'storeSupportTicket')->name('store');
            Route::get('view/{ticket}', 'viewTicket')->name('view');
            Route::post('reply/{id}', 'replyTicket')->name('reply');
            Route::post('close/{id}', 'closeTicket')->name('close');
            Route::get('download/{attachment_id}', 'ticketDownload')->name('download');
        });
    });
});

