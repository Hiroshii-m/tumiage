<?php

class Controller_Member_Mypage extends Controller_Member
{
    public function action_index()
    {
        $u_id = Arr::get(Auth::get_user_id(), 1);
        $new_day = date('Y').'-01-01';
        $last_day = date('Y').'-12-31';
        $current_month = date('Y-m');
        $month_sum = 0;
        $year_sum = 0;

        // 変数にビューを割り当てる
        $view = View::forge('template/index');
        $view->set('head', View::forge('template/head'));
        $view->set('header', View::forge('template/header'));
        $view->set('contents', View::forge('member/mypage'));
        $view->set('footer', View::forge('template/footer'));
        $view->set_global('sidebar', View::forge('template/sidebar'));

        return $view;
    }
}