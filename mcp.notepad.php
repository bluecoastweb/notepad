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
  private $_site_id;

  /**
   * Constructor
   */
  public function __construct()
  {
    $this->_base_url = BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=notepad';

    ee()->cp->set_right_nav(array(
      'module_home'  => $this->_base_url,
    ));

    $this->_site_id = ee()->config->item('site_id');
  }

  // ----------------------------------------------------------------

  /**
   * Index Function
   *
   * @return   void
   */
  public function index()
  {
    ee()->load->library('table');
    ee()->load->helper('form');
    ee()->view->cp_page_title = lang('notepad_module_name');

    $vars['action_url'] = 'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=notepad'.AMP.'method=update';
    $vars['form_hidden'] = null;
    $vars['notes'] = array();

    $results = ee()->db->query('SELECT id, title, text FROM exp_notepad_data WHERE site_id = ? ORDER BY id', array($this->_site_id));

    if ($results->num_rows() > 0) {
      foreach($results->result() as $row) {
        $vars['notes'][$row->id] = array(
          'id' => $row->id,
          'title' => $row->title,
          'text' => $row->text
        );
      }
    }

    return ee()->load->view('mcp_index', $vars, true);
  }

  public function update()
  {
    $data     = array();

    // update existing notes
    $results = ee()->db->query('SELECT id FROM exp_notepad_data WHERE site_id = ? ORDER BY id', array($this->_site_id));
    if ($results->num_rows() > 0) {
      foreach($results->result() as $row) {
        $id = $row->id;
        $title = ee()->input->post("title_$id", true);
        $text = ee()->input->post("text_$id", true);
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
    $title = ee()->input->post("title_0", true);
    $text = ee()->input->post("text_0", true);
    if ($title && $text) {
      array_push($data, array(
        'title' => $title,
        'text' => $text,
        'site_id' => $this->_site_id
      ));
    }

    // delete + batch insert is easier than updating
    ee()->db->query('DELETE FROM exp_notepad_data WHERE site_id = ?', array($this->_site_id));
    if (!empty($data)) {
      ee()->db->insert_batch('notepad_data', $data);
    }
    ee()->session->set_flashdata('message_success', 'Notes updated');
    ee()->functions->redirect($this->_base_url);
  }
}
/* End of file mcp.notepad.php */
/* Location: /system/expressionengine/third_party/notepad/mcp.notepad.php */
