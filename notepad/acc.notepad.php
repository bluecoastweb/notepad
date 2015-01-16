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
 * Notepad Accessory
 *
 * @package    ExpressionEngine
 * @subpackage  Addons
 * @category  Accessory
 * @author    Steve Pedersen
 * @link    http://www.bluecoastweb.com
 */

class Notepad_acc {

  public $name      = 'Notepad';
  public $id        = 'notepad';
  public $version      = '1.0';
  public $description    = 'Store arbitrary notes in the control panel';
  public $sections    = array();
  private $_ee;
  private $_site_id;

  /**
   * Constructor
   */
  public function __construct()
  {
    $this->_ee = function_exists('ee') ? ee() : get_instance();
    $this->_site_id = $this->_ee->config->item('site_id');
  }

  /**
   * Set Sections
   */
  public function set_sections()
  {
    $vars['href'] = $this->data['base_url'] = function_exists('cp_url')
        ? cp_url('addons_modules/show_module_cp', array('module' => $this->id))
        : BASE.AMP.'C=addons_modules&amp;M=show_module_cp&amp;module='.$this->id;
    $results = $this->_ee->db->query('SELECT id, title, text FROM exp_notepad_data WHERE site_id = ? ORDER BY id', array($this->_site_id));
    if ($results->num_rows() > 0) {
      $this->_ee->load->library('typography');
      foreach($results->result() as $row) {
        $vars['text'] = $this->_ee->typography->auto_typography(auto_link($row->text, 'both', TRUE));
        $this->sections[$row->title] = $this->_ee->load->view('acc_note', $vars, true);
      }
    } else {
      $this->sections['New'] = '<b><a href="'.$vars['href'].'">Add new note</a></b>';
    }
  }

  // ----------------------------------------------------------------

}

/* End of file acc.notepad.php */
/* Location: /system/expressionengine/third_party/notepad/acc.notepad.php */
