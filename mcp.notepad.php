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
 * Notepad Module Control Panel File
 *
 * @package    ExpressionEngine
 * @subpackage  Addons
 * @category  Module
 * @author    Steve Pedersen
 * @link    http://www.bluecoastweb.com
 */

class Notepad_mcp {

  public $return_data;
  private $_base_url;
  private $_ee;
  private $_site_id;

  /**
   * Constructor
   */
  public function __construct()
  {
    $this->_base_url = BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=notepad';
    $this->_ee = function_exists('ee') ? ee() : get_instance();
    $this->_site_id = $this->_ee->config->item('site_id');
    $this->_ee->cp->set_right_nav(array('module_home' => $this->_base_url));
  }

  // ----------------------------------------------------------------

  /**
   * Index Function
   *
   * @return   void
   */
  public function index()
  {
    $this->_ee->load->library('table');
    $this->_ee->load->helper('form');
    $this->_ee->view->cp_page_title = lang('notepad_module_name');

    $vars['action_url'] = 'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=notepad'.AMP.'method=update';
    $vars['form_hidden'] = null;
    $vars['notes'] = array();

    $results = $this->_ee->db->query('SELECT id, title, text FROM exp_notepad_data WHERE site_id = ? ORDER BY id', array($this->_site_id));

    if ($results->num_rows() > 0) {
      foreach($results->result() as $row) {
        $vars['notes'][$row->id] = array(
          'id' => $row->id,
          'title' => $row->title,
          'text' => $row->text
        );
      }
    }

    return $this->_ee->load->view('mcp_index', $vars, true);
  }

  public function update()
  {
    $data     = array();

    // update existing notes
    $results = $this->_ee->db->query('SELECT id FROM exp_notepad_data WHERE site_id = ? ORDER BY id', array($this->_site_id));
    if ($results->num_rows() > 0) {
      foreach($results->result() as $row) {
        $id = $row->id;
        $title = $this->_ee->input->post("title_$id", true);
        $text = $this->_ee->input->post("text_$id", true);
        if ($title && $text) {
          array_push($data, array(
            'title' => $title,
            'text' => $text,
            'site_id' => $this->_site_id
          ));
        }
      }
    }

    // add new note
    $title = $this->_ee->input->post("title_0", true);
    $text = $this->_ee->input->post("text_0", true);
    if ($title && $text) {
      array_push($data, array(
        'title' => $title,
        'text' => $text,
        'site_id' => $this->_site_id
      ));
    }

    // delete + batch insert is easier than updating
    $this->_ee->db->query('DELETE FROM exp_notepad_data WHERE site_id = ?', array($this->_site_id));
    if (!empty($data)) {
      $this->_ee->db->insert_batch('notepad_data', $data);
    }
    $this->_ee->session->set_flashdata('message_success', 'Notes updated');
    $this->_ee->functions->redirect($this->_base_url);
  }
}
/* End of file mcp.notepad.php */
/* Location: /system/expressionengine/third_party/notepad/mcp.notepad.php */
