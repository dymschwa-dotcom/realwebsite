<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $pageTitle = "Manage Plans";
        $plans = Plan::all();
        return view("admin.plan.index", compact("pageTitle", "plans"));
    }

    public function update(Request $request)
    {
        $request->validate([
            "plans" => "required|array",
            "plans.*.id" => "required|integer",
            "plans.*.price" => "required|numeric|min:0",
            "plans.*.campaign_limit" => "required|integer",
        ]);

        foreach ($request->plans as $planData) {
            $plan = Plan::findOrFail($planData["id"]);
            $plan->update([
                "price" => $planData["price"],
                "campaign_limit" => $planData["campaign_limit"],
            ]);
        }

        $notify[] = ["success", "Plans updated successfully"];
        return back()->withNotify($notify);
    }
}