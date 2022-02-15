<?php return [

    // App
    'app_name'                => env('APP_NAME', 'SIKessEm'),
    'app_mode'                => env('APP_MODE', 'local'),
    'app_namespace'           => env('APP_NAMESPACE', 'Ske'),
    'app_key'                 => env('APP_KEY', uniqid(rand(), true)),
    'app_debug'               => env('APP_DEBUG', true),
    
    // Filesystem
    'fs_driver'               => env('FS_DRIVER', 'local'),
    'fs_root'                 => env('FS_ROOT', __DIR__ . DIRECTORY_SEPARATOR),

    // Database
    'db_dialect'              => env('DB_DIALECT', 'mysql'),
    'db_host'                 => env('DB_HOST', 'localhost'),
    'db_port'                 => env('DB_PORT', 3306),
    'db_name'                 => env('DB_NAME'),
    'db_username'             => env('DB_USERNAME'),
    'db_password'             => env('DB_PASSWORD'),
    
    // Web
    'web_host'                => env('WEB_HOST', 'localhost'),
    'web_ipv4'                => env('WEB_IPV4', '127.0.0.1'),
    'web_ipv6'                => env('WEB_IPV6', '::1'),
    'web_port'                => env('WEB_PORT', 80),
    'web_ssl_port'            => env('WEB_SSL_PORT', 443),
    'web_scheme'              => env('WEB_SCHEME', 'https'),
    'web_username'            => env('WEB_USERNAME'),
    'web_password'            => env('WEB_PASSWORD'),
    
    // FTP
    'ftp_secure'              => env('FTP_SECURE', true),
    'ftp_host'                => env('FTP_HOST', 'ftp.sikessem.com'),
    'ftp_port'                => env('FTP_PORT', 21),
    'ftp_timeout'             => env('FTP_TIMEOUT', 300),
    'ftp_username'            => env('FTP_USERNAME'),
    'ftp_password'            => env('FTP_PASSWORD'),
    
    // Mail
    'mail_protocol'           => env('MAIL_PROTOCOL', 'smtp'),
    'mail_secure'             => env('MAIL_SECURE', true),
    'mail_host'               => env('MAIL_HOST', 'mail.sikessem.com'),
    'mail_port'               => env('MAIL_PORT', 465),
    'mail_timeout'            => env('MAIL_TIMEOUT', 300),
    'mail_username'           => env('MAIL_USERNAME'),
    'mail_password'           => env('MAIL_PASSWORD'),
    
    // Session
    'session_driver'          => env('SESSION_DRIVER', 'file'),
    'session_lifetime'        => env('SESSION_LIFETIME', 120),

];
