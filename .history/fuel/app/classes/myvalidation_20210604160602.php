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
    public static function _validation_match_passold($pass_old, $u_id){
        $result = DB::select("password")
                ->where('id', '=', $u_id)
                ->from('users')->execute();
        return (password_verify($pass_old, $result[0]['password']));
    }
    // 同じ値だった場合、エラー
    public static function _validation_dont_match_field($pass_new, $pass_old){
        return !($pass_old === $pass_new);
    }
}