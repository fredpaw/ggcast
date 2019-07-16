<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionsController extends Controller
{

  protected $monthlyPlanId = 'plan_FRI3GAEC67BlZe';
  protected $yearlyPlanId = 'plan_FRItPnWnBuCtjY';

  public function showSubscriptionForm()
  {
  	return view('subscribe');
  }

  public function subscribe(Request $request) {
  	if(request('plan') == 'monthly') {
  		$planId = $this->monthlyPlanId;
  	}

  	if(request('plan') == "yearly") {
			$planId = $this->yearlyPlanId;
  	}
  	return auth()->user()->newSubscription(request('plan'), $planId)->create(request('stripeToken'));
  }

  public function change() {

    $monthly = $this->monthlyPlanId;
    $yearly = $this->yearlyPlanId;
    

    $this->validate(request(), [
      'plan' => 'required'
    ]);

    $user = auth()->user();

    $userPlan = $user->subscriptions->first()->name;

    if(request('plan') === $userPlan) {
      return redirect()->back();
    }

    if(request('plan') == 'yearly') {
      $user->subscription('monthly')->swap($yearly, request('plan'));
    }

    if(request('plan') == 'monthly') {
      $user->subscription('yearly')->swap($monthly, request('plan'));
    }

    return redirect()->back();
  }
}
