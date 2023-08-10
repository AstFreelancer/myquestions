<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.model' );
class ModelMyQuestionsCategory extends JModelLegacy
{
	var $_questions = null;
	var $_id = null;
	var $_name = null;
	var $_total = null;
	var $_pagination = null;
	function __construct()
	{
		parent::__construct();
		$id = JRequest::getVar('id','all');
		$this->_id = $id;
		
		global $option;
		
		$app = JFactory::getApplication();
 
      // Получаем переменные для постраничной навигации
      $limit = $app->getUserStateFromRequest('global.list.limit', 'limit', $app->getCfg('list_limit'), 'int');
      $limitstart = JRequest::getVar('limitstart', 0, '', 'int');
 
      // In case limit has been changed, adjust it
      $limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);
 
      $this->setState('limit', $limit);
      $this->setState('limitstart', $limitstart);
	}
	function getList()
	{
		if (!$this->_questions)
		{
			if ($this->_isAllCat())
				$id_text = "";
			else
				$id_text = " id_cat={$this->_id} AND ";
			$query = "SELECT q.id, q.question, q.name, q.date, q.email, q.city, q.answer, c.id AS id_cat, c.name AS name_cat FROM #__myquestions q, #__myquestions_categories c WHERE $id_text answer <> '' AND (published = 1 OR (checked_out_time <> '0000-00-00 00:00:00' AND checked_out_time > NOW())) AND q.id_cat=c.id ORDER BY q.date DESC";
			$this->_questions = $this->_getList($query,$this->getState('limitstart'), $this->getState('limit'));	
		}
		return $this->_questions;
	}
	function _getName()
	{
		if (!$this->_name)
		{
			if (!$this->_isAllCat())
			{
				$query = "SELECT name FROM #__myquestions_categories WHERE id = '" . $this->_id . "'";
				$this->_db->setQuery($query);
				$this->_name = $this->_db->loadResult();
			}
		}
		if (!$this->_isAllCat())
			return $this->_name;
		else
			return JText::_('COM_MYQUESTIONS_ALL_QUESTIONS');
	}
	function _isAllCat()
	{
		if ($this->_id=='all')
			return true;
		return false;
	}
	function getTotal()
{
      // Load the content if it doesn't already exist
      if (empty($this->_total)) {
          $query = "SELECT q.id, q.question, q.name, q.date, q.email, q.city, q.answer, c.id AS id_cat, c.name AS name_cat FROM #__myquestions q, #__myquestions_categories c WHERE $id_text answer <> '' AND (published = 1 OR (checked_out_time <> '0000-00-00 00:00:00' AND checked_out_time > NOW())) AND q.id_cat=c.id";
          $this->_total = $this->_getListCount($query);   
      }
      return $this->_total;
}
function getPagination()
{
      // Load the content if it doesn't already exist
      if (empty($this->_pagination)) {
          jimport('joomla.html.pagination');
          $this->_pagination = new JPagination($this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
      }
      return $this->_pagination;
}
}
?>