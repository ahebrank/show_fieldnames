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
    $data = explode(",", $postdata);
    $ids = [];
    foreach ($data as $field) {
      $e = explode("_", $field);
      if (count($e) !== 3) {
        continue;
      }
      if (!is_numeric($e[2])) {
        continue;
      }
      $ids[$e[2]] = $field;
    }

    $result = ee()->db->select('field_id, field_name')
      ->from('channel_fields')
      ->where_in('field_id', array_keys($ids))
      ->get()->result();

    $return_data = array();
    foreach ($result as $row) {
      $return_data['hold_field_' . $row->field_id] = $row->field_name;
    }

    echo json_encode($return_data);
    exit();
  }

}