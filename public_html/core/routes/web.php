<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CampaignController; // Global Shared Controller
use App\Http\Controllers\WorkspaceController; // Unified Workspace Controller
use App\Http\Controllers\User\CampaignController as UserCampaignController; // Brand Dashboard
use App\Http\Controllers\Influencer\CampaignController as InfluencerCampaignController; // Influencer Dashboard
use App\Http\Controllers\Influencer\InfluencerController as InfluencerDashboardController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes - Final Sidebar, Listing, Policy & Cookie Fix
|--------------------------------------------------------------------------
*/

// --- UTILITY ---
Route::get('/clear', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    return "Cache cleared successfully!";
});

// GLOBAL PLACEHOLDERS
Route::get('placeholder-image/{size}', [CampaignController::class, 'placeholderImage'])->name('placeholder.image');
Route::get('influencer/placeholder-image/{size}', [CampaignController::class, 'placeholderImage'])->name('influencer.placeholder.image');

// GLOBAL MESSAGING UTILITIES
Route::get('influencer/messages/download/{file}', [CampaignController::class, 'downloadAttachment'])->name('influencer.conversation.download');
Route::get('influencer/get-new-messages/{id}', [CampaignController::class, 'getNewMessages'])->name('influencer.conversation.getNewMessages');

// --- PUBLIC & GATED LISTING ROUTES ---
Route::controller(CampaignController::class)->group(function () {
    Route::get('campaigns', 'all')->name('campaign.all');
    Route::get('campaign/details/{slug}', 'detail')->name('user.campaign.detail');
});

Route::controller('InfluencerController')->group(function () {
    Route::get('influencers', 'all')->name('influencer.all');
    Route::get('influencer/profile/{username}', 'profile')->name('influencer.profile');
    Route::post('add-services/save', 'serviceSave')->name('services.save');
});

// --- SHARED CAMPAIGN WORKSPACE (BRAND & INFLUENCER) ---
Route::middleware('auth:web,influencer')->group(function () {
    Route::controller(WorkspaceController::class)->prefix('workspace')->name('workspace.')->group(function () {
            Route::get('view/{id}', 'view')->name('view');
        Route::post('send', 'sendMessage')->name('send');
        Route::post('proposal-update', 'updateProposal')->name('proposal.update');
        Route::get('download/{file}', 'download')->name('download');
        Route::get('get-new-messages/{id}', 'getNewMessages')->name('getNewMessages');
        });

        Route::controller(CampaignController::class)->group(function () {
        Route::post('campaign/upload-work', 'sendMessage')->name('campaign.file.upload');
        Route::post('campaign/update-file-status', 'updateWorkStatus')->name('campaign.file.status');
        Route::get('campaign/download-file/{file}', 'downloadAttachment')->name('campaign.file.download');
        Route::post('campaign/proposal-update', 'updateStatus')->name('campaign.proposal.update');
        });
    });

// --- AUTHENTICATED BRAND (USER) ---
Route::middleware('auth')->group(function () {
    
    // TICKET SYSTEM
    Route::controller('TicketController')->prefix('ticket')->name('ticket.')->group(function () {
        Route::get('/', 'supportTicket')->name('index');
        Route::get('new', 'openSupportTicket')->name('open');
        Route::post('create', 'storeSupportTicket')->name('store');
        Route::get('view/{ticket}', 'viewTicket')->name('view');
        Route::post('reply/{id}', 'replyTicket')->name('reply');
        Route::post('close/{id}', 'closeTicket')->name('close');
        Route::get('download/{attachment_id}', 'ticketDownload')->name('download');
    });

    // Brand Dashboard & Profile
    Route::name('user.')->group(function () {
        Route::controller('User\UserController')->group(function () {
            Route::get('dashboard', 'home')->name('home');
            Route::get('profile-setting', 'profile')->name('profile.setting');
            Route::post('profile-setting', 'submitProfile');
            Route::get('transactions', 'transactions')->name('transactions');
            Route::get('favorites', 'favorites')->name('favorites');
        });

        // Campaign Management - POINTING TO UserCampaignController
        Route::controller(UserCampaignController::class)->prefix('campaign')->name('campaign.')->group(function () {
            Route::get('create/{step?}/{slug?}', 'create')->name('create');
            Route::get('previous/{step}/{slug}', 'previous')->name('previous');
            Route::post('basic/{slug?}', 'basic')->name('basic');
            Route::post('content/{slug}', 'content')->name('content');
            Route::get('all', 'history')->name('index');
            Route::get('pending', 'history')->name('pending');
            Route::get('approved', 'history')->name('approved');
            Route::get('rejected', 'history')->name('rejected');
            Route::get('incompleted', 'history')->name('incompleted');
            Route::post('status-update', 'updateStatus')->name('status.update');
            Route::get('view/{id}', 'view')->name('view');
            Route::post('review/store', 'storeReview')->name('review.store');
        });

        // MESSAGING SYSTEM (BRAND SIDE)
        Route::prefix('messages')->name('conversation.')->group(function () {
            Route::get('/', [CampaignController::class, 'conversationIndex'])->name('index');
            Route::get('view/{id}', [WorkspaceController::class, 'view'])->name('view');
            Route::post('send', [WorkspaceController::class, 'sendMessage'])->name('send');
            Route::get('download/{file}', [WorkspaceController::class, 'download'])->name('download');
            Route::get('get-new-messages/{id}', [WorkspaceController::class, 'getNewMessages'])->name('getNewMessages');
            Route::post('work-update', [CampaignController::class, 'updateWorkStatus'])->name('work.update');
        });

        Route::controller(CampaignController::class)->group(function () {
            Route::get('campaign/participants/{id}', 'participantList')->name('participant.list');
            Route::get('campaign/invite/{id}', 'inviteForm')->name('campaign.invite.form');
            Route::post('campaign/invite', 'invite')->name('campaign.invite');
            Route::post('campaign/complete', 'complete')->name('campaign.complete');
    });
});
});

