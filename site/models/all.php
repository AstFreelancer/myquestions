<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.model' );
class ModelMyQuestionsAll extends JModelLegacy
{
	var $_categories = null;
	function getList()
	{
		if (!$this->_categories)
		{	
			$query = "SELECT id, name, `desc` FROM #__myquestions_categories";
			$this->_categories = $this->_getList($query, 0, 0);
		}
		return $this->_categories;
	}
}
?>