<?php

class Controller_Member_Withdraw extends Controller_Member
{
    public function action_index()
    {
        $data['user_id'] = Arr::get(Auth::get_user_id(), 1);
        $data['username'] = Auth::get_screen_name();
        $error = '';
        $formData = '';
        // 新しいFieldsetインスタンスを格納
        $form = Fieldset::forge('updatepassform');
        $form->add_model('MyValidation');
        // 項目設定
        $form->add('confirm', '上記を確認しました。', array('class'=>'c-form__check', 'type'=>'checkbox', 'value'=>'1'))
            ->add_rule('required');
        $form->add('submit', '', array('class'=>'c-form__submit', 'type'=>'submit', 'value'=>'退会する'));
        // 送信された場合
        if(Input::method() === 'POST'){
            $val = $form->validation();
            // バリデーションを行う
            if($val->run()){
                // ユーザー登録
                $formData = $val->validated();
                $auth = Auth::instance();
                if($auth->change_password($formData['pass_old'], $formData['pass_new'], $data['username'])){
                    $auth->login($data['username'], $formData['pass_new']);
                    Session::set_flash('sucMsg', 'パスワード変更に成功しました。');
                    // マイページへ遷移
                    Response::redirect('member/mypage');
                }else{
                    Session::set_flash('errMsg', 'パスワード変更に失敗しました。時間を置いてから、試してください。');
                }
            }else{
                $error = $val->error();
                Session::set_flash('errMsg', 'パスワード変更に失敗しました。時間を置いてから、試してください。');
            }
            $form->repopulate();
        }
        // 変数としてビューを割り当てる
        $view = View::forge('template/index');
        $view->set('head', View::forge('template/head'));
        $view->set('header', View::forge('template/header'));
        $view->set('contents', View::forge('member/updatepass'));
        $view->set('footer', View::forge('template/footer'));
        $view->set_global('updatepassform', $form->build(''), false);
        $view->set_global('error', $error);

        return $view;
    }
}