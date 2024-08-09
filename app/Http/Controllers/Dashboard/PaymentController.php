<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

use App\Models\AdminToClubPayment;
use App\Models\AdminToVendorPayment;
use App\Models\PaymentLog;
use App\Models\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paymentLogs = PaymentLog::latest()->get();
        return view('dashboard.payment_logs.index', compact('paymentLogs'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

}
