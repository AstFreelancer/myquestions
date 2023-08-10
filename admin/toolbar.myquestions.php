<?php
defined('_JEXEC') or die('Restricted access');
require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_myquestions'.DS.'toolbar.myquestions.html.php');
switch($task)
{
	case 'reply':
		TOOLBAR_myquestions::_REPLY();
		break;
	default:
		TOOLBAR_myquestions::_DEFAULT();
		break;
	case 'showcat':
		TOOLBAR_myquestions_categories::_DEFAULT();
		break;
	case 'addcat':
	case 'editcat':
		TOOLBAR_myquestions_categories::_NEW();
		break;
}
?>
