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

  /**
   * Set Sections
   */
  public function set_sections()
  {
    $vars['href'] = 'index.php?S=0&D=cp&C=addons_modules&M=show_module_cp&module=notepad';
    $results = ee()->db->query('SELECT id, title, text, updated_at FROM exp_notepad_data ORDER BY id');
    if ($results->num_rows() > 0) {
      foreach($results->result() as $row) {
        $vars['text'] = $row->text;
        $vars['date'] = $row->updated_at;
        $this->sections[$row->title] = ee()->load->view('acc_note', $vars, true);
      }
    } else {
      $this->sections['New'] = '<b><a href="'.$vars['href'].'">Add new note</a></b>';
    }
  }

  // ----------------------------------------------------------------

}

/* End of file acc.notepad.php */
/* Location: /system/expressionengine/third_party/notepad/acc.notepad.php */
