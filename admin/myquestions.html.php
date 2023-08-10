<?php
defined ('_JEXEC' ) or die ('Restricted access');
/*function addToolbar()
		{
	//	JRequest::setVar('hidemainmenu', true);
		
		JToolBarHelper::title(JText::_('COM_MYQUESTIONS_TOOLBAR_TITLE'), 'generic.png');
		JToolBarHelper::custom( 'sendToExpert', 'send.png', '', 'COM_MYQUESTIONS_TOOLBAR_SEND_TO_EXPERT', false );
		JToolBarHelper::custom( 'sendAnswer', 'send.png', '', 'COM_MYQUESTIONS_TOOLBAR_SEND_ANSWER', false );
		JToolBarHelper::save();
		JToolBarHelper::apply();
		JToolBarHelper::cancel();	
		}*/
/*function addDefaultToolbar()
{
		JToolBarHelper::title(JText::_('COM_MYQUESTIONS_TOOLBAR_TITLE'), 'generic.png');
		JToolBarHelper::editList('reply','COM_MYQUESTIONS_REPLY');
		JToolBarHelper::deleteList('','removeQuestions');
		JToolBarHelper::divider();
		JToolBarHelper::preferences('com_myquestions');
}*/
	function showQuestionsFromEMail($email, $id, $limit)
	{
		$app = &JFactory::getApplication();

		$db =& JFactory::getDbo();
		$query = "SELECT * FROM #__myquestions WHERE email='$email' AND id <> $id ORDER BY date DESC";
		$db->setQuery( $query, 0, $limit );
		$rows = $db->loadObjectList();
		if ($db->getErrorNum())
		{
			echo $db->stderr();
			$db->__destruct();
			return false;
		}
		//$db->__destruct();
		return $rows;
	}
	function showQuestionsFromVkUserId($vk_user_id, $id, $limit)
	{
		$app = &JFactory::getApplication();

		$db =& JFactory::getDbo();
		$query = "SELECT * FROM #__myquestions WHERE vk_user_id='$vk_user_id' AND id <> $id ORDER BY date DESC";
		$db->setQuery( $query, 0, $limit );
		$rows = $db->loadObjectList();
		if ($db->getErrorNum())
		{
			echo $db->stderr();
			$db->__destruct();
			return false;
		}
		//$db->__destruct();
		return $rows;
	}
