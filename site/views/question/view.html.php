<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.view');
class QuestionViewQuestion extends JViewLegacy
{
	function display($tpl=null)
	{
		global $option;
		$model=&$this->getModel();
		$question=$model->getQuestion();
		$question->date=JHTML::Date($question->date);
 		
		$this->assignRef('question', $question);
 		$this->assignRef('option', $option);

		$this->assignRef('link_cat',JRoute::_('index.php?option='.$option.'&id='.$question->id_cat.'&view=category&task=show'));
		
 		parent::display($tpl);
	}
}
?>