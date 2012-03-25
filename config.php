<?php

// Define some constants

define('AUTOLOAD_MODEL','model');
define('AUTOLOAD_GENERAL_FUNCS', 'generalfuncs');
define('AUTOLOAD_CUSTOM_FUNCS', 'customfuncs');
define('AUTOLOAD_CUSTOM_CLASS', 'custom');

/**
 * Configuration
 * **************
 * There are some general purpose configuration, like Database settings 
 * or your base URL etc. 
 */
class Config {

    /**
     * Database Configuration
     * @var mixed - Key-Value pair Array. 
     */
    public $db = array(
//        'driver' => 'mysql',            ///< Possible values: 'mysql' 'pdo_mysql'
        'driver' => 'pdo_mysql',            ///< Possible values: 'mysql' 'pdo_mysql'
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'yourdbname'
    );

    /**
     * Base URL: Location where your site exists. Must begin with http or https
     * 
     * This is important to show images or javascript/css files properly.
     * \warning Please provide a slash (/) at the ending!
     * \note Available by constant: BASE_URL
     * 
     * @var string
     */
    public $base_url = 'http://localhost/phpizza/';

    /**
     * Templating/Theming
     * 
     * Name the default theme/template for the site. There is a built-in template 'WhiteLove'
     * You may also change template within your Controller class.
     * \note Available by constant: SITE_THEME
     * 
     * @var string
     */
    public $site_theme = 'WhiteLove';

    /**
     * Landing Page
     * 
     * This is the Controller path which is automatically loaded, if user does not 
     * provide any. For example, if user types http://example.com then this Controller class 
     * along with the View class will be loaded.
     * \note Available by constant: LANDING_PAGE
     * 
     * @var string
     */
    public $landing_page = 'index';

    /**
     * Autoloads - These classes/files will be loaded automatically.
     * Be careful when autoloading Custom classes this way. You do not need to autoload
     * any custom class, because custom classes are loaded on-the-fly. If you autoload a custom
     * class, it will be provided access to Core framework, which might be a security concern.
     * So, only autoload custom classes you trust.
     * 
     * @var mixed
     */
    public $autoloads = array(
        AUTOLOAD_CUSTOM_CLASS => array(), ///< Custom Classes
        AUTOLOAD_MODEL => array(), ///< MODEL Classes
        AUTOLOAD_CUSTOM_FUNCS => array(),   ///< Custom Functions
        AUTOLOAD_GENERAL_FUNCS => array('form') ///< General Functions
    );

    /**
     * Clean/Nice URLs
     * 
     * If enabled, all URLs generated by the site will be "clean" or "nice", i.e. yoursite.com/a/b/c
     *  -   .htaccess should be activated.
     * If disabled, URL will look like: yoursite.com?p=a/b/c
     * \note Availabe by constant: NICE_URL_ENABLED
     * 
     * @var bool
     */
    public $nice_url_enabled = false;

    /**
     * Prints various information availabe for debugging. Must be set to false in a production server.
     * \note Available by constant: DEBUG_MODE
     * 
     * @var bool 
     */
    public $debug_mode = true;

    /**
     * URL Extention
     * (Only effective if NICE_URL_ENABLED is set to true)
     *
     * All of your URLs will end with this extention. Provide with leading dot (for example: '.html')
     * Leave empty, for no extentions.
     *
     * YOU MAY NEED TO CHANGE .htaccess FILE ACCORDINGLY IF YOU PUT ANY VALUE IN THIS! See line #10 of
     * .htaccess file - in place of ".html" you may put your desired URL extention.
     * 
     * @var string
     */
    public $url_extention = '';
    

    /**
     * Default FunctionToCall
     * 
     * This function will be called within your Controller class if not provided any.
     * 
     * @var string
     */
    public $default_function_to_call = 'index';

    /*
     * ***********************************************
     * DO NOT CHANGE ANYTHING BEYOND THIS POINT!
     * ***********************************************
     */
    private static $instance;
    private static $instanceCounter = 0;

    /**
     * Singleton Constructor
     */
    private function __construct() {
        
    }
    
    /**
     * Don't care this function. It allows only one instance of Config class for security issues. 
     */

    public static function getInstance() {
        if (self::$instanceCounter === 0 || TESTING_PHPIZZA) {
            self::$instanceCounter++;
            self::$instance = new Config();
            return self::$instance;
        }
        trigger_error('Access to Config class is denied!', E_USER_ERROR);
    }

    public function __clone() {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }

    public function __wakeup() {
        trigger_error('Unserializing is not allowed.', E_USER_ERROR);
    }

}

/**
 * Constants
 */
//@{


/**
 * System configuration : Never change following settings!
 */
define('PROJECT_DIR', dirname(__FILE__) . '/');

/**
 * Internal Paths
 * 
 * Do not change them. Modify only if you do understand what you are doing!
 */

define('CORE_DIR', PROJECT_DIR . 'core/');
// Or, you can mention full-path to core directory like:
//define('CORE_DIR', '/var/www/htdocs/projects/gigamvc/core/');

define('CUSTOM_DIR', PROJECT_DIR . 'custom/');



define('VIEW_DIR', PROJECT_DIR . 'VIEW/');
define('CONTROL_DIR', PROJECT_DIR .  'CONTROL/');
define('MODEL_DIR', PROJECT_DIR . 'MODEL/');
define('FORMS_DIR', VIEW_DIR . "forms/");   //  Directory where your HTML forms reside
define('THIRDPARTY_DIR', PROJECT_DIR . '3rdparty/');

//@}


// Other Constants

// MsgBox Status related

define('MSGBOX_INFO', 0);
define('MSGBOX_SUCCESS', 1);
define('MSGBOX_WARNING', 2);
define('MSGBOX_ERROR', 3);


?>
