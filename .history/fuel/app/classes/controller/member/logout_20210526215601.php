<?php

class Controller_Member_Logout extends Controller_Member{
    public function action_index()
    {
        // ログアウトの処理
        $auth = Auth::instance();
        $auth->logout();
        // ログインページへ遷移
        Response::redirect('login');
    }
}