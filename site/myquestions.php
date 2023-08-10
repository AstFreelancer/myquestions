<?php
defined('_JEXEC') or die('Restricted access');
if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);
require_once( JPATH_COMPONENT.DS.'controller.php' );
JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_myquestions'.DS.'tables');
$controller = new QuestionController();
$controller->execute( JRequest::getVar( 'task' ) );
$controller->redirect();
?>