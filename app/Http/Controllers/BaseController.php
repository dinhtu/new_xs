<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Routing\Controller;

class BaseController extends Controller
{
    public function setFlash($message, $mode = 'success', $urlRedirect = '')
    {
        session()->forget('Message.flash');
        session()->push('Message.flash', [
            'message' => $message,
            'mode' => $mode,
            'urlRedirect' => $urlRedirect,
        ]);
    }
}
