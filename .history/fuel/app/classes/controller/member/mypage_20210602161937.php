<?php

class Controller_Member_Mypage extends Controller_Member
{
    public function action_index()
    {
        $data['user_id'] = Arr::get(Auth::get_user_id(), 1);
        $data['username'] = Auth::get_screen_name();
        // GETパラメータを取得
        $get_month = (!empty(Input::get('current_month'))) ? Input::get('current_month') : date('-m');
        $current_year = date('Y');
        $current_month = date('-m', strtotime($current_year.$get_month.'-01'));
        $month_count = date('t', strtotime($current_year.$get_month.'-01'));
        $feb = $current_year.'-02-01';
        $year_count = 337 + date('t', strtotime($feb));

        try{
            DB::start_transaction();
            // 今月のtdataテーブルの情報を取得する
            $post_tdata = \Model\Stack::find(array(
                'select' => array('text_num', 'created_at'),
                'where' => array(
                    'user_id' => $data['user_id'],
                    array('created_at', 'between', array($current_year.$current_month.'-01', $current_year.$current_month.'-31')),
                    'delete_flg' => 0
                )
            ));
            // 今月の合計文字数を取得する
            $post_month = \Model\Mdata::find(array(
                'select' => array('month_sum', 'created_at'),
                'where' => array(
                    'user_id' => $data['user_id'],
                    'created_at' => $current_year.$current_month,
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
            DB::commit_transaction();
        }catch(Exception $e){
            DB::rollback_transaction();

            throw  $e;
        }

        // 変数にビューを割り当てる
        $view = View::forge('template/index');
        $view->set('head', View::forge('template/head'));
        $view->set('header', View::forge('template/header'));
        $view->set('contents', View::forge('member/mypage'));
        $view->set('footer', View::forge('template/footer'));
        $view->set_global('sidebar', View::forge('template/sidebar'));
        $view->set_global('post_tdata', $post_tdata);
        $view->set_global('post_month', $post_month);
        $view->set_global('post_year', $post_year);
        $view->set_global('month_count', $month_count);
        $view->set_global('year_count', $year_count);
        $view->set_global('current_month', $current_month);

        return $view;
    }
}