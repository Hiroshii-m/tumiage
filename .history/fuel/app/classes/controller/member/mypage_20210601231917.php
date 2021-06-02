<?php

class Controller_Member_Mypage extends Controller_Member
{
    public function action_index()
    {
        $data['user_id'] = Arr::get(Auth::get_user_id(), 1);
        $data['username'] = Auth::get_screen_name();
        $current_year = date('Y');
        $current_month = date('Y-m');

        try{
            DB::start_transaction();
            $post_tdata = \Model\Stack::find(array(
                'select' => array('id', 'user_id'),
                'where' => array(
                    'user_id' => $data['user_id']
                )
            ));
        }
        // 今月のtdataテーブルの情報を取得する
        // 今月の合計文字数を取得する
        // 今年の合計文字数を取得する

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