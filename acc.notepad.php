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
 * Notepad Accessory
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Accessory
 * @author		Steve Pedersen
 * @link		http://www.bluecoastweb.com
 */
 
class Notepad_acc {
	
	public $name			= 'Notepad';
	public $id				= 'notepad';
	public $version			= '1.0';
	public $description		= 'Notepad';
	public $sections		= array();
	
	/**
	 * Set Sections
	 */
	public function set_sections()
  {
    $add_edit_href = 'index.php?S=0&D=cp&C=addons_modules&M=show_module_cp&module=notepad';

    $results = ee()->db->query('SELECT id, title, text, updated_at FROM exp_notepad_data ORDER BY id');
    
    if ($results->num_rows() > 0) {

      foreach($results->result() as $row) {

        $this->sections[$row->title] = $row->text.'<br /><i>'.$row->updated_at.'</i> | <b><a href="'.$add_edit_href.'">Edit</a></b><br />';

      }

    }

    $this->sections['New'] = '<h3><a href="'.$add_edit_href.'">Add new note</a></h3>';
  }
	
	// ----------------------------------------------------------------
	
}
 
/* End of file acc.notepad.php */
/* Location: /system/expressionengine/third_party/notepad/acc.notepad.php */
