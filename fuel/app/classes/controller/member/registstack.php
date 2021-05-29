<?php

class Controller_Member_Registstack extends Controller_Member
{
    public function action_index()
    {
        $error = '';
        $formData = '';
        $data = array();

        $form = Fieldset::forge('registform', array(
            'form_attributes' => array(
                'target' => '_blank'
            )
        ));
        $form->add('created_at', '日付', array('class'=>'c-form__input', 'type'=>'date', 'value'=>date('Y-m-d')))
            ->add_rule('required');
        $form->add('text_num', '打ち込んだ文字数', array('class'=>'c-form__input', 'type'=>'number'))
            ->add_rule('required')
            ->add_rule('valid_string', array('numeric'));
        $form->add('content', '入力する内容', array('class'=>'c-form__textarea', 'type'=>'textarea'));
        $form->add('submit', '', array('class'=>'c-form__submit', 'type'=>'submit', 'value'=>'登録'));
        // POSTされた場合
        if(Input::method() === 'POST'){
            $val = $form->validation();
            // バリデーションを実行
            if($val->run()){
                $formData = $val->validated();
                // 登録する項目を変数に格納
                $data['user_id'] = Arr::get(Auth::get_user_id(), 1);
                $data['created_at'] = $formData['created_at'];
                $data['text_num'] = $formData['text_num'];
                // 入力したテキストの改行コードをTwitter用に置き換える
                $content = str_replace(array("\r\n", "\r", "\n"), '%0a', $formData['content']);

                // 登録した年初末日を取得
                $new_day = date('Y', strtotime($data['created_at'])).'-01-01';
                $last_day = date('Y', strtotime($data['created_at'])).'-12-31';
                // 登録されているデータを取得
                $post = \Model\Stack::find(array(
                    'select' => array('id', 'user_id', 'text_num', 'created_at'),
                    'where' => array(
                        'user_id' => $data['user_id'],
                        array('created_at', 'between', array($new_day,$last_day)),
                        'delete_flg' => 0
                    ),
                ));
                // 今日と1月分のデータを取得
                $this_month = date('Y-m', strtotime($data['created_at']));
                $month_sum = 0;
                $year_sum = 0;
                foreach($post as $key => $val){
                    // 今日のデータを格納
                    if($post[$key]->created_at === $data['created_at']){
                        $post_today = $post[$key];
                    }
                    // 今月の合計文字数を計算
                    if(date('Y-m', strtotime($post[$key]->created_at)) === $this_month){
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
                
                if(!empty($post_today)){
                    // データ更新の準備　postからcreated_atの日付だけ変更
                    // $post = $post[0];
                    $post_today->text_num = $data['text_num'];
                }else{
                    // データ挿入準備
                    $post_today = \Model\Stack::forge(); // Model_Stackオブジェクトを生成
                    $post_today->set($data); // インスタンスに値の配列をセット
                }
                $post_today->save(); // レコードを挿入または更新をします
                Session::set_flash('sucMsg', 'データ登録/更新に成功しました。');
                $url = 'https://twitter.com/intent/tweet?text='.date('m月d日', strtotime($data['created_at'])).'%0a本日：'.$data['text_num'].'文字%0a月平均：'.$month_average.'文字%0a月合計：'.$month_sum.'文字%0a年平均：'.$year_average.'文字%0a年合計：'.$year_sum.'文字%0a%0a'.$content;
                // Twitterへ投稿
                Response::redirect($url);
            // バリデーション失敗
            }else{
                $error = $val->error();
                Session::set_flash('errMsg', 'データ登録/更新に失敗しました。時間を置いてからお試しください。');
            }
        }
        // 変数として、ビューに割り当てる
        $view = View::forge('template/index');
        $view->set('head', View::forge('template/head'));
        $view->set('header', View::forge('template/header'));
        $view->set('contents', View::forge('member/registstack'));
        $view->set('footer', View::forge('template/footer'));
        // グローバル変数
        $view->set_global('registform', $form->build(''), false);
        $view->set_global('error', $error);

        return $view;
    }
}