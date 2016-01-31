CREATE TABLE `djlist` (
`dj_id` INT( 4 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`dj_username` VARCHAR( 20 ) NOT NULL ,
`dj_password` VARCHAR( 20 ) NOT NULL ,
`dj_public_name` VARCHAR( 50 ) NOT NULL
) ENGINE = MYISAM ;

CREATE TABLE `adminlist` (
`admin_id` INT( 4 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`admin_username` VARCHAR( 20 ) NOT NULL ,
`admin_password` VARCHAR( 20 ) NOT NULL
) ENGINE = MYISAM ;

CREATE TABLE `songrequests` (
`request_id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`request_dj_id` INT( 4 ) NOT NULL ,
`request_time` INT( 12 ) UNSIGNED NOT NULL ,
`request_person_name` VARCHAR( 50 ) NOT NULL ,
`request_song_name` VARCHAR( 50 ) NOT NULL ,
`request_note` VARCHAR( 255 ) NOT NULL
) ENGINE = MYISAM ;

CREATE TABLE `currentdjlist` (
`current_id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`current_dj_id` INT( 4 ) NOT NULL ,
`current_dj_login_time` INT( 12 ) UNSIGNED NOT NULL ,
`current_dj_logout_time` INT( 12 ) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE = MYISAM ;

CREATE TABLE `requestiplist` (
`userip_id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`user_ip_addy` VARCHAR( 20 ) NOT NULL ,
`user_ip_time` INT( 12 ) UNSIGNED NOT NULL
) ENGINE = MYISAM ;

INSERT INTO adminlist (admin_username, admin_password) VALUES ('admin', 'default') ;
