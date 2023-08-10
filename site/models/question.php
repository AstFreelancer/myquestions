<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.model' );
class ModelMyQuestionsQuestion extends JModelLegacy
{
	var $_question = null;
	var $_id = null;
	function __construct()
	{
		parent::__construct();
		$id = JRequest::getVar('id',0);
		$this->_id = $id;
	}
	function getQuestion()
	{
		if (!$this->_question)
		{
			$query = "SELECT q.id, q.question, q.name, q.date, q.email, q.city, q.answer, q.published, q.checked_out_time, c.id AS id_cat, c.name AS name_cat FROM #__myquestions q, #__myquestions_categories c WHERE q.id_cat=c.id AND q.id = {$this->_id}";
			$this->_db->setQuery($query);
			$this->_question = $this->_db->loadObject();
			if ($this->_question->answer == '' || ($this->_question->published == 0 && ($this->_question->checked_out_time == '0000-00-00 00:00:00' || strtotime($this->_question->checked_out_time) <= time())))
			{
				JError::raiseError ( 404, "Invalid ID provided" );
			}
		}
		return $this->_question;
	}
}
?>