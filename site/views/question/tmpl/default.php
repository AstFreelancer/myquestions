<?php
	defined( '_JEXEC' ) or die( 'Restricted access' );
	global $option;
	echo "<a href=\"".JRoute::_('index.php?option='.$option.'&view=question&task=showform')."\">".JText::_('COM_MYQUESTIONS_ADD_QUESTION')."</a>";
?>
<table width="100%">
	<tr>
		<td><i><?=$this->question->name?></i></td>
		
		<td><i><?=JHTML::_('date', $this->question->date,JText::_('DATE_FORMAT_LC3'))?></i></td>
		<td><i><?=$this->question->city?></i></td>
	</tr>
	<tr>
		<td colspan="3"><a href="<?=$this->link_cat?>"><?=$this->question->name_cat?></a></td>
	</tr>
	<tr>
		<td colspan="3"><b><?=$this->question->question?></b></td>
	</tr>
	<tr>
		<td colspan="3"><?=$this->question->answer?></td>
	</tr>
</table>