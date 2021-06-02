<?php

class Controller_Member_Registstack extends Controller_Member
{
    public function action_index()
    {
        $error = '';
        $formData = '';
        $data['user_id'] = Arr::get(Auth::get_user_id(), 1);

        $form = Fieldset::forge('editprofform');
        $form->add('username', 'ユーザーネーム', array('class'=>'c-form__input', 'type'=>'text', 'value'=>date('Y-m-d')))
            ->add_rule('required')
            ->add_rule('min_length', 1)
            ->add_rule('max_length', 50);
        $form->add('submit', '', array('class'=>'c-form__submit', 'type'=>'submit', 'value'=>'登録'));
        // POSTされた場合
        if(Input::method() === 'POST'){
            $val = $form->validation();
            // バリデーションを実行
            if($val->run()){
                $formData = $val->validated();
                // 登録する項目を変数に格納

                try{
                    DB::start_transaction();
                    $user = \Model\User::find_by_pk($data['user_id']);

                    $rst = DB::commit_transaction(); // transactionが成功した時、trueが格納される。
                }catch(Exception $e){
                    DB::rollback_transaction();
                    
                    throw $e;
                }

                
            // バリデーション失敗
            }else{
                $error = $val->error();
                Session::set_flash('errMsg', 'プロフィール更新に失敗しました。時間を置いてからお試しください。');
            }
        }
        // 変数として、ビューに割り当てる
        $view = View::forge('template/index');
        $view->set('head', View::forge('template/head'));
        $view->set('header', View::forge('template/header'));
        $view->set('contents', View::forge('member/editprof'));
        $view->set('footer', View::forge('template/footer'));
        // グローバル変数
        $view->set_global('', $form->build(''), false);
        $view->set_global('error', $error);

        return $view;
    }
}