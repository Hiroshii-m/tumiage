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
    public static function _validation_match_pass_old($pass_old, $username){
        // Validation::active()->set_message('match_pass_old', '古いパスワードが、誤っています。再度、確認してください。');
        return Auth::validate_user($username, $pass_old); // 認証に失敗すれば、falseを返す
    }
    // 古いパスワードのままじゃないかどうか
    public static function _validation_is_pass_new($pass_new, $username){
        return !Auth::validate_user($username, $pass_new); // 認証に成功（古いパスワードのままの場合）すれば、falseを返す
    }
}