CREATE DATABASE studydata;
-- テーブル名 users
CREATE TABLE `users`(
    `id` INT(11) AUTO_INCREMENT NOT NULL PRIMARY KEY,
    `username` VARCHAR(50) NULL,
    `password` VARCHAR(255) NOT NULL,
    `group` INT(11) DEFAULT 1 NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `last_login` VARCHAR(25) NOT NULL,
    `login_hash`  VARCHAR(255) NOT NULL,
    `profile_fields` TEXT NOT NULL,
    `delete_flg` BOOLEAN DEFAULT 0 NOT NULL,
    `created_at` INT(11) NOT NULL,
    `updated_at` INT(11) NOT NULL
)ENGINE=INNODB DEFAULT CHARSET=utf8;
-- テーブル名 tdata
CREATE TABLE `tdata`(
    `id` INT(11) AUTO_INCREMENT NOT NULL PRIMARY KEY,
    `user_id` INT(11) NOT NULL,
    `text_num` INT(11) DEFAULT 0 NOT NULL,
    `delete_flg` BOOLEAN DEFAULT 0 NOT NULL,
    `created_at` DATE NOT NULL,
    `updated_at` TIMESTAMP NOT NULL
)ENGINE=INNODB DEFAULT CHARSET=utf8;
-- テーブル名 mdata
CREATE TABLE `mdata`(
    `id` INT(11) AUTO_INCREMENT NOT NULL PRIMARY KEY,
    `user_id` INT(11) NOT NULL,
    `month_sum` INT(11) DEFAULT 0 NOT NULL,
    `delete_flg` BOOLEAN DEFAULT 0 NOT NULL,
    `created_at` VARCHAR(7) NOT NULL,
    `updated_at` TIMESTAMP NOT NULL
)ENGINE=INNODB DEFAULT CHARSET=utf8;
-- テーブル名 ydata
CREATE TABLE `ydata`(
    `id` INT(11) AUTO_INCREMENT NOT NULL PRIMARY KEY,
    `user_id` INT(11) NOT NULL,
    `year_sum` INT(11) DEFAULT 0 NOT NULL,
    `delete_flg` BOOLEAN DEFAULT 0 NOT NULL,
    `created_at` VARCHAR(4) NOT NULL,
    `updated_at` TIMESTAMP NOT NULL
)ENGINE=INNODB DEFAULT CHARSET=utf8;
-- テーブル名 record
CREATE TABLE `record` (
  `id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `main_time` int(11) NOT NULL,
  `add_time` int(11) NOT NULL,
  `routine_text` varchar(255) NOT NULL,
  `delete_flg` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

