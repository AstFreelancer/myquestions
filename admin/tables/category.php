<?php
defined('_JEXEC') or die('Restricted access');
class TableCategory extends JTable
{
	var $id = null;
	var $name = null;
	var $desc = null;

	function __construct(&$db)
	{
		parent::__construct( '#__myquestions_categories', 'id', $db );
	}
}
?>