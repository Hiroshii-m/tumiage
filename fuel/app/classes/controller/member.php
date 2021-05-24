<?php

class Controller_Member extends Controller
{
    public function before()
    {
        // ログイン認証
        if(!Auth::check()){
            Response::redirect('auth/login');
        }
    }
}