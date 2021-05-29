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

        // 登録されているデータを取得
        $post = \Model\Stack::find(array(
            'select' => array('id', 'user_id', 'text_num', 'created_at'),
            'where' => array(
                'user_id' => $u_id,
                array('created_at', 'between', array($new_day,$last_day)),
                'delete_flg' => 0
            ),
        ));
        // 今日と1ヵ月分のデータを取得
        foreach($post as $key => $val){
            // 今日のデータを格納
            if($post[$key]->created_at === $data('Y-m-d')){
                $post_today = $post[$key];
            }
            // 今月の合計文字数を計算
            if(date('Y-m', strtotime($post[$key]->created_at)) === $current_month){
                $month_data[] = $post[$key];
                $month_sum += $post[$key]->text_num;
            }
            // 今年の合計文字数を計算
            $year_sum += $post[$key]->text_num;
        }
        // 今月のデータのレコード数を格納
        $month_count = count($month_data);
        // 今月の平均文字数を計算
        $month_average = round($month_sum/$month_count, 2);
        // 今年のレコード数を格納
        $year_count = count($post);
        // 今年の平均文字数を計算
        $year_average = round($year_sum/$year_count, 2);

        // 変数にビューを割り当てる
        $view = View::forge('template/index');
        $view->set('head', View::forge('template/head'));
        $view->set('header', View::forge('template/header'));
        $view->set('contents', View::forge('member/mypage'));
        $view->set('footer', View::forge('template/footer'));
        $view->set_global('sidebar', View::forge('template/sidebar'));
        $view->set_global('month_data', $month_data);

        return $view;
    }
}