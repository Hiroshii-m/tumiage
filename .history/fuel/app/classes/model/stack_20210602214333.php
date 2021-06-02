<?php

namespace Model;

class Stack extends \Model_Crud{
    // テーブル名を登録する
    protected static $_table_name = 'tdata';
}
class Mdata extends \Model_Crud{
    protected static $_table_name = 'mdata';
}
class Ydata extends \Model_Crud{
    protected static $_table_name = 'ydata';
}
class User extends \Model_Crud{
    // テーブル名を登録する
    protected static $_table_name = 'users';
}