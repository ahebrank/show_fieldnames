<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('config.php');
// define the old-style EE object
if (!function_exists('ee')) {
    function ee()
    {
        static $EE;
        if (! $EE) {
          $EE = get_instance();
        }
        return $EE;
    }
}

/**
 * ExpressionEngine - by EllisLab
 *
 * @package   ExpressionEngine
 * @author    ExpressionEngine Dev Team
 * @copyright Copyright (c) 2003 - 2011, EllisLab, Inc.
 * @license   http://expressionengine.com/user_guide/license.html
 * @link    http://expressionengine.com
 * @since   Version 2.0
 * @filesource
 */
 
// ------------------------------------------------------------------------

/**
 * Show Fieldnames Module Front End File
 *
 * @package   ExpressionEngine
 * @subpackage  Addons
 * @category  Module
 * @author    Andy Hebrank
 * @link    
 */

class Show_fieldnames {

  /**
   * Get fieldnames
   *
   * @return  array   list of DOM ID -> fieldname mappings
   */ 
  function get_fieldnames() {
    $postdata = file_get_contents("php://input");
    echo $postdata;
    exit();

    return true;
  }

}