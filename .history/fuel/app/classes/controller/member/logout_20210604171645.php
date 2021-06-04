<?php

class Controller_Member_Logout extends Controller_Member{
    public function action_index()
    {
        // ログアウトの処理
        $auth = Auth::instance();
        $auth->logout();
        Auth::dont_remember_me();
        // ログインページへ遷移
        Response::redirect('login');
    }
}