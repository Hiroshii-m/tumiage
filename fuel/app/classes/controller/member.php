<?php

class Controller_Member extends Controller
{
    public function before()
    {
        // ログイン認証
        if(!Auth::check()){
            // ログインしていない場合、ログインページへ遷移
            Response::redirect('login');
        }
    }
}