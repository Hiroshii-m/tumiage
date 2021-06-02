<?php

class Controller_Member_Registstack extends Controller_Member
{
    public function action_index()
    {
        $error = '';
        $formData = '';
        $data = array();

        $form = Fieldset::forge('editprofform');
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
                $data['text_num'] = $formData['text_num'];
                $data['created_at'] = $formData['created_at'];
                // 入力したテキストの改行コードをTwitter用に置き換える
                $content = (!empty($formData['content'])) ? str_replace(array("\r\n", "\r", "\n"), '%0a', $formData['content']) : '';
                $month_date = date('Y-m', strtotime($data['created_at']));
                $year_date = date('Y', strtotime($data['created_at']));
                // 今月・今年の日数を取得
                $month_count = date('t', strtotime($data['created_at']));
                $feb = date('Y', strtotime($data['created_at'])).'-02-01';
                $year_count = 337 + date('t', strtotime($feb));
                $mdata['user_id'] = $data['user_id'];
                $mdata['created_at'] = date('Y-m', strtotime($data['created_at']));
                $ydata['user_id'] = $data['user_id'];
                $ydata['created_at'] = date('Y', strtotime($data['created_at']));
                $rst = false; // transactionの結果を初期化

                try{
                    DB::start_transaction();
                    

                    $rst = DB::commit_transaction(); // transactionが成功した時、trueが格納される。
                }catch(Exception $e){
                    DB::rollback_transaction();
                    
                    throw $e;
                }

                
            // バリデーション失敗
            }else{
                $error = $val->error();
                Session::set_flash('errMsg', 'データ更新に失敗しました。時間を置いてからお試しください。');
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