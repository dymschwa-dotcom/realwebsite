<?php

namespace App\Http\Controllers\Influencer;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Lib\FormProcessor;
use App\Models\AdminNotification;
use App\Models\Transaction;
use App\Models\Withdrawal;
use App\Models\WithdrawMethod;
use Illuminate\Http\Request;

class WithdrawController extends Controller {

    public function withdrawMoney() {
        $withdrawMethod = WithdrawMethod::active()->get();
        $pageTitle      = 'Withdraw Money';
        return view('Template::influencer.withdraw.methods', compact('pageTitle', 'withdrawMethod'));
    }

    public function withdrawStore(Request $request) {
        $request->validate([
            'method_code' => 'required',
            'amount'      => 'required|numeric',
        ]);
        $method     = WithdrawMethod::where('id', $request->method_code)->active()->firstOrFail();
        $influencer = auth()->guard('influencer')->user();
        if ($request->amount < $method->min_limit) {
            $notify[] = ['error', 'Your requested amount is smaller than minimum amount'];
            return back()->withNotify($notify)->withInput($request->all());
        }
        if ($request->amount > $method->max_limit) {
            $notify[] = ['error', 'Your requested amount is larger than maximum amount'];
            return back()->withNotify($notify)->withInput($request->all());
        }

        if ($request->amount > $influencer->balance) {
            $notify[] = ['error', 'Insufficient balance for withdrawal'];
            return back()->withNotify($notify)->withInput($request->all());
        }

        $charge      = $method->fixed_charge + ($request->amount * $method->percent_charge / 100);
        $afterCharge = $request->amount - $charge;

        if ($afterCharge <= 0) {
            $notify[] = ['error', 'Withdraw amount must be sufficient for charges'];
            return back()->withNotify($notify)->withInput($request->all());
        }

        $finalAmount = $afterCharge * $method->rate;

        $withdraw                = new Withdrawal();
        $withdraw->method_id     = $method->id; // wallet method ID
        $withdraw->influencer_id = $influencer->id;
        $withdraw->amount        = $request->amount;
        $withdraw->currency      = $method->currency;
        $withdraw->rate          = $method->rate;
        $withdraw->charge        = $charge;
        $withdraw->final_amount  = $finalAmount;
        $withdraw->after_charge  = $afterCharge;
        $withdraw->trx           = getTrx();
        $withdraw->save();
        session()->put('wtrx', $withdraw->trx);
        return to_route('influencer.withdraw.preview');
    }

    public function withdrawPreview() {
        $withdraw  = Withdrawal::with('method', 'influencer')->where('trx', session()->get('wtrx'))->where('status', Status::PAYMENT_INITIATE)->orderBy('id', 'desc')->firstOrFail();
        $pageTitle = 'Withdraw Preview';
        return view('Template::influencer.withdraw.preview', compact('pageTitle', 'withdraw'));
    }

    public function withdrawSubmit(Request $request) {
        $withdraw = Withdrawal::with('method', 'influencer')->where('trx', session()->get('wtrx'))->where('status', Status::PAYMENT_INITIATE)->orderBy('id', 'desc')->firstOrFail();

        $method = $withdraw->method;
        if ($method->status == Status::DISABLE) {
            abort(404);
        }

        $formData = @$method->form->form_data ?? [];

        $formProcessor  = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);
        $request->validate($validationRule);
        $influencerData = $formProcessor->processFormData($request, $formData);

        $influencer = auth()->guard('influencer')->user();
        if ($influencer->ts) {
            $response = verifyG2fa($influencer, $request->authenticator_code);
            if (!$response) {
                $notify[] = ['error', 'Wrong verification code'];
                return back()->withNotify($notify)->withInput($request->all());
            }
        }

        if ($withdraw->amount > $influencer->balance) {
            $notify[] = ['error', 'Your request amount is larger then your current balance.'];
            return back()->withNotify($notify)->withInput($request->all());
        }

        $withdraw->status               = Status::PAYMENT_PENDING;
        $withdraw->withdraw_information = $influencerData;
        $withdraw->save();
        $influencer->balance -= $withdraw->amount;
        $influencer->save();

        $transaction                = new Transaction();
        $transaction->influencer_id = $withdraw->influencer_id;
        $transaction->amount        = $withdraw->amount;
        $transaction->post_balance  = $influencer->balance;
        $transaction->charge        = $withdraw->charge;
        $transaction->trx_type      = '-';
        $transaction->details       = 'Withdraw request via ' . $withdraw->method->name;
        $transaction->trx           = $withdraw->trx;
        $transaction->remark        = 'withdraw';
        $transaction->save();

        $adminNotification                = new AdminNotification();
        $adminNotification->influencer_id = $influencer->id;
        $adminNotification->title         = 'New withdraw request from ' . $influencer->username;
        $adminNotification->click_url     = urlPath('admin.withdraw.data.details', $withdraw->id);
        $adminNotification->save();

        notify($influencer, 'WITHDRAW_REQUEST', [
            'method_name'     => $withdraw->method->name,
            'method_currency' => $withdraw->currency,
            'method_amount'   => showAmount($withdraw->final_amount, currencyFormat: false),
            'amount'          => showAmount($withdraw->amount, currencyFormat: false),
            'charge'          => showAmount($withdraw->charge, currencyFormat: false),
            'rate'            => showAmount($withdraw->rate, currencyFormat: false),
            'trx'             => $withdraw->trx,
            'post_balance'    => showAmount($influencer->balance, currencyFormat: false),
        ]);

        $notify[] = ['success', 'Withdraw request sent successfully'];
        return to_route('influencer.withdraw.history')->withNotify($notify);
    }

    public function withdrawLog(Request $request) {
        $pageTitle = "Withdrawal Log";
        $withdraws = Withdrawal::where('influencer_id', auth()->guard('influencer')->id())->where('status', '!=', Status::PAYMENT_INITIATE)->searchable(['trx'])->with('method')->orderBy('id', 'desc')->paginate(getPaginate());
        return view('Template::influencer.withdraw.log', compact('pageTitle', 'withdraws'));
    }
}
