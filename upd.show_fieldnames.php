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
 * Show Fieldnames Module Install/Update File
 *
 * @package   ExpressionEngine
 * @subpackage  Addons
 * @category  Module
 * @author    Andy Hebrank
 * @link    
 */

class Show_fieldnames_upd {
  
  public $version = SHOW_FIELDNAMES_VERSION;
  public $name = SHOW_FIELDNAMES_NAME;
  public $class = SHOW_FIELDNAMES_CLASS;
  
  /**
   * Constructor
   */
  public function __construct() {
  }
  
  // ----------------------------------------------------------------
  
  /**
   * Installation Method
   *
   * @return  boolean   TRUE
   */
  public function install() {
    $mod_data = array(
      'module_name'     => $this->name,
      'module_version'    => $this->version,
      'has_cp_backend'    => 'n',
      'has_publish_fields'  => 'n'
    );
    ee()->db->insert('modules', $mod_data);

    // register the front end hit action
    $action_data = array(
      'class' => $this->class,
      'method' => 'get_fieldnames');
    ee()->db->insert('actions', $action_data);

    return true;
  }

  // ----------------------------------------------------------------
  
  /**
   * Uninstall
   *
   * @return  boolean   TRUE
   */ 
  public function uninstall()
  {
    $mod_id = ee()->db->select('module_id')
                ->get_where('modules', array(
                  'module_name' => $this->name,
                ))->row('module_id');
    
    ee()->db->where('module_id', $mod_id)
           ->delete('module_member_groups');
    
    ee()->db->where('module_name', $this->name)
           ->delete('modules');
    
    ee()->db->where('class', $this->class)
            ->delete('actions');
    
    return true;
  }
  
  // ----------------------------------------------------------------
  
  /**
   * Module Updater
   *
   * @return  boolean   TRUE
   */ 
  public function update($current = '')
  {
    return true;
  }
  
}
/* End of file upd.hits_around_cache.php */