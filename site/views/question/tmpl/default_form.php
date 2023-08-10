<?php
	defined( '_JEXEC' ) or die( 'Restricted access' );
	
	if (!isset($_COOKIE["vk_user_id"]))
	{
		?>
		<p><a href="https://oauth.vk.com/authorize?client_id=2347850&display=page&redirect_uri=http://mysite.ru/vk2.php&scope=email&response_type=code&v=5.62">Войти через ВКонтакте</a></p>
		<?php
	}
	else
	{
		?>
		<p>Вы вошли как <a href="https://vk.com/id<?=$_COOKIE["vk_user_id"]?>"><?=$_COOKIE["vk_first_name"]?> <?=$_COOKIE["vk_last_name"]?></a></p>
		<p><a href="http://mysite.ru/vk_logout.php">Выйти</a></p>
		<?
	}
	
?>
<form action="<?=JRoute::_('index.php')?>" method="post">
	<table>
		<tr>
			<td width="100">
				 <?php echo JText::_('COM_MYQUESTIONS_AUTHOR'); ?>:
			</td>
			<td>
				<input class="text_area" type="text" name="name" id="name" size="50" maxlength="255" value="<?=$_COOKIE["vk_first_name"]?>" />
			</td>
		</tr>	
		<tr>
			<td width="100">
				<?php echo JText::_('COM_MYQUESTIONS_CITY'); ?>:
			</td>
			<td>
				<input class="text_area" type="text" name="city" id="city" size="50" maxlength="50" value="<?=$_COOKIE["vk_city"]?>"/>
			</td>
		</tr>
		<tr>
			<td width="100">
				<?php echo JText::_('COM_MYQUESTIONS_EMAIL'); ?>:
			</td>
			<td>
				<input class="text_area" type="text" name="email" id="email" size="50" maxlength="50" value="<?=$_COOKIE["vk_email"]?>"/>
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
				<input type="checkbox" name="published" id="published" value="1" checked="checked"/>
			</td>
		</tr>
	</table>
	<input type="hidden" name="vk_photo_100" value="<?=$_COOKIE["vk_photo_100"]?>" />
	<input type="hidden" name="vk_user_id" value="<?=$_COOKIE["vk_user_id"]?>" />
	<input type="hidden" name="vk_name" value="<?=$_COOKIE["vk_first_name"]?> <?=$_COOKIE["vk_last_name"]?>" />
	<input type="hidden" name="task" value="addquestion" />
	<input type="hidden" name="option" value="<?=JRequest::getVar("option","")?>" />
	<input type="submit" class="button" id="button" value="<?php echo JText::_('COM_MYQUESTIONS_SENDBUTTON'); ?>" />
</form>