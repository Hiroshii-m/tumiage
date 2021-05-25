<?php

class Controller_Member_Registstack extends Controller_Member
{
    public function action_index()
    {
        $error = '';
        $formData = '';
        $data['username'] = Auth::get_screen_name(); // ユーザー名を取得
        $data['user_id'] = Auth::get_user_id(); // 現在ログインしているユーザーIDを取得

        $form = Fieldset::forge('registform');
        $form->add('create_at', '日付', array('class'=>'c-form__input', 'type'=>'date', 'value'=>date('Y-m-d')))
            ->add_rule('required');
        $form->add('text_num', '打ち込んだ文字数', array('class'=>'c-form__input', 'type'=>'number'))
            ->add_rule('required')
            ->add_rule('valid_string', array('numeric'));
        $form->add('submit', '', array('class'=>'c-form__submit', 'type'=>'submit', 'value'=>'登録'));
        // POSTされた場合
        if(Input::method() === 'POST'){
            $val = $form->validation();
            // バリデーションを実行
            if($val->run()){
                $formData = $val->validated();
                $formData['user_id'] = $data['user_id'];
                // DBへ登録
                $post = \Model\Stack::forge(); // Model_Stackオブジェクトを生成
                $post->set($formData); // インスタンスに値の配列をセット
                $post->save(); // レコードを挿入または更新します
            // バリデーション失敗
            }else{
                $error = $val->error;
                Session::set_flash('errMsg', '登録に失敗しました。時間を置いてからお試しください。');
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