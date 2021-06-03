<?php

class Controller_Login extends Controller
{
    const PASS_LENGTH_MIN = 6;
    const PASS_LENGTH_MAX = 20;

    public function action_index()
    {
        $error = '';
        $formData = '';

        if(Auth::check()){
            Response::redirect('member/mypage');
        }

        // 1. 入力項目の作成
        $form = Fieldset::forge('loginform');
        $form->add('email', 'メールアドレス', array('class'=>'c-form__input', 'type'=>'text'))
            ->add_rule('required')
            ->add_rule('min_length', 1)
            ->add_rule('max_length', 255)
            ->add_rule('valid_email');
        $form->add('password', 'パスワード', array('class'=>'c-form__input', 'type'=>'password'))
            ->add_rule('required')
            ->add_rule('min_length', self::PASS_LENGTH_MIN)
            ->add_rule('max_length', self::PASS_LENGTH_MAX)
            ->add_rule('valid_string', array('class'=>'c-form__submit', 'alpha', 'numeric', 'dashes', 'utf8'));
        $form->add('submit', '', array('class'=>'c-form__submit', 'type'=>'submit', 'value'=>'ログイン'));
        // 2. 入力POSTされた場合
        if(Input::method() === 'POST'){
            $val = $form->validation();
            // 3. バリデーション成功だった場合
            if($val->run()){
                $formData = $val->validated();
                $auth = Auth::instance();
                // 4. DBにユーザー情報があるか確認・ログイン認証
                if($auth->login($formData['userdata'], $formData['password'])){
                    Session::set_flash('sucMsg', 'ログインに成功しました。');
                    // マイページへ遷移
                    Response::redirect('member/mypage');
                }else{
                    Session::set_flash('errMsg', 'ログインに失敗しました。');
                }
            // 5. バリデーション失敗だった場合
            }else{
                $error = $val->error();
                Session::set_flash('errMsg', 'ログインに失敗しました。');
            }
            $form->repopulate();
        }
        // 6. 変数としてビューを割り当てる
        $view = View::forge('template/index');
        $view->set('head', View::forge('template/head'));
        $view->set('header', View::forge('template/header'));
        $view->set('contents', View::forge('auth/login'));
        $view->set('footer', View::forge('template/footer'));
        $view->set_global('loginform', $form->build(''), false);
        $view->set_global('error', $error);

        return $view;
    }
}