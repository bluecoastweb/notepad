<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ExpressionEngine - by EllisLab
 *
 * @package    ExpressionEngine
 * @author    ExpressionEngine Dev Team
 * @copyright  Copyright (c) 2003 - 2011, EllisLab, Inc.
 * @license    http://expressionengine.com/user_guide/license.html
 * @link    http://expressionengine.com
 * @since    Version 2.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Notepad Module Install/Update File
 *
 * @package    ExpressionEngine
 * @subpackage  Addons
 * @category  Module
 * @author    Steve Pedersen
 * @link    http://www.bluecoastweb.com
 */

class Notepad_upd {

  public $version = '1.0';

  /**
   * Constructor
   */
  public function __construct()
  {
    // nothing to see here
  }

  // ----------------------------------------------------------------

  /**
   * Installation Method
   *
   * @return   boolean   TRUE
   */
  public function install()
  {
    $mod_data = array(
      'module_name'      => 'Notepad',
      'module_version'    => $this->version,
      'has_cp_backend'    => "y",
      'has_publish_fields'  => 'n'
    );
    ee()->db->insert('modules', $mod_data);

    ee()->db->query('DROP TABLE IF EXISTS `exp_notepad_data`');
    $sql = <<<SQL
CREATE TABLE `exp_notepad_data` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
`title` varchar(255) NOT NULL,
`text` varchar(65535) NOT NULL,
`site_id` int(10) unsigned NOT NULL,
PRIMARY KEY (`id`),
KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SQL;
    ee()->db->query($sql);

    return TRUE;
  }

  // ----------------------------------------------------------------

  /**
   * Uninstall
   *
   * @return   boolean   TRUE
   */
  public function uninstall()
  {
    $mod_id = ee()->db->select('module_id')->get_where('modules', array('module_name'  => 'Notepad'))->row('module_id');
    ee()->db->where('module_id', $mod_id)->delete('module_member_groups');
    ee()->db->where('module_name', 'Notepad')->delete('modules');
    ee()->db->query('DROP TABLE IF EXISTS `exp_notepad_data`');

    return TRUE;
  }

  // ----------------------------------------------------------------

  /**
   * Module Updater
   *
   * @return   boolean   TRUE
   */
  public function update($current = '')
  {
    return TRUE;
  }

}
/* End of file upd.notepad.php */
/* Location: /system/expressionengine/third_party/notepad/upd.notepad.php */
