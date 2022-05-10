[app]
NAME=${app_name}
MODE=${app_mode}
NAMESPACE=${app_namespace}
APP_KEY=${app_key}
APP_DEBUG=${app_debug}

[fs]
DRIVER=${fs_driver}
ROOT=${fs_root}

[db]
DIALECT=${db_dialect}
HOST=${db_host}
PORT=${db_port}
NAME=${db_name}
USERNAME=${db_username}
PASSWORD=${db_password}

[web]
HOST=${web_host}
IPV4=${web_ipv4}
IPV6=${web_ipv6}
PORT=${web_port}
SSL_PORT=${web_ssl_port}
SCHEME=${web_scheme}
USERNAME=${web_username}
PASSWORD=${web_password}

[ftp]
SECURE=${ftp_secure}
HOST=${ftp_host}
PORT=${ftp_port}
TIMEOUT=${ftp_timeout}
USERNAME=${ftp_username}
PASSWORD=${ftp_password}

[mail]
PROTOCOL=${mail_protocol}
SECURE=${mail_secure}
HOST=${mail_host}
PORT=${mail_port}
USERNAME=${mail_username}
PASSWORD=${mail_password}

[session]
DRIVER=${session_driver}
LIFETIME=${session_lifetime}
