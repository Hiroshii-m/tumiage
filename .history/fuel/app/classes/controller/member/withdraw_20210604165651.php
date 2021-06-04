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
        $form = Fieldset::forge('withdrawform');
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
                if($auth->delete_user($data['username'])){
                    Session::set_flash('sucMsg', '退会できました。');
                    // マイページへ遷移
                    Response::redirect('auth/signup');
                }else{
                    Session::set_flash('errMsg', '退会できませんでした。時間を置いてから、試してください。');
                }
            }else{
                $error = $val->error();
                Session::set_flash('errMsg', '退会できませんでした。時間を置いてから、試してください。');
            }
            $form->repopulate();
        }
        // 変数としてビューを割り当てる
        $view = View::forge('template/index');
        $view->set('head', View::forge('template/head'));
        $view->set('header', View::forge('template/header'));
        $view->set('contents', View::forge('member/updatepass'));
        $view->set('footer', View::forge('template/footer'));
        $view->set_global('form', $form->build(''), false);
        $view->set_global('error', $error);

        return $view;
    }
}