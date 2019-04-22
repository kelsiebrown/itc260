<?php
// application/views/news/success.php

$this->load->view($this->config->item('theme') . 'header');

?>

<h1>Success!</h1>
<p>Wouldn't it be great if we could see the new record?</p>

<?php

$this->load->view($this->config->item('theme') . 'footer');

?>