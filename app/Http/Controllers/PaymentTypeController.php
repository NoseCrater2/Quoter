<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PaymentType;
use App\User;

class PaymentTypeController extends Controller
{
    public function index()
    {
        return PaymentType::all();
    }

    public function addPaymentTypeToUser(Request $request, User $user)
    {
        $data = $request->all();
        $paymentTypes = $data['paymentTypes'];

        $user->paymentTypes()->sync($paymentTypes);
    }

    public function getUserPaymentTypes(User $user)
    {
        return $user->paymentTypes;
    }
}