class HTML_questions
{	
	function replyToQuestion ($row, $option, $list_cat)
	{
		$editor = & JFactory::getEditor();
		//addToolbar();
		?>
		<form action = "index.php" method="post" name="adminForm" id="adminForm">
			<fieldset class="adminform">
				<table class="admintable" width=100%>
					<tr>
						<td width="100" class="key">
							 <?php echo JText::_('COM_MYQUESTIONS_AUTHOR'); ?>:
						</td>
						<td>
							<input class="text_area" type="text" name="name" id="name" size="50" maxlength="255" value="<?php echo $row->name;?>" />
						</td>
					</tr>
						<?php
								if ($row->vk_user_id !== null)
								{
									?>
					<tr>
						<td width="100" class="key">
							 Профиль ВКонтакте:
						</td>
						<td width="100" class="key">
							<a href="https://vk.com/id<?=$row->vk_user_id?>" target="_blank"><?=$row->vk_name?></a>
							<br>
							<a href="https://vk.com/id<?=$row->vk_user_id?>" target="_blank"><img src="<?=$row->vk_photo_100?>"></a>
									<?php
								}
							?>
						</td>
					</tr>
					<tr>
						<td width="100" class="key">
							<?php echo JText::_('COM_MYQUESTIONS_DATE'); ?>:
						</td>
						<td>
							<span class="text_area" type="text" name="date" id="date"><?php echo JHTML::_('date', $row->date,JText::_('DATE_FORMAT_LC3'));?></span>
						</td>
					</tr>					
					<tr>
						<td width="100" class="key">
							<?php echo JText::_('COM_MYQUESTIONS_QUESTION'); ?>:
						</td>
						<td>
							<?php
								echo $editor->display('question',  $row->question ,'100%', '250', '40', '10'); ?>
						</td>
					</tr>
					<tr>
						<td width="100" class="key">
							<?php echo JText::_('COM_MYQUESTIONS_CITY'); ?>:
						</td>
						<td>
							<input class="text_area" type="text" name="city" id="city" size="50" maxlength="50" value="<?php echo $row->city; ?>" />
						</td>
					</tr>
					<tr>
						<td width="100" class="key">
							<?php echo JText::_('COM_MYQUESTIONS_EMAIL'); ?>:
						</td>
						<td>
							<input class="text_area" type="text" name="email" id="email" size="50" maxlength="50" value="<?php echo $row->email; ?>" />
						</td>
					</tr>
					<tr>
						<td width="100" class="key">
							<?php echo JText::_('COM_MYQUESTIONS_IP'); ?>:
						</td>
						<td>
							<span class="text_area" type="text" name="IP" id="IP"><?php echo $row->IP; ?></span>
						</td>
					</tr>
					<tr>
					<tr>
						<td width="100" class="key">
							<?php echo JText::_('COM_MYQUESTIONS_CATEGORY'); ?>:
						</td>
						<td>
							<?=$list_cat?>
						</td>
					</tr>
					<tr>
						<td width="100" class="key">
							<?php echo JText::_('COM_MYQUESTIONS_PUBLISHED'); ?>:
						</td>
						<td valign="top">
							<?php
								if ($row->published == '1')
									echo JText::_('JYES');
								else
									echo JText::_('JNO'); ?>
						</td>
					</tr>
					<tr>
						<td width="100" class="key">
							<?php echo JText::_('COM_MYQUESTIONS_CHECKED_OUT_TIME'); ?>:
						</td>
						<td>
							<?php echo JHTML::_('calendar', $row->checked_out_time, 'checked_out_time', 'checked_out_time', '%Y-%m-%d');?>
						</td>
					</tr>
					<tr>
						<td width="100" class="key">
							<?php echo JText::_('COM_MYQUESTIONS_SENTTOEXPERT'); ?>:
						</td>
						<td valign="top">
							<?php
								if ($row->senttoexpert == '1')
									echo JText::_('JYES');
								else
									echo JText::_('JNO'); ?>
						</td>
					</tr>
					<tr>
						<td width="100" class="key">
							<?php echo JText::_('COM_MYQUESTIONS_ANSWER'); ?>:
						</td>
						<td>
							<?php
								echo $editor->display('answer',  $row->answer ,'100%', '250', '40', '10'); ?>
						</td>
					</tr>
					<tr>
						<td width="100" class="key">
							<?php echo JText::_('COM_MYQUESTIONS_SENTTOAUTHOR'); ?>:
						</td>
						<td valign="top">
								<?php
								if ($row->senttoauthor == '1')
									echo JText::_('JYES');
								else
									echo JText::_('JNO'); ?>
						</td>
					</tr>
					<tr>
						<td width="100" class="key">
							<?php echo JText::_('COM_MYQUESTIONS_OLD_QUESTIONS_FROM_THIS_EMAIL'); ?>:
						</td>
						<td valign="top">
								<?php
									$rows = showQuestionsFromEMail($row->email, $row->id, 3);
									foreach ($rows as $r)
										echo '<p><a href="'.JFilterOutput::ampReplace('index.php?option=' .$option . '&task=reply&cid[]='. $r->id ).'"><b>'.$r->name.'</b> <small><i>'.JHTML::_('date', $r->date, JText::_('DATE_FORMAT_LC3')).'</i></small> '.strip_tags($r->question).'</a></p>';
								?>
						</td>
					</tr>
					<?php
						if ($row->vk_user_id !== null && $row->vk_user_id !== 0 && $row->vk_user_id !== '0')
						{
							
						?>
					<tr>
						<td width="100" class="key">
							Другие вопросы от этого пользователя ВКонтакта:
						</td>
						<td valign="top">
								<?php
									$rows = showQuestionsFromVkUserId($row->vk_user_id, $row->id, 3);
									foreach ($rows as $r)
										echo '<p><a href="'.JFilterOutput::ampReplace('index.php?option=' .$option . '&task=reply&cid[]='. $r->id ).'"><b>'.$r->name.'</b> <small><i>'.JHTML::_('date', $r->date, JText::_('DATE_FORMAT_LC3')).'</i></small> '.strip_tags($r->question).'</a></p>';
								?>
						</td>
					</tr>
						<?php
						}
						?>						
				</table>
			</fieldset>
			<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
			<input type="hidden" name="option" value="<?php echo $option;?>" />
			<input type="hidden" name="task" value="" />
		</form>
	<?php
	}
			
