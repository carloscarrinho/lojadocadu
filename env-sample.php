<?php

### E-MAIL ###
define('CONF_MAIL_SECRET', '');
define('CONF_MAIL_HOST', '');
define('CONF_MAIL_PORT', 587);
define('CONF_MAIL_PASSWORD', '');
define('CONF_MAIL_USERNAME', '');
define('CONF_MAIL_FROM', '');
define('CONF_MAIL_DEBUGOUTPUT', 'html');

### DATABASES ###
# DEV #
define('CONF_DB_HOSTNAME', '127.0.0.1');
define('CONF_DB_USERNAME', 'root');
define('CONF_DB_PASSWORD', '1234');
define('CONF_DB_NAME', 'db_ecommerce');

# TEST #
// define('CONF_DB_TEST', 'sqlite:' . $_SERVER['DOCUMENT_ROOT'] . '/tests/test_database.sqlite');
define('CONF_DB_NAME_TEST', 'db_ecommerce_test');

### VIEWS ###
define('CONF_VIEW_DIR_STORE', '/views/store/');
define('CONF_VIEW_DIR_ADMIN', '/views/admin/');
define('CONF_VIEW_DIR_CACHE', '/cache/');
