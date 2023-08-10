<?php
class HTML_questions
{
	function showCategories($rows, $option)
	{
		?>
		<p><a href='<?=JRoute::_('index.php?option='.$option.'&task=showlist')?>'><?=JText::_('COM_MYQUESTIONS_ALL_QUESTIONS')?></a></p>
		<p><a href='<?=JRoute::_('index.php?option='.$option.'&task=showform')?>'><?=JText::_('COM_MYQUESTIONS_ADD_QUESTION')?></a></p>
		<table>
		<?php
		foreach($rows as $row)
		{
			$link = JRoute::_('index.php?option='.$option.'&id='.$row->id.'&task=showlist');
			echo '<tr><td><p><a href="' . $link . '">'.$row->name.'</a></td><td>'.$row->desc.'</td></tr>';
		}
		?>
		</table>
		<?php
	}
	function showQuestions($rows, $option, $name_cat)
	{
			
		if ($name_cat !== '')
			echo "<h1>$name_cat</h1>";

		foreach($rows as $row)
		{
			$link = JRoute::_('index.php?option='.$option.'&id='.$row->id.'&task=showquestion');
			$link_cat = JRoute::_('index.php?option='.$option.'&id='.$row->id_cat.'&task=showlist');
			
			$question = str_replace('<p>','',$row->question);
			$question = str_replace('</p>','<br>',$question);
			?>
			<table width="100%">
				<tr>
					<td><i><?=$row->name?></i></td>
					<td><i><?=JHTML::_('date', $row->date,JText::_('DATE_FORMAT_LC3'))?></i></td>
					<td><i><?=$row->city?></i></td>
				</tr>
				<tr>
					<td colspan="3"><a href="<?=$link_cat?>"><?=$row->cname?></a></td>
				</tr>
				<tr>
					<td colspan="3"><strong><?=$question?></strong></td>
				</tr>
				<tr>
					<td colspan="3"><?=$row->answer?></td>
				</tr>
				<tr>
					<td colspan="3"><a style="text-decoration: none;" title="<?=JText::_('COM_MYQUESTIONS_READMORE')?>" alt="<?=JText::_('COM_MYQUESTIONS_READMORE')?>" href="<?=$link?>">---></a></td>
				</tr>
			</table>
			<br/>
			<?
		}
	}
	function showQuestion($row, $option, $row_cat)
	{
		$link_cat = JRoute::_('index.php?option='.$option.'&id='.$row->id_cat.'&task=showlist');
		?>
		<p><a href='index.php?option=<?=$option?>&task=showlist'><?=JText::_('COM_MYQUESTIONS_ALL_QUESTIONS')?></a></p>
		<table width="100%">
			<tr>
				<td><i><?=$row->name?></i></td>
				<td><i><u><?=$row->email?></u></i></td>
				<td><i><?=JHTML::_('date', $row->date,JText::_('DATE_FORMAT_LC3'))?></i></td>
				<td><i><?=$row->city?></i></td>
			</tr>
			<tr>
				<td colspan="4"><a href="<?=$link_cat?>"><?=$row_cat->name?></a></td>
			</tr>
			<tr>
				<td colspan="4"><b><?=$row->question?></b></td>
			</tr>
			<tr>
				<td colspan="4"><?=$row->answer?></td>
			</tr>
		</table>
		<?
	}
	function showForm($option, $name)
	{
		?>
		<form action="index.php" method="post">
			<table>
				<tr>
					<td width="100">
						 <?php echo JText::_('COM_MYQUESTIONS_AUTHOR'); ?>:
					</td>
					<td>
						<input class="text_area" type="text" name="name" id="name" size="50" maxlength="255" value="<?php echo $name;?>" />
					</td>
				</tr>	
				<tr>
					<td width="100">
						<?php echo JText::_('COM_MYQUESTIONS_CITY'); ?>:
					</td>
					<td>
						<input class="text_area" type="text" name="city" id="city" size="50" maxlength="50"/>
					</td>
				</tr>
				<tr>
					<td width="100">
						<?php echo JText::_('COM_MYQUESTIONS_EMAIL'); ?>:
					</td>
					<td>
						<input class="text_area" type="text" name="email" id="email" size="50" maxlength="50"/>
					</td>
				</tr>					
				<tr>
					<td width="100">
						<?php echo JText::_('COM_MYQUESTIONS_QUESTION'); ?>:
					</td>
					<td>
						<textarea name='question' id='question' class='inputbox' rows='15' cols='38'></textarea>
					</td>
				</tr>
				<tr>
					<td width="100">
						<?php echo JText::_('COM_MYQUESTIONS_PUBLISHED'); ?>:
					</td>
					<td>
						<input type="hidden" name="published" value="0"/>
						<input type="checkbox" name="published" id="published" value="1"/>
					</td>
				</tr>
			</table>
			<input type="hidden" name="task" value="addquestion" />
			<input type="hidden" name="option" value="<?php echo $option; ?>" />
			<input type="submit" class="button" id="button" value="<?php echo JText::_('COM_MYQUESTIONS_SENDBUTTON'); ?>" />
		</form>
		<?php
	}
}
?>