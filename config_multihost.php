<?php  // Moodle configuration file

# You will have to identify the database and credentials here:
$db_name = 'qmplus_190128';
$db_user = 'moodle_user';
$db_pass = 'moodle';

# uncomment the next 2 lines to force debug output
#$CFG->debug = 32767;
#$CFG->debugdisplay = 1;

######################################################
# normally you do not need to make any changes below #
######################################################

unset($CFG);
global $CFG;
$CFG = new stdClass();

if (php_sapi_name() === 'cli') {
    $server_name = gethostname();
#    $CFG->wwwroot = $server_name;
    $subfolder = explode('/', $_SERVER['SCRIPT_FILENAME'])[3];
    $CFG->wwwroot = isset($subfolder) ? $subfolder : $server_name;
} else {
    $scheme = 'https';
    $server_name = filter_var($_SERVER['SERVER_NAME'], FILTER_SANITIZE_URL);
    $CFG->wwwroot   = $scheme . '://' . $server_name ;

    if (gethostname() !== 'multihost_centos7_php7_httpd') {
        $CFG->wwwroot   = $scheme . '://' . $server_name .':8443';
    }

    if($_SERVER['DOCUMENT_ROOT'] == '/var/www/html'){
        $subfolder = explode('/', $_SERVER['SCRIPT_FILENAME'])[4];
        $CFG->wwwroot .= '/' . $subfolder;
    } else {
        $subfolder = null;
    }
}

$moodledata_folder = (isset($subfolder)) ? $subfolder : $server_name;

$CFG->dataroot  = '/var/moodledata/'.$moodledata_folder;
$CFG->admin     = 'admin';
$CFG->directorypermissions = 0777;

$CFG->dbtype    = 'mysqli';
$CFG->dblibrary = 'native';
$CFG->dbhost    = 'db_host';
$CFG->dbname    = $db_name;
$CFG->dbuser    = $db_user;
$CFG->dbpass    = $db_pass;
$CFG->prefix    = 'mdl_';
$CFG->dboptions = array(
    'dbpersist' => 0,
    'dbport' => '',
    'dbsocket' => '',
);


// MIS common configuration
$CFG->mis_host   = 'db_host';
$CFG->mis_dbase  = 'qmu_mis';
$CFG->mis_dbtype = 'mysqli';
$CFG->mis_user   = 'moodle_user';
$CFG->mis_pass   = 'moodle';

$CFG->allow_mass_enroll_feature=1;

// Maximum Number of Tabs - 5 is the built in default value if nothing is declared here
// only a maximum up to 10 tabs (tab0...tab9) is rendered
$CFG->max_tabs	= 6;

// allow backups to stay in temp folder for better dev cycles
//$CFG->keeptempdirectoriesonbackup = true;

require_once(__DIR__ . '/lib/setup.php');

// There is no php closing tag in this file,
// it is intentional because it prevents trailing whitespace problems!