// --- AUTHENTICATED INFLUENCER ---
Route::middleware('auth:influencer')->name('influencer.')->prefix('influencer')->group(function () {

    // Campaign Wizard for Influencers (Custom Package Replacement)
    Route::controller(UserCampaignController::class)->prefix('campaign/create')->name('campaign.create.')->group(function () {
        Route::get('/{step?}/{slug?}', 'create')->name('wizard');
        Route::get('previous/{step}/{slug}', 'previous')->name('previous');
        Route::post('basic/{slug?}', 'basic')->name('basic');
        Route::post('content/{slug}', 'content')->name('content');
        Route::post('description/{slug}', 'description')->name('description');
        Route::post('requirement/{slug}', 'requirement')->name('requirement');
        Route::post('budget/{slug}', 'budget')->name('budget');
    });

    // Campaign Management - POINTING TO InfluencerCampaignController
    Route::controller(InfluencerCampaignController::class)->group(function () {
        
        Route::get('campaign/view/{id}', 'detail')->name('campaign.view');
        Route::get('campaign/log', 'log')->name('campaign.log'); 
        Route::get('placeholder-image/{size}', 'placeholderImage')->name('placeholder.image');

        // NEW ROUTE: Show the proposal creation form
        Route::get('campaign/propose/{id}', 'showProposalForm')->name('campaign.propose');

        // FIX: Added POST listener for the specific path that was causing the 405 error
        Route::post('campaign/invite', 'inviteSubmit');

        // FORCE PATH: Bypasses the 405 error on generic 'invite' routes
        // This ensures the form in your source of truth blade hits a dedicated POST route.
        Route::post('campaign/submit-proposal-final', 'inviteSubmit')->name('campaign.proposal.final.submit');

        Route::post('campaign/invite/submit', 'inviteSubmit')->name('campaign.invite.submit');
        Route::post('campaign/proposal/submit', 'inviteSubmit')->name('campaign.proposal.submit');


        // MESSAGING SYSTEM (INFLUENCER SIDE)
        Route::prefix('messages')->name('conversation.')->group(function () {
            Route::get('/', [CampaignController::class, 'conversationIndex'])->name('index');
            Route::get('view/{id}', [WorkspaceController::class, 'view'])->name('view');
            Route::post('send', [WorkspaceController::class, 'sendMessage'])->name('send');
            Route::get('download/{file}', [WorkspaceController::class, 'download'])->name('download');
            Route::get('get-new-messages/{id}', [WorkspaceController::class, 'getNewMessages'])->name('getNewMessages');
            Route::post('work-update', [CampaignController::class, 'updateWorkStatus'])->name('work.update');
        });
        
        Route::get('add-services', [InfluencerDashboardController::class, 'addServices'])->name('services.add');
    });
});

// --- GENERAL SITE ROUTES ---
Route::controller('SiteController')->group(function () {
    Route::get('contact', 'contact')->name('contact'); 
    Route::get('blog', 'blog')->name('blog');
    Route::get('blog/{slug}', 'blogDetails')->name('blog.details');
    Route::get('policy/{slug}', 'policyPages')->name('policy.pages');
    Route::get('cookie-policy', 'cookiePolicy')->name('cookie.policy');
    Route::get('cookie-policy/accept', 'cookieAccept')->name('cookie.accept');
    Route::get('categories', 'categories')->name('categories');
    Route::get('/{slug}', 'pages')->name('pages');
    Route::get('/', 'index')->name('home');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
