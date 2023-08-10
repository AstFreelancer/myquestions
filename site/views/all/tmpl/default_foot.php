<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<tr>
	<td colspan="3"><?php 
    if ($this->pagination == null || empty($this->pagination))
      $this->pagination = new JPagination($this->get('total'), $this->limitstart, $this->limit );
echo $this->pagination->getListFooter(); ?></td>
</tr>