	function showQuestions( $option, &$rows, &$pageNav )
	{ 
	//addDefaultToolbar();
		$maxlen = 100;
		$params = JComponentHelper::getParams($option);
	?>
		<form action="index.php" method="post" name="adminForm" id="adminForm">
			<table class="adminlist">
				<thead>
					<tr>
						<th width="20">
							<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows ); ?>);" />
						</th> 				
						<th class="title"><?php echo JText::_('COM_MYQUESTIONS_AUTHOR').'<br>'.JText::_('COM_MYQUESTIONS_EMAIL'); ?></th>
						<th><?php echo JText::_('COM_MYQUESTIONS_DATE'); ?></th>
						<th><?php echo JText::_('COM_MYQUESTIONS_QUESTION'); ?></th>
						
						<th><?php echo JText::_('COM_MYQUESTIONS_PUBLISHED'); ?></th>
						
						<?php 
							if ($params->get('is_direct_email_expert', 1) === '0')
								echo "<th>".JText::_('COM_MYQUESTIONS_SENTTOEXPERT')."</th>";
						?>
						<th><?php echo JText::_('COM_MYQUESTIONS_ANSWER'); ?></th>
						<th><?php echo JText::_('COM_MYQUESTIONS_SENTTOAUTHOR'); ?></th>			
					</tr>
				</thead> 
				<?php
					jimport('joomla.filter.output');
					$k = 0; 			
					for  ($i = 0,  $n = count( $rows ); $i < $n;  $i ++) 			
					{
						$row = &$rows[$i];
						$checked = JHTML::_('grid.id', $i, $row->id );
						$link = JFilterOutput::ampReplace('index.php?option=' .$option . '&task=reply&cid[]='. $row->id );
				?>
				<tr class="<?php echo "row$k"; ?>">
					<td><?=$checked?></td>
					<td><?=$row->name?><br><?=$row->email?></td>
					<td><?=JHTML::_('date', $row->date, JText::_('DATE_FORMAT_LC3'))?></td>
					<td><?='<a href="'.$link.'">'.substr(strip_tags($row->question),0,$maxlen-1).'</a>'?></td>
				
					<td align="center">
						<?php
							echo JHtml::_('jgrid.published', $row->published, $i, 'myquestions.', false);
						?>
					</td>
					
					<?php 
						if ($params->get('is_direct_email_expert', 1) === '0')
							echo "<td align=\"center\">".JHtml::_('jgrid.published', $row->senttoexpert, $i, 'myquestions.', false)."</td>";
					?>
						
					<td><?=substr(strip_tags($row->answer),0,$maxlen-1)?></td>
					<td align="center">
						<?php
							echo JHtml::_('jgrid.published', $row->senttoauthor, $i, 'myquestions.', false);
						?>
					</td>
				</tr>
				<?php
					$k = 1 - $k;
				}
				?>
				<tfoot>
					<td colspan="10">
						<?php echo $pageNav->getListFooter(); ?>
					</td>
				</tfoot> 
			</table>
			<input type="hidden" name="option" value="<?php echo $option;?>" />
			<input type="hidden" name="task" value="" />
			<input type= "hidden" name="boxchecked" value="0" />
		</form>
	<?php
	}
	function showCategories( $option, &$rows ) 
	{ 
	?>
		<form action="index.php" method="post" name="adminForm">
			<table class="adminlist">
				<thead>
					<tr>
						<th width="20">
							<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows ); ?>);" />
						</th>
						<th class="title" width="30%"><?php echo JText::_('COM_MYQUESTIONS_CATEGORY_NAME'); ?></th>
						<th><?php echo JText::_('COM_MYQUESTIONS_CATEGORY_DESC'); ?></th>
					</tr>
				</thead> 
				<?php
					jimport('joomla.filter.output');
					$k = 0; 			
					for  ($i = 0,  $n = count( $rows ); $i < $n;  $i ++) 			
					{
						$row = &$rows[$i];
						$checked = JHTML::_('grid.id', $i, $row->id );
						$link = JFilterOutput::ampReplace('index.php?option=' .$option . '&task=editcat&cid[]='. $row->id );
				?>
				<tr class="<?php echo "row$k"; ?>">
					<td><?=$checked?></td>
					<td><?='<a href="'.$link.'">'.$row->name.'</a>'?></td>
					<td><?=$row->desc?></td>
				</tr>
				<?php
					$k = 1 - $k;
				}
				?>
			</table>
			<input type="hidden" name="option" value="<?php echo $option;?>" />
			<input type="hidden" name="task" value="" />
			<input type= "hidden" name="boxchecked" value="0" />
		</form>
	<?php
	}
	function editCategory ($row, $option)
	{
		$editor = & JFactory::getEditor();
		?>
		<form action = "index.php" method="post" name="adminForm" id="adminForm">
			<fieldset class="adminform">
				<table class="admintable" width=100%>
					<tr>
						<td width="100" class="key">
							 <?php echo JText::_('COM_MYQUESTIONS_CATEGORY_NAME'); ?>:
						</td>
						<td>
							<input class="text_area" type="text" name="name" id="name" size="50" maxlength="255" value="<?php echo $row->name;?>" />
						</td>
					</tr>
					<tr>
						<td width="100" class="key">
							<?php echo JText::_('COM_MYQUESTIONS_CATEGORY_DESC'); ?>:
						</td>
						<td>
							<?php
								echo $editor->display('desc',  $row->desc,'100%', '250', '40', '10'); ?>
						</td>
					</tr>
				</table>
			</fieldset>
			<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
			<input type="hidden" name="option" value="<?php echo $option;?>" />
			<input type="hidden" name="task" value="" />
		</form>
	<?php
	}
}
?>