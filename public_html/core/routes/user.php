<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\FavoriteController;
use App\Http\Controllers\User\CampaignController;
use App\Http\Controllers\User\Auth\LoginController;
use App\Http\Controllers\User\Auth\RegisterController;
use App\Http\Controllers\User\Auth\ResetPasswordController;
use App\Http\Controllers\User\Auth\ForgotPasswordController;
use App\Models\Platform;        
use Illuminate\Support\Str;     

Route::name('user.')->group(function () {
    
    // Guest Routes
    Route::middleware('guest')->group(function () {
        Route::controller(LoginController::class)->group(function () {
            Route::get('login', 'showLoginForm')->name('login');
            Route::post('login', 'login');
        });

        Route::controller(RegisterController::class)->group(function () {
            Route::get('register', 'showRegistrationForm')->name('register');
            Route::post('register', 'register');
            Route::post('check-user', 'checkUser')->name('checkUser');
        });

        Route::controller(ForgotPasswordController::class)->prefix('password')->name('password.')->group(function () {
            Route::get('reset', 'showLinkRequestForm')->name('request');
            Route::post('email', 'sendResetCodeEmail')->name('email');
            Route::get('code-verify', 'codeVerify')->name('code.verify');
            Route::post('verify-code', 'verifyCode')->name('verify.code');
        });

        Route::controller(ResetPasswordController::class)->group(function () {
            Route::post('password/reset', 'reset')->name('password.update');
            Route::get('password/reset/{token}', 'showResetForm')->name('password.reset');
        });
    });

    // Authenticated Routes
    Route::middleware('auth')->group(function () {
        
        Route::get('logout', [LoginController::class, 'logout'])->name('logout');

        // Onboarding & Subscription
        Route::get('user-data', [UserController::class, 'userData'])->name('data');
        Route::post('user-data-submit', [UserController::class, 'userDataSubmit'])->name('data.submit');
        Route::post('subscribe/now', [UserController::class, 'buySubscription'])->name('subscribe.now');

        Route::get('subscribe-to-activate', function() {
            $pageTitle = 'Activate Account';
            return view(activeTemplate() . 'user.subscribe_activate', compact('pageTitle'));
        })->name('subscribe.activate');

        Route::middleware(['check.status', 'registration.complete'])->group(function () {
            
            // Profile & Security
            Route::controller(ProfileController::class)->group(function(){
                Route::get('profile-setting', 'profile')->name('profile.setting');
                Route::post('profile-setting', 'submitProfile');
                Route::get('change-password', 'changePassword')->name('change.password');
                Route::post('change-password', 'submitPassword');
                Route::get('twofactor', 'show2faForm')->name('twofactor');
                Route::post('twofactor/enable', 'create2fa')->name('twofactor.enable');
                Route::post('twofactor/disable', 'disable2fa')->name('twofactor.disable');
            });

            // PAYWALL - THE PROTECTED AREA
            Route::middleware(['subscribed'])->group(function () {
                Route::get('dashboard', [UserController::class, 'home'])->name('home');
                Route::get('influencers', [UserController::class, 'influencers'])->name('influencer.index');
                Route::get('hiring-history', [UserController::class, 'hiringHistory'])->name('hiring.history');

                // Campaign Controller Groups
                Route::controller(CampaignController::class)->group(function () {
                    
                    // Reviews
                    Route::prefix('review')->name('review.')->group(function () {
                        Route::get('s', 'reviews')->name('index'); 
                        Route::get('edit/{participant_id}/{id}', 'editReview')->name('form');
                        Route::post('remove/{id}', 'removeReview')->name('remove');
                        Route::post('store', 'storeReview')->name('store');
                    });

                    // Participant Detail
                    Route::get('participant/details/{id}', 'participantDetail')->name('participant.detail');

                    // FIX: Proposal Update Route (Placed inside CampaignController group)
                    Route::post('campaign/proposal/update', 'updateProposalStatus')->name('campaign.proposal.update');

                    // Campaign Management
                    Route::prefix('campaign')->name('campaign.')->group(function () {
                        Route::get('all', 'index')->name('index');
                        Route::post('create/basic/{slug?}', 'basic')->name('basic');
                        Route::post('create/content/{slug}', 'content')->name('content');
                        Route::post('create/description/{slug}', 'description')->name('description');
                        Route::post('create/requirement/{slug}', 'requirement')->name('requirement');
                        Route::post('create/budget/{slug}', 'budget')->name('budget');
                        Route::get('create/previous/{step}/{slug?}', 'previous')->name('previous');
                        Route::get('create/{step?}/{slug?}', 'create')->name('create');
                    });

                    // Dashboard Filters
                    Route::get('pending', 'pending')->name('pending');
                    Route::get('approved', 'approved')->name('approved');
                    Route::get('rejected', 'rejected')->name('rejected');
                    Route::get('in-completed', 'inCompleted')->name('incompleted');

                    // Standard CRUD
                    Route::post('store', 'store')->name('store');
                    Route::get('edit/{id}', 'edit')->name('edit');
                    Route::post('update/{id}', 'update')->name('update');
                    Route::get('details/{id}', 'details')->name('details');
                    Route::get('finished', 'finished')->name('finished');
                });

                // Conversation Routes
                Route::controller(UserController::class)->prefix('conversation')->name('conversation.')->group(function () {
                    Route::get('start/{id}', 'startConversation')->name('start');
                    Route::get('view/{id}', 'viewConversation')->name('view');
                    // Added helper routes for Brand Chat
                    Route::post('send', 'sendMessage')->name('send');
                    Route::get('get-new/{id}', 'getNewMessages')->name('getNewMessages');
                });

                // Favorites
                Route::controller(FavoriteController::class)->prefix('favorite')->name('favorite.')->group(function () {
                    Route::get('list', 'favoriteList')->name('list');
                    Route::post('add', 'addFavorite')->name('add');
                    Route::post('delete', 'delete')->name('delete'); 
                    Route::post('remove/{id}', 'remove')->name('remove');
                });
            });

            // Financial & Support
            Route::get('transactions', [UserController::class, 'transactions'])->name('transactions');
            Route::get('attachment-download/{file_hash}', [UserController::class, 'downloadAttachment'])->name('download.attachment');

            Route::controller('Gateway\PaymentController')->prefix('deposit')->name('deposit.')->group(function(){
                Route::any('/', 'deposit')->name('index');
                Route::post('insert', 'depositInsert')->name('insert');
                Route::get('confirm', 'depositConfirm')->name('confirm');
                Route::get('manual', 'manualDepositConfirm')->name('manual.confirm');
                Route::post('manual', 'manualDepositUpdate')->name('manual.update');
            });

            Route::any('deposit/history', [UserController::class, 'depositHistory'])->name('deposit.history');

            Route::controller('TicketController')->prefix('ticket')->name('ticket.')->group(function () {
                Route::get('/', 'supportTicket')->name('index');
                Route::get('new', 'openSupportTicket')->name('open');
                Route::post('create', 'storeSupportTicket')->name('store');
                Route::get('view/{ticket}', 'viewTicket')->name('view');
                Route::post('reply/{ticket}', 'replyTicket')->name('reply');
                Route::post('close/{ticket}', 'closeTicket')->name('close');
                Route::get('download/{ticket}', 'ticketDownload')->name('download');
            });

            Route::get('notifications', [UserController::class, 'notifications'])->name('notifications');
            Route::get('notification/read/{id}', [UserController::class, 'notificationRead'])->name('notification.read');
        });
    });
});