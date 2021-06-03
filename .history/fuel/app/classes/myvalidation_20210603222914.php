<?php

class MyValidation {
    public static function _validation_unique_email($email){
        // Validation::active()->set_message('unique_email', 'そのEmailは、既に登録されています');
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
}