<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NotificationLog;
use App\Models\Transaction;
use App\Models\UserLogin;
use Illuminate\Http\Request;

class InfluencerReportController extends Controller
{
    public function transaction(Request $request,$userId = null)
    {
        $pageTitle = 'Transaction Logs';

        $remarks = Transaction::where('influencer_id','!=',0)->where('influencer_id', '!=', 0)->distinct('remark')->orderBy('remark')->get('remark');

        $transactions = Transaction::where('influencer_id','!=',0)->where('influencer_id', '!=', 0)->searchable(['trx','influencer:username'])->filter(['trx_type','remark'])->dateFilter()->orderBy('id','desc')->with('influencer');
        if ($userId) {
            $transactions = $transactions->where('user_id',$userId);
        }
        $transactions = $transactions->paginate(getPaginate());

        return view('admin.reports.influencer.transactions', compact('pageTitle', 'transactions','remarks'));
    }

    public function loginHistory(Request $request)
    {
        $pageTitle = 'User Login History';
        $loginLogs = UserLogin::where('influencer_id', '!=', 0)->orderBy('id','desc')->searchable(['influencer:username'])->dateFilter()->with('influencer')->paginate(getPaginate());
        return view('admin.reports.influencer.logins', compact('pageTitle', 'loginLogs'));
    }

    public function loginIpHistory($ip)
    {
        $pageTitle = 'Login by - ' . $ip;
        $loginLogs = UserLogin::where('influencer_id', '!=', 0)->where('user_ip',$ip)->orderBy('id','desc')->with('influencer')->paginate(getPaginate());
        return view('admin.reports.influencer.logins', compact('pageTitle', 'loginLogs','ip'));
    }

    public function notificationHistory(Request $request){
        $pageTitle = 'Notification History';
        $logs = NotificationLog::where('influencer_id', '!=', 0)->orderBy('id','desc')->searchable(['influencer:username'])->dateFilter()->with('influencer')->paginate(getPaginate());
        return view('admin.reports.influencer.notification_history', compact('pageTitle','logs'));
    }

    public function emailDetails($id){
        $pageTitle = 'Email Details';
        $email = NotificationLog::where('influencer_id', '!=', 0)->findOrFail($id);
        return view('admin.reports.influencer.email_details', compact('pageTitle','email'));
    }
}
