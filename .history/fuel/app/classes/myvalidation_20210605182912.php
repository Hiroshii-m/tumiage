<?php

class MyValidation {
    public static function _validation_unique_email($email){
        $result = DB::select("email")
                ->where('email', '=', strtolower($email))
                ->from('users')->execute();
        return !($result->count() > 0); // 取得件数が0より多い場合、falseを返す
    }
    public static function _validation_unique_username($username){
        $result = DB::select("username")
                ->where('username', '=', strtolower($username))
                ->from('users')->execute();
        return !($result->count() > 0); // 取得件数が0より多い場合、falseを返す
    }
    // 古いパスワードがあっているか
    public static function _validation_match_pass_old($pass_old, $u_id){
        Validation::active()->set_message('macth_pass_old', '古いパスワードが、誤っています。再度、確認してください。');
        $result = DB::select("password")
                ->where('id', '=', $u_id)
                ->from('users')->execute();
        return !(password_verify($pass_old, $result[0]['password'])); // パスワードが間違っていれば、false
    }
}