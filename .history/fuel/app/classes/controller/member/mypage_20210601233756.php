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
            // 今月のtdataテーブルの情報を取得する
            $post_tdata = \Model\Stack::find(array(
                'select' => array('text_num', 'created_at'),
                'where' => array(
                    'user_id' => $data['user_id'],
                    array('created_at', 'between', array($current_month.'-01', $current_month.'2021-05-31')),
                    'delete_flg' => 0
                )
            ));
            // 今月の合計文字数を取得する
            $post_month = \Model\Mdata::find(array(
                'select' => array('month_num', 'created_at'),
                'where' => array(
                    'user_id' => $data['user_id'],
                    'created_at' => $current_month,
                    'delete_flg' => 0
                )
            ));
            // 今年の合計文字数を取得する
            $post_year = \Model\Ydata::find(array(
                'select' => array('year_sum', 'created_at'),
                'where' => array(
                    'user_id' => $data['user_id'],
                    'created_at' => $current_year,
                    'delete_flg' => 0
                )
            ));
        }

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