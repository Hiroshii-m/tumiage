<?php

class Controller_Member_Updatepass extends Controller_Member
{
    const PASS_LENGTH_MIN = 6;
    const PASS_LENGTH_MAX = 20;

    public function action_index()
    {
        $data['user_id'] = Arr::get(Auth::get_user_id(), 1);
        $error = '';
        $formData = '';
        // 新しいFieldsetインスタンスを格納
        $form = Fieldset::forge('signupform');
        $form->add_model('MyValidation');
        // 項目設定
        $form->add('pass_old', '古いパスワード', array('class'=>'c-form__input', 'type'=>'password', 'placeholder'=>'古いパスワード'))
            ->add_rule('required')
            ->add_rule('min_length', self::PASS_LENGTH_MIN)
            ->add_rule('max_length', self::PASS_LENGTH_MAX);
        $form->add('pass_new', '新しいパスワード', array('class'=>'c-form__input', 'type'=>'password', 'placeholder'=>'新しいパスワード'))
            ->add_rule('required')
            ->add_rule('min_length', self::PASS_LENGTH_MIN)
            ->add_rule('max_length', self::PASS_LENGTH_MAX);
        $form->add('password_re', 'パスワード（再入力）', array('class'=>'c-form__input', 'type'=>'password', 'placeholder'=>'パスワード（再入力）'))
            ->add_rule('match_field', 'password')
            ->add_rule('required')
            ->add_rule('min_length', self::PASS_LENGTH_MIN)
            ->add_rule('max_length', self::PASS_LENGTH_MAX)
            ->add_rule('valid_string', array('alpha', 'numeric', 'dashes', 'utf8'));
        $form->add('submit', '', array('class'=>'c-form__submit', 'type'=>'submit', 'value'=>'登録'));
        // 送信された場合
        if(Input::method() === 'POST'){
            $val = $form->validation();
            // バリデーションを行う
            if($val->run()){
                // ユーザー登録
                $formData = $val->validated();
                $auth = Auth::instance();
                if($auth->create_user($formData['username'], $formData['password'], $formData['email'])){
                    $auth->login($formData['username'], $formData['password']);
                    Session::set_flash('sucMsg', 'ユーザー登録に成功しました。');
                    // マイページへ遷移
                    Response::redirect('member/mypage');
                }else{
                    Session::set_flash('errMsg', 'ユーザー登録に失敗しました。時間を置いてから、試してください。');
                }
            }else{
                $error = $val->error();
                Session::set_flash('errMsg', 'ユーザー登録に失敗しました。時間を置いてから、試してください。');
            }
            $form->repopulate();
        }
        // 変数としてビューを割り当てる
        $view = View::forge('template/index');
        $view->set('head', View::forge('template/head'));
        $view->set('header', View::forge('template/header'));
        $view->set('contents', View::forge('auth/signup'));
        $view->set('footer', View::forge('template/footer'));
        $view->set_global('signupform', $form->build(''), false);
        $view->set_global('error', $error);

        return $view;
    }
}