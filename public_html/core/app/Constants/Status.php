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

    CONST TICKET_OPEN   = 0;
    CONST TICKET_ANSWER = 1;
    CONST TICKET_REPLY  = 2;
    CONST TICKET_CLOSE  = 3;

    CONST PRIORITY_LOW    = 1;
    CONST PRIORITY_MEDIUM = 2;
    CONST PRIORITY_HIGH   = 3;

    const USER_ACTIVE = 1;
    const USER_BAN    = 0;

    const KYC_UNVERIFIED = 0;
    const KYC_PENDING    = 2;
    const KYC_VERIFIED   = 1;

    const GOOGLE_PAY = 5001;

    const CUR_BOTH = 1;
    const CUR_TEXT = 2;
    const CUR_SYM  = 3;

    const CAMPAIGN_INCOMPLETE = 0;
    const CAMPAIGN_APPROVED   = 1;
    const CAMPAIGN_PENDING    = 2;
    const CAMPAIGN_REJECTED   = 3;
    const CAMPAIGN_COMPLETED  = 4;

    const PARTICIPATE_REQUEST_PENDING  = 0;
    const PARTICIPATE_REQUEST_ACCEPTED = 1;
    const CAMPAIGN_JOB_DELIVERED       = 2;
    const CAMPAIGN_JOB_COMPLETED       = 3;
    const CAMPAIGN_JOB_REPORTED        = 4;
    const PARTICIPATE_REQUEST_REJECTED = 5;
    const CAMPAIGN_JOB_REFUNDED        = 6;
    const CAMPAIGN_JOB_CANCELED        = 7;
    const PARTICIPATE_INQUIRY          = 8;
    const PARTICIPATE_PROPOSAL         = 9;

    const CAMPAIGN_BASIC      = 0;
    const CAMPAIGN_CONTENT    = 1;
    const CAMPAIGN_ABOUT      = 2;
    const CAMPAIGN_INFLUENCER = 3;
    const CAMPAIGN_BUDGET     = 4;

    const INFLUENCER_ACTIVE = 1;
    const INFLUENCER_BAN    = 0;

}

