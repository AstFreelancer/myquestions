<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
global $option;
echo "<strong><i>Прием новых вопросов закрыт.</i></strong>";
//echo "<strong><i><a href=\"".JRoute::_('index.php?option='.$option.'&view=question&task=showform')."\">".JText::_('COM_MYQUESTIONS_ADD_QUESTION')."</a></i></strong>";
?>
<H1><?=$this->name_cat?></H1>
<?php foreach($this->list as $l): ?>
	<table width="100%">
		<tr>
			<td width="30%"><i><?=$l->name?></i></td>
			<td width="35%"><i><?=JHTML::_('date', $l->date,JText::_('DATE_FORMAT_LC3'))?></i></td>
			<td width="35%"><i><?=$l->city?></i></td>
		</tr>
		<?php
			if ($this->is_all_cat == true)
			{
		?>
		<tr>
			<td colspan="3"><a href="<?=$l->link_cat?>"><?=$l->name_cat?></a></td>			
		</tr>
		<?php
			}
		?>
		<tr>
			<td colspan="3"><strong><?php
									echo str_replace('</p>','<br>',str_replace('<p>','',$l->question));
									?></strong></td>
		</tr>
		<tr>
			<td colspan="3"><?=$l->answer?></td>
		</tr>
		<tr>
			<td colspan="3"><a style="text-decoration: none;" title="<?=JText::_('COM_MYQUESTIONS_READMORE')?>" alt="<?=JText::_('COM_MYQUESTIONS_READMORE')?>" href="<?=$l->link?>">---></a></td>
		</tr>
	</table>
	<br/>
<?php endforeach; ?>
<div class="pagination">
<?php echo $this->pagination->getListFooter(); ?>
</div>