<?php return [

    // App
    'app_name'                => 'SIKessEm',
    'app_mode'                => 'local',
    'app_namespace'           => 'Ske',
    'app_key'                 => uniqid(rand(), TRUE),
    'app_debug'               => TRUE,
    
    // Filesystem
    'fs_driver'               => 'local',
    'fs_root'                 => getcwd() . DIRECTORY_SEPARATOR,

    // Database
    'db_dialect'              => 'mysql',
    'db_host'                 => 'localhost',
    'db_port'                 => 3306,
    'db_name'                 => NULL,
    'db_username'             => NULL,
    'db_password'             => NULL,
    
    // Web
    'web_host'                => 'localhost',
    'web_ipv4'                => '127.0.0.1',
    'web_ipv6'                => '::1',
    'web_port'                => 80,
    'web_ssl_port'            => 443,
    'web_scheme'              => 'https',
    'web_username'            => NULL,
    'web_password'            => NULL,
    
    // FTP
    'ftp_secure'              => TRUE,
    'ftp_host'                => 'ftp.sikessem.com',
    'ftp_port'                => 21,
    'ftp_timeout'             => 300,
    'ftp_username'            => NULL,
    'ftp_password'            => NULL,
    
    // Mail
    'mail_protocol'           => 'smtp',
    'mail_secure'             => TRUE,
    'mail_host'               => 'mail.sikessem.com',
    'mail_port'               => 465,
    'mail_timeout'            => 300,
    'mail_username'           => NULL,
    'mail_password'           => NULL,
    
    // Session
    'session_driver'          => 'file',
    'session_lifetime'        => 120,

];
