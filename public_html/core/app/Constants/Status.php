<?php

namespace App\Constants;

class Status {

    const ENABLE  = 1;
    const DISABLE = 0;

    const YES = 1;
    const NO  = 0;

    const VERIFIED   = 1;
    const UNVERIFIED = 0;

    const PAYMENT_INITIATE = 0;
    const PAYMENT_SUCCESS  = 1;
    const PAYMENT_PENDING  = 2;
    const PAYMENT_REJECT   = 3;

    const TICKET_OPEN   = 0;
    const TICKET_ANSWER = 1;
    const TICKET_REPLY  = 2;
    const TICKET_CLOSE  = 3;

    const PRIORITY_LOW    = 1;
    const PRIORITY_MEDIUM = 2;
    const PRIORITY_HIGH   = 3;

    const USER_ACTIVE = 1;
    const USER_BAN    = 0;

    const KYC_UNVERIFIED = 0;
    const KYC_PENDING    = 2;
    const KYC_VERIFIED   = 1;

    const GOOGLE_PAY = 5001;

    const CUR_BOTH = 1;
    const CUR_TEXT = 2;
    const CUR_SYM  = 3;

    // Campaign General Status
    const CAMPAIGN_INCOMPLETE = 0;
    const CAMPAIGN_APPROVED   = 1;
    const CAMPAIGN_PENDING    = 2;
    const CAMPAIGN_REJECTED   = 3;

    // Campaign Job / Participation Flow
    const PARTICIPATE_REQUEST_PENDING  = 0;
    const PARTICIPATE_REQUEST_ACCEPTED = 1;
    const CAMPAIGN_JOB_DELIVERED       = 2;
    const CAMPAIGN_JOB_COMPLETED       = 3;
    const CAMPAIGN_JOB_REPORTED        = 4;
    const PARTICIPATE_REQUEST_REJECTED = 5;
    const CAMPAIGN_JOB_REFUNDED        = 6;
    const CAMPAIGN_JOB_CANCELED        = 7;

    // Campaign Creation Steps
    const CAMPAIGN_BASIC      = 0;
    const CAMPAIGN_CONTENT    = 1;
    const CAMPAIGN_ABOUT      = 2;
    const CAMPAIGN_INFLUENCER = 3;
    const CAMPAIGN_BUDGET     = 4;

    const INFLUENCER_ACTIVE = 1;
    const INFLUENCER_BAN    = 0;

    // --- DASHBOARD HELPER CONSTANTS ---
    // These map the generic names used in the controller to your specific logic
    const CAMPAIGN_COMPLETED = 3; // Linked to CAMPAIGN_JOB_COMPLETED
    const CAMPAIGN_ONGOING   = 1; // Linked to PARTICIPATE_REQUEST_ACCEPTED
    
}