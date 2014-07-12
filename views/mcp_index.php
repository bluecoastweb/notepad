<?php 

echo form_open($action_url);
$this->table->set_template($cp_table_template);
$this->table->set_heading('', 'Title', 'Text');
foreach($notes as $id => $data) {
    $this->table->add_row(
        '<h4>Edit</h4>',
        form_input("title_$id", $data['title']),
        form_textarea(array('name' => "text_$id", 'value' => $data['text'], 'rows' => '6'))
    );
}
$this->table->add_row(
    '<h4>Add New</h4>',
    form_input('title_0', null),
    form_textarea(array('name' => 'text_0', 'value' => null, 'rows' => '6'))
);
echo $this->table->generate();
echo form_submit(array('name' => 'submit', 'value' => 'Update', 'class' => 'submit'));
echo form_close();

/* End of file upd.notepad.php */
/* Location: /system/expressionengine/third_party/notepad/views/mcp_index.php */
