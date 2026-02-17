<?php

namespace App\Lib;

use App\Models\Referral;
use App\Models\Transaction;

class ReferralCommission {
    public static function influencerRegisterCommission($influencer) {
        $influencer->balance += gs('influencer_register_bonus_amount');
        $influencer->save();

        $transaction                = new Transaction();
        $transaction->influencer_id = $influencer->id;
        $transaction->amount        = gs('influencer_register_bonus_amount');
        $transaction->charge        = 0;
        $transaction->post_balance  = $influencer->balance;
        $transaction->trx_type      = '+';
        $transaction->trx           = getTrx();
        $transaction->details       = 'Registration bonus added to your balance';
        $transaction->remark        = 'register_bonus';
        $transaction->save();

        notify($influencer, 'INFLUENCER_REGISTER_COMMISSION', [
            'fullname' => $influencer->fullname,
            'amount'   => showAmount(gs('brand_register_bonus_amount'), currencyFormat: false),
        ]);
    }

    public static function brandRegisterCommission($user) {
        $user->balance += gs('brand_register_bonus_amount');
        $user->save();

        $transaction               = new Transaction();
        $transaction->user_id      = $user->id;
        $transaction->amount       = gs('brand_register_bonus_amount');
        $transaction->charge       = 0;
        $transaction->post_balance = $user->balance;
        $transaction->trx_type     = '+';
        $transaction->trx          = getTrx();
        $transaction->details      = 'Registration bonus added to your balance';
        $transaction->remark       = 'register_bonus';
        $transaction->save();

        notify($user, 'BRAND_REGISTER_COMMISSION', [
            'fullname' => $user->fullname,
            'amount'   => showAmount(gs('brand_register_bonus_amount'), currencyFormat: false),
        ]);
    }
    public static function levelCommission($user, $amount, $commissionType, $trx, $column) {
        $meUser       = $user;
        $i            = 1;
        $level        = Referral::where('commission_type', $commissionType)->count();
        $transactions = [];
        while ($i <= $level) {
            $me    = $meUser;
            $refer = $me->referrer;
            if ($refer == "") {
                break;
            }

            $commission = Referral::where('commission_type', $commissionType)->where('level', $i)->first();
            if (!$commission) {
                break;
            }

            $com = ($amount * $commission->percent) / 100;
            $refer->balance += $com;
            $refer->save();

            $transactions[] = [
                $column        => $refer->id,
                'amount'       => $com,
                'post_balance' => $refer->balance,
                'charge'       => 0,
                'trx_type'     => '+',
                'details'      => 'level ' . $i . ' Referral Commission From ' . $user->username,
                'trx'          => $trx,
                'remark'       => 'referral_commission',
                'created_at'   => now(),
            ];

            if ($commissionType == 'influencer_withdrawal_commission') {
                $comType = 'withdrawal';
            }

            notify($refer, 'REFERRAL_COMMISSION', [
                'amount'       => showAmount($com, currencyFormat: false),
                'post_balance' => showAmount($refer->balance, currencyFormat: false),
                'trx'          => $trx,
                'level'        => ordinal($i),
                'type'         => $comType,
            ]);

            $meUser = $refer;
            $i++;
        }

        if (!empty($transactions)) {
            Transaction::insert($transactions);
        }
    }
}