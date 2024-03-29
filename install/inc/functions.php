<?php defined('INST_INSTALLER_PATH') || exit('No direct script access allowed');

/**
 *
 * @package    EasyAds
 * @author     CodinBit <contact@codinbit.com>
 * @link       https://www.easyads.io
 * @copyright  2017 EasyAds (https://www.easyads.io)
 * @license    https://www.easyads.io
 * @since      1.0
 */

/**
 * Will format a string according to the controller name convention
 *
 * @param mixed $string
 * @return string
 */
function formatController($string)
{
    $controller = str_replace('-', ' ', $string);
    $controller = ucwords(strtolower($controller));
    $controller = str_replace(' ', '', $controller);
    $controller .= 'Controller';

    return $controller;
}

/**
 * Will format a string according to the action name convention
 *
 * @param mixed $string
 * @return
 */
function formatAction($string)
{
    $action = str_replace('-', ' ', $string);
    $action = ucwords(strtolower($action));
    $action = str_replace(' ', '', $action);
    $action = 'action'.$action;

    return $action;
}

/**
 * Will prepare a file to be rendered or returned
 *
 * @param mixed $_viewFile_
 * @param mixed $_data_
 * @param bool $_return_
 */
function renderFile($_viewFile_, $_data_=null, $_return_=false)
{
    if(is_array($_data_)) {
        extract($_data_, EXTR_PREFIX_SAME, 'data');
    } else {
        $data = $_data_;
    }

    if($_return_) {
        ob_start();
        ob_implicit_flush(false);
        require($_viewFile_);
        return ob_get_clean();
    } else {
        require($_viewFile_);
    }
}

/**
 * Get a session key/variable
 *
 * @param mixed $key
 * @param mixed $defaultValue
 * @return mixed
 */
function getSession($key, $defaultValue = null)
{
    return isset($_SESSION[$key]) ? $_SESSION[$key] : $defaultValue;
}

/**
 * Set a session key/variable
 *
 * @param mixed $key
 * @param mixed $value
 * @return mixed
 */
function setSession($key, $value)
{
    $_SESSION[$key] = $value;
    return $value;
}

/**
 * Get a post key/variable
 *
 * @param mixed $key
 * @param mixed $defaultValue
 * @return mixed
 */
function getPost($key, $defaultValue = null)
{
    return isset($_POST[$key]) ? clean($_POST[$key]) : $defaultValue;
}

/**
 * Get a query key/variable
 *
 * @param mixed $key
 * @param mixed $defaultValue
 * @return mixed
 */
function getQuery($key, $defaultValue = null)
{
    return isset($_GET[$key]) ? clean($_GET[$key]) : $defaultValue;
}

/**
 * Will perform basic cleaning on any given variable
 *
 * @param mixed $key
 * @return mixed
 */
function clean($key)
{
    if (is_array($key)) {
        $key = array_map('clean', $key);
    } else {
        $key = strip_tags($key);
    }
    return $key;
}

/**
 * Redirect to specific location
 *
 * @param mixed $location
 */
function redirect($location)
{
    header('Location: '.$location);
    exit;
}

/**
 * Create app instance
 * @return \yii\web\Application
 */
function appInstance()
{
    static $app = null;
    if ($app !== null) {
        return $app;
    }

    require INST_VENDOR_PATH . '/yiisoft/yii2/Yii.php';

    $app = new \yii\web\Application(require INST_APP_PATH . '/config/console.php');

    // set the aliases
    Yii::setAlias('@app', INST_APP_PATH);

    return $app;
}
