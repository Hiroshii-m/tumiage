<?php

class Controller_Member_Mypage extends Controller
{
    public function action_index()
    {
        if(!Auth::check()){
            Response::redirect('auth/login');
        }
        $view = View::forge('template/index');
        $view->set('head', View::forge('template/head'));
        $view->set('header', View::forge('template/header'));
        $view->set('contents', View::forge('template/contents'));
        $view->set('footer', View::forge('template/footer'));

        return $view;
    }
}