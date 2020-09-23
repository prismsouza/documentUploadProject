<?php

use Illuminate\Support\Facades\Session;

function sessionRefresh()
{
    $session_admin = Session::get('admin');
    Session::flush();
    Session::put('admin', $session_admin);
}
