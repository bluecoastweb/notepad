<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ExpressionEngine - by EllisLab
 *
 * @package		ExpressionEngine
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2003 - 2011, EllisLab, Inc.
 * @license		http://expressionengine.com/user_guide/license.html
 * @link		http://expressionengine.com
 * @since		Version 2.0
 * @filesource
 */
 
// ------------------------------------------------------------------------

/**
 * Notepad Module Control Panel File
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Module
 * @author		Steve Pedersen
 * @link		http://www.bluecoastweb.com
 */

class Notepad_mcp {
	
	public $return_data;
	
	private $_base_url;
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->_base_url = BASE.AMP.'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=notepad';
		
		ee()->cp->set_right_nav(array(
			'module_home'	=> $this->_base_url,
			// Add more right nav items here.
		));
	}
	
	// ----------------------------------------------------------------

	/**
	 * Index Function
	 *
	 * @return 	void
	 */
	public function index()
	{
    ee()->load->library('table');
    ee()->load->helper('form');
    ee()->view->cp_page_title = lang('notepad_module_name');

    $vars['action_url'] = 'C=addons_modules'.AMP.'M=show_module_cp'.AMP.'module=notepad'.AMP.'method=update';
    $vars['form_hidden'] = null;
    $vars['notes'] = array();

    $results = ee()->db->query('SELECT id, title, text FROM exp_notepad_data');
    
    if ($results->num_rows() > 0) {
      foreach($results->result() as $row) {
        $vars['notes'][$row->id] = array(
          'id' => $row->id,
          'title' => $row->title,
          'text' => $row->text
        );
      }
    }

    return ee()->load->view('index', $vars, TRUE);
	}

	/**
	 * Start on your custom code here...
	 */

  public function update()
  {
    $data     = array();
    
    // update existing notes
    $results = ee()->db->query('SELECT id FROM exp_notepad_data ORDER BY id ASC');
    if ($results->num_rows() > 0) {
      foreach($results->result() as $row) {
        $id = $row->id;
        $title = ee()->input->post("title_$id", true);
        $text = ee()->input->post("text_$id", true);
        if ($title && $text) {
          array_push($data, array(
            'title' => $title,
            'text' => $text
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
        'text' => $text
      ));
    }

    ee()->load->dbforge();
    // delete + batch insert is easier than updating
    ee()->db->query('DELETE FROM exp_notepad_data');
    ee()->db->insert_batch('notepad_data', $data);
    ee()->session->set_flashdata('message_success', 'Notes updated');
    ee()->functions->redirect($this->_base_url);
  }
}
/* End of file mcp.notepad.php */
/* Location: /system/expressionengine/third_party/notepad/mcp.notepad.php */
