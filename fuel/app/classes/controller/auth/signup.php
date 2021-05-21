<?php

class Controller_Auth_Signup extends Controller
{
    const PASS_LENGTH_MIN = 6;
    const PASS_LENGTH_MAX = 255;

    public function add_action()
    {
        $error = '';
        $formData = '';
        // 新しいFieldsetインスタンスを格納
        $form = Fieldset::forge('signup');
        // 項目設定
        $form->add('username', 'ユーザー名', array('type'=>'text', 'placeholder'=>'ユーザー名'))
            ->add_rule('required')
            ->add_rule('min_length', 1)
            ->add_rule('max_length', 255);
        $form->add('email', 'Email', array('type'=>'email', 'placeholder'=>'メールアドレス'))
            ->add_rule('required')
            ->add_rule('min_length', 1)
            ->add_rule('max_length', 255)
            ->add_rule('valid_email');
        $form->add('password', 'パスワード', array('type'=>'password', 'placeholder'=>'パスワード'))
            ->add_rule('required')
            ->add_rule('min_length', PASS_LENGTH_MIN)
            ->add_rule('max_length', PASS_LENGTH_MAX)
            ->add_rule('valid_string', array('alpha', 'numeric', 'dashes', 'utf8'));
        $form->add('password_re', 'パスワード（再入力）', array('type'=>'password', 'placeholder'=>'パスワード（再入力）'))
            ->add_rule('match_field', 'password')
            ->add_rule('required')
            ->add_rule('min_length', PASS_LENGTH_MIN)
            ->add_rule('max_length', PASS_LENGTH_MAX)
            ->add_rule('valid_string', array('alpha', 'numeric', 'dashes', 'utf8'));
        $form->add('submit', '', array('type'=>'submit', 'value'=>'ユーザー登録'));
        // 送信された場合
        if(Input::method === 'POST'){
            $val = $form->validation();
            // バリデーションを行う
            if($val->run()){
                // ユーザー登録
                $formData = $val->validated();
                $auth = Auth::instance();
                if($auth->create_user($formData['username'], $formData['password'], $formData['email'])){
                    Session::set_flash('sucMsg', 'ユーザー登録に成功しました。');
                }
            }else{
                $error = $val->error();
                Session::set_flash('errMsg', 'ユーザー登録に失敗しました。時間を置いてから、試してください。');
            }
        }
        // 変数としてビューを割り当てる
    }
}