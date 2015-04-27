<?php
require_once('config.php');
if (!defined('APP_VER')) {
    exit('No direct script access allowed');
}
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


class Show_fieldnames_ext {

  public $settings = array();
  public $name = SHOW_FIELDNAMES_NAME;
  public $version = SHOW_FIELDNAMES_VERSION;
  public $class = SHOW_FIELDNAMES_CLASS;
  public $description = 'Reveal fieldnames on content entry pages.';
  public $settings_exist = 'n';
  public $docs_url = '';

  /**
   * Activate Extension
   *
   * This function enters the extension into the exp_extensions table
   *
   * @see http://codeigniter.com/user_guide/database/index.html for more information on the db class.
   *
   * @return void
   */
  public function activate_extension() {
    $hooks = array(
      'cp_js_end' => 'cp_js_end'
    );
    foreach($hooks as $hook => $method) {
      $data = array(
        'class' => __CLASS__,
        'method' => $method,
        'hook' => $hook,
        'priority' => 10,
        'version' => $this->version,
        'enabled' => 'y',
        'settings' => ''
      );
      ee()->db->insert('exp_extensions', $data);
    }
    return true;
  }

  /**
   * Update Extension
   *
   * This function performs any necessary db updates when the extension page is visited.
   *
   * @return mixed void on update / false if none
   */
  public function update_extension($current = '') {
    if($current == '' || $current == $this->version)
      return FALSE;

    ee()->db->where('class', _CLASS__);
    ee()->db->update(
      'extensions',
      array('version' => $this->version)
    );
  }

  /**
   * Disable Extension
   *
   * This method removes information from the exp_extensions table
   *
   * @return void
   */
  public function disable_extension() {
    ee()->db->where('class', __CLASS__);
    ee()->db->delete('extensions');
  }

  /* Hook the control panel JS */
  public function cp_js_end() {
    // be courteous to other users of this hook
    $js = ee()->extensions->last_call;

    // get action ID and POST URL
    $result  = ee()->db->select('action_id')
      ->from('actions')
      ->where('class', $this->class)
      ->where('method', 'get_fieldnames')
      ->get()->row();
    $url = ee()->functions->fetch_site_index(false, false) . QUERY_MARKER . "ACT=" . $result->action_id;

    $tmp = file_get_contents(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'injected_cp.js');
    $js .= "(function($) { var act_url = '" . $url . "';" . $tmp . "})(jQuery);";
    return $js;
  }

}
?>