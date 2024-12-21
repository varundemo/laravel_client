<?php

namespace App\Http\Controllers;

use App\Models\ContractorProfile;
use App\Models\Payment;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Stripe\StripeClient;
use Illuminate\Support\Facades\Validator;
use Stripe\Exception\CardException;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;


class PaymentController extends Controller
{
    private $stripe;
    public function __construct()
    {
        $this->stripe = new StripeClient("sk_test_51NBVkiCxg0aufXui2dyM8tjD2XcXGtTGK6FWMbTwYDRS8Km55DJJr3eWtU3Sf7CJ4iQDy3Ezto6yMfkeKTaxBbgx00o9j6ivt6");
    }

    public function paymentview(){
        // dd("this");
        $title = "Payment Form";
        return view('backend.payment-form', compact('title'));
    }

    public function walletview(){
        $title = "Payment Wallet";
        $contractor_id = getcontractorid(Auth::id());

        $balance = Wallet::where('contractor_id', $contractor_id)->pluck('balance')->first();

        return view('backend.payment-wallet', compact('title','balance'));
    }

    public function payment(Request $request)
    {

        $request->validate([
            'fullName' => 'required',
            'amount' => 'required',
            'stripeToken' => 'required'
        ]);

        if (!request()->has('terms')) {
            return back()->with('error', 'Please check the checkbox first.');
        }

        $token = $request->input('stripeToken');
        $charge = $this->createCharge($token, $request->amount);

        if(isset($charge['error']) && !empty($charge['error']) ){
            return back()->with('success', $charge['error']);
        }

        $contractor_id = getcontractorid(Auth::id());

        $payment = (new Payment())->savepaymentdetails($charge, $contractor_id);

        $old_val = Wallet::where('contractor_id',$contractor_id)->pluck('balance')->first();
        $old_amount = (!empty($old_val)) ? $old_val : 0;           
        $new_amount = $old_amount + $payment->amount;

        if($charge->status == "succeeded"){
            $wallet = Wallet::where('contractor_id',$contractor_id)->first();
            if(empty($wallet)){
                $wallet = new Wallet();
            }
            $wallet->contractor_id = $contractor_id;
            $wallet->balance = $new_amount;
            $wallet->save();

            return redirect()->route('payment-wallet')->with('success', 'Your Payment is Successful.');

        }
        else{
            return back()->with('success', "Your Paymnet is Failed.");
        }

    }

    private function createToken($cardData)
    {
        $token = null;
        try {
            $token = $this->stripe->tokens->create([
                'card' => [
                    'number' => $cardData['cardNumber'],
                    'exp_month' => $cardData['month'],
                    'exp_year' => $cardData['year'],
                    'cvc' => $cardData['cvv']
                ]
            ]);
        } catch (CardException $e) {
            $token['error'] = $e->getError()->message;
        } catch (Exception $e) {
            $token['error'] = $e->getMessage();
        }
        return $token;
    }

    private function createCharge($tokenId, $amount)
    {
        $charge = null;
        try {
            $charge = $this->stripe->charges->create([
                'amount' => $amount*100,
                'currency' => 'usd',
                'source' => $tokenId,
                'description' => 'My first payment'
            ]);
        } catch (Exception $e) {
            $charge['error'] = $e->getMessage();
        }
        return $charge;
    }

    public function invoice(){
        // dd("this is invoice");
        $title = 'Invoice';

        if (Gate::allows('only-admin')) {
            $contractor_id = getcontractorid(Auth::id());
            $payment_details = Payment::where('contractor_id',$contractor_id)->get();
        }
        else if(Gate::allows('super-admin')){
            $payment_details = Payment::with('contractor')->latest()->get();
        }
        // dd($payment_details);

        return view('backend.invoice', compact('title','payment_details'));
    }
}
