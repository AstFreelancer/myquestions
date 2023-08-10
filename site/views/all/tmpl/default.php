<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
global $option;
echo "<a href=\"".JRoute::_('index.php?option='.$option.'&view=question&task=showform')."\">".JText::_('COM_MYQUESTIONS_ADD_QUESTION')."</a>";
?>
<br />
<table width="100%">
	<?php
		foreach($this->list as $l)
			echo '<tr><td><p><a href="'.$l->link.'">'.$l->name.'</a></td><td>'.$l->desc.'</td></tr>';
	?>
</table>
		<div class="pagination">
				<p class="counter pull-right"> <?php 
echo $this->pagination->getPagesCounter(); ?> </p>
			<?php echo $this->pagination->getPagesLinks(); ?> </div>

<br/>