<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class LiveTransferController extends Controller
{
    public function index()
    {
        return view('admin.live_transfer.index');
    }
}
