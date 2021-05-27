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
                // 登録した年初末日を取得
                $new_day = date('Y', strtotime($data['created_at'])).'-01-01';
                $last_day = date('Y', strtotime($data['created_at'])).'-12-31';
                // 登録されているデータを取得
                $post = \Model\Stack::find(array(
                    'select' => array('id', 'user_id', 'text_num', 'created_at'),
                    'where' => array(
                        'user_id' => $data['user_id'],
                        array('created_at', 'between', array($new_day,$last_day))
                    ),
                ));
                // 今日と1月分のデータを取得
                $this_month = date('Y-m', strtotime($data['created_at']));
                $month_sum = 0;
                foreach($post as $key => $val){
                    // 今日のデータの場合
                    if($post[$key]->created_at === $data['created_at']){
                        $post_today = $post[$key];
                    }
                    // 今月のデータの場合
                    if(date('Y-m', strtotime($post[$key]->created_at)) === $this_month){
                        $month_data[] = $post[$key];
                        $month_sum =+ $post[$key]->text_num;
                    }
                }
                
                if(!empty($post_today)){
                    // データ更新の準備　postからcreated_atの日付だけ変更
                    // $post = $post[0];
                    $post_today->text_num = $data['text_num'];
                }else{
                    // データ挿入準備
                    $post = \Model\Stack::forge(); // Model_Stackオブジェクトを生成
                    $post->set($data); // インスタンスに値の配列をセット
                }
                $post_today->save(); // レコードを挿入または更新をします
                Session::set_flash('sucMsg', 'データ登録/更新に成功しました。');
                $url = 'https://twitter.com/intent/tweet?text='.date('m月d日', strtotime($data['created_at'])).'%0a'.'文字数：'.$data['text_num'];
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