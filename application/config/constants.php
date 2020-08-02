<?php
defined('BASEPATH') OR exit('No direct script access allowed');



define('BACKEND_ASSETS', 'assets/backend/');
define('assetsfrontendurl', 'assets/frontend/');
define('NG','ng/');
define('NGModules','ng/modules/');




define('TICKET_REPLY_EVT_BASIC', '1');
define('TICKET_REPLY_EVT_CREATE', '2');
define('TICKET_REPLY_EVT_CLOSE', '3');
define('TICKET_REPLY_EVT_OPEN', '4');
define('TICKET_REPLY_EVT_CATEGORY', '5');
define('TICKET_REPLY_EVT_LOCKED', '6');
define('TICKET_REPLY_EVT_ASIGNEE', '7');





define('LOG_CREATE_TICKET', 1);
define('LOG_EDIT_TICKET', 2);
define('LOG_DELETE_TICKET', 3);
define('LOG_CREATE_TASK', 4);
define('LOG_EDIT_TASK', 5);
define('LOG_DELETE_TASK', 6);
define('LOG_CREATE_USER', 7);
define('LOG_EDIT_USER', 8);
define('LOG_DELETE_USER', 9);
define('LOG_CREATE_GROUP', 10);
define('LOG_DELETE_GROUP', 11);
define('LOG_EDIT_GROUP', 12);
define('LOG_CREATE_TICKET_PRIORITY', 13);
define('LOG_EDIT_TICKET_PRIORITY', 14);
define('LOG_DELETE_TICKET_PRIORITY', 15);
define('LOG_CHANGE_TICKET_STATUS', 16);
define('LOG_CHANGE_TICKET_PRIORITY', 17);
define('LOG_CHANGE_TICKET_CATEGORY', 18);
define('LOG_CHANGE_TICKET_ASIGNEE', 19);
define('LOG_CHANGE_TASK_STATUS', 20);
define('LOG_REPLY_TICKET', 21);
define('LOG_REPLY_TASK', 22);
define('LOG_DELETE_TICKET_PERMANENT', 23);



/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code






