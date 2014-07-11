<?php 

echo form_open($action_url);
$this->table->set_template($cp_table_template);
$this->table->set_heading('Title', 'Text');
foreach($notes as $id => $data) {
    $this->table->add_row(
        form_input("title_$id", $data['title']),
        form_textarea("text_$id", $data['text'])
    );
}
$this->table->add_row(
    form_input('title_0', null),
    form_textarea('text_0', null)
);
echo $this->table->generate();
echo form_submit(array('name' => 'submit', 'value' => 'Update', 'class' => 'submit'));
echo form_close();

?>
