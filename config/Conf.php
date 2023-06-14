<?php
namespace Config;
use Config\Connection;
abstract class conf{
    static function init(Connection $conn){
        $conn->set_db(
            'db_local', new DB(
                'mysql',
                'localhost',
                'root',
                'campusLand@2023',
                'sgavapp',
                [\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci']            
        ));
        $conn->set_db(
            'db_campus', new DB(
                'mysql',
                'localhost',
                'campus',
                'campus2023',
                'sgavapp',
                [\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci']            
        ));
        $conn->set_db(
            'db_remote', new DB(
                'mysql',
                '172.16.48.210',
                'apolo',
                '@pol0Adm1n$',
                'javier_campo',
                [\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci']                
            ));
    }
}