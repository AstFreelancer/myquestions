<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.view');
jimport('joomla.html.pagination');
class QuestionViewAll extends JViewLegacy
{
	function display($tpl=null)
	{
		global $option;
		$model=&$this->getModel();
		$list=$model->getList();
		$pagination = $this->get('Pagination');
		for ($i=0; $i<count($list); $i++)
		{
			$row=&$list[$i];
			$row->link=JRoute::_('index.php?option='.$option.'&id='.$row->id.'&view=category&task=show');
		}
		$this->assignRef('list', $list);
		$this->pagination = $pagination;
\		parent::display($tpl);
	}
}
?> 