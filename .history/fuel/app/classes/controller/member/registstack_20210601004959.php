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

                try{
                    $db->start_transaction();
                    // DBに本日登録したデータがあるか調べる
                    $post_today = \Model\Stack::find(array(
                        'select' => array('text_num', 'created_at'),
                        'where' => array(
                            'user_id' => $data['user_id'],
                            'created_at' => $data['created_at'],
                            'delete_flg' => 0
                        )
                    ));
                    $post_today = (!empty($post_today[0])) ? $post_today[0] : '';
                    
                    // 月、年から合計文字数を取得
                    $post_month = \Model\Mdata::find(array(
                        'select' => array('month_sum'),
                        'where' => array(
                            'user_id' => $data['user_id'],
                            'created_at' => $month_date,
                            'delete_flg' => 0
                        )
                    ));
                    $post_month = (!empty($post_month[0])) ? $post_month[0] : '';
                    $post_year = \Model\Ydata::find(array(
                        'select' => array('year_sum'),
                        'where' => array(
                            'user_id' => $data['user_id'],
                            'created_at' => $year_date,
                            'delete_flg' => 0
                        )
                    ));
                    $post_year = (!empty($post_year[0])) ? $post_year[0] : '';
    
                    // 本日登録したデータがある場合
                    if(!empty($post_today)){
                        $textnum_update = $data['text_num'] - $post_today->text_num; // (今回登録した文字数ー前回登録した文字数)
                        $post_today->text_num = $data['text_num'];
                    // 本日登録したデータがない場合
                    }else{
                        $textnum_update = $data['text_num']; // 今回登録した文字数
                        $post_today = \Model\Stack::forge(); // Model_Stackのオブジェクトを生成
                        $post_today->set($data); // インスタンスに値の配列をセット
                    }
                    $post_today->save();
                    $mdata['month_sum'] = (!empty($post_month->month_sum)) ? $post_month->month_sum + $textnum_update : $textnum_update;
                    // 月データがある場合
                    if(!empty($post_month)){
                        // 月データ（月文字数＋今回の文字数ー前回登録した文字数）を更新
                        $post_month->month_sum = $mdata['month_sum'];
                    // 月データない場合
                    }else{
                        // 月データ（月文字数＋今回の文字数）を登録
                        $post_month = \Model\Mdata::forge();
                        $post_month->set($mdata);
                    }
                    $post_month->save();
                    $ydata['year_sum'] = (!empty($post_year->year_sum)) ? $post_year->year_sum + $textnum_update : $textnum_update;
                    // 年データがある場合
                    if(!empty($post_year)){
                        // 年データ（年文字数＋今回の文字数ー前回登録した文字数）を更新
                        $post_year->year_sum = $ydata['year_sum'];
                    // 年データがない場合
                    }else{
                        // 年データ（年文字数＋今回の文字数）を登録
                        $post_year = \Model\Ydata::forge();
                        $post_year->set($ydata);
                    }
                    $post_year->save();

                    $db->commit_transaction();
                }catch(Exception $e){
                    $db->rollback_transaction();
                }

                Session::set_flash('sucMsg', 'データ登録/更新に成功しました。');
                $url = 'https://twitter.com/intent/tweet?text='.date('m月d日', strtotime($data['created_at'])).'%0a本日：'.$data['text_num'].'文字%0a月平均：'.round($mdata['month_sum']/$month_count, 2).'文字%0a月合計：'.$mdata['month_sum'].'文字%0a年平均：'.round($ydata['year_sum']/$year_count, 2).'文字%0a年合計：'.$ydata['year_sum'].'文字%0a%0a'.$content;
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