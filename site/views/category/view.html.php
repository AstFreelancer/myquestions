<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.view');
$this->pagination = $pagination;
class QuestionViewCategory extends JViewLegacy
{
	function display($tpl=null)
	{
		global $option;
		$model=&$this->getModel();
		$list=$model->getList();
		$name_cat=$model->_getName();
		
      $pagination =& $this->get('Pagination');
      $this->assignRef('pagination', $pagination);
	  
		$is_all_cat=$model->_isAllCat();
		for ($i=0; $i<count($list); $i++)
		{
			$row=&$list[$i];
			$row->link=JRoute::_('index.php?option='.$option.'&id='.$row->id.'&view=question&task=show');
			if ($is_all_cat)
				$row->link_cat=JRoute::_('index.php?option='.$option.'&id='.$row->id_cat.'&view=category&task=show');
		}
		$this->assignRef('list', $list);
		$this->assignRef('name_cat', $name_cat);
		$this->assignRef('is_all_cat', $is_all_cat);
		parent::display($tpl);
	}
}
?>