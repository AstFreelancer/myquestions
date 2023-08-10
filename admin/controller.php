<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.controller' );

class QuestionController extends JControllerLegacy
{
	function __construct( $default = array() )
	{
		parent::__construct( $default );
		
		$this->registerTask( 'reply' , 'replyToQuestion' );
		$this->registerTask( 'save', 'saveQuestion' );
		$this->registerTask( 'apply', 'saveQuestion' );
		$this->registerTask( 'remove', 'removeQuestions' );
		$this->registerTask( 'sendToExpert', 'send' );
		$this->registerTask( 'sendAnswer', 'send' );
		
		$this->registerTask( 'showCat', 'showCategories' );
		$this->registerTask( 'addCat', 'editCategory' );
		$this->registerTask( 'editCat', 'editCategory' );
		$this->registerTask( 'saveCat', 'saveCategory' );
		$this->registerTask( 'applyCat', 'saveCategory' );
		$this->registerTask( 'removeCat', 'removeCategories' );
	}
	function replyToQuestion()
	{
		$option = JRequest::getVar( 'option');
		$row =& JTable::getInstance('Question','Table');
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		$id = $cid[0];
		$row->load($id);
		$db = &JFactory::getDBO();
		$query = 'SELECT name AS text, id AS value FROM #__myquestions_categories';
		$db->setQuery( $query );
		$categories = $db->loadObjectList();
		$list_cat = JHTML::_('select.genericlist',  $categories,  'id_cat', ' class="inputbox" ', 'value', 'text', $row->id_cat );
		HTML_questions::replyToQuestion($row, $option, $list_cat);
		//$db->__destruct();
	}

	function save()
	{
		$row = & JTable::getInstance('question', 'Table');
		if (!$row->bind(JRequest::get('post')))
		{
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}
		$row->question = JRequest::getVar( 'question', '', 'post', 'string', JREQUEST_ALLOWRAW );
		$row->answer = JRequest::getVar( 'answer', '', 'post', 'string', JREQUEST_ALLOWRAW );

		if (!$row->store())
		{
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}
		
		return $row;
	}
	function saveQuestion()
	{
		$app = JFactory::getApplication();
		$option = JRequest::getVar( 'option');
		$task = JRequest::getVar( 'task');
		$row = $this->save();
		if (strlen(trim($row->answer)) > 0 && $row->senttoauthor == 0)
		{
			//ini_set("smtp_port", "26");
			
			$q = $row->question;
			$a = $row->answer;
		
			$config = JFactory::getConfig();
			$sender = array( 
			$config->get( 'config.mailfrom' ),
			$config->get( 'config.fromname' ) );
		
			$mailer =& JFactory::getMailer();
			$mailer->setSender($sender);
			$params = JComponentHelper::getParams($option);
			//$mailer->setSender($params->get('email_admin','admin@mysite.ru'));
			
			$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$headers .= 'From: admin@mysite.ru';// . "\r\n";
		//$headers .= 'Bcc: admin@mysite.ru';
			
		$recipient = $row->email;
			//$subject = JText::_('COM_MYQUESTIONS_NEW_ANSWER');
			$subject = "Answer to your question";
			$body = JText::sprintf('COM_MYQUESTIONS_EMAIL_USER_BODY',$q,$a);
			
			if (mail($row->email, $subject, $body, $headers) !== true)		
		//if ($mailer->Send() !== true)
			$message = 'COM_MYQUESTIONS_EMAIL_ERROR';
		else
		{
			$message = 'COM_MYQUESTIONS_EMAIL_SUCCESS';
			
			mail("admin@mail.ru", $subject, $body, $headers);
			
			$db =& JFactory::getDbo();
			
				$query = "UPDATE #__myquestions SET senttoauthor=1 WHERE id={$row->id}";
			
			$db->setQuery( $query );
			$db->query();
			if ($db->getErrorNum())
			{
				echo $db->stderr();
				$db->__destruct();
				return false;
			}
			//$db->__destruct();
		}
		}		
		
		if ($task == 'save')
			$app->redirect('index.php?option='.$option, JText::_('COM_MYQUESTIONS_REPLY_SAVED'));
		else
			if ($task == 'apply')
				$app->redirect('index.php?option='.$option.'&task=reply&cid[]='.$row->id, JText::_('COM_MYQUESTIONS_REPLY_SAVED'));
	}
	function showQuestions()
	{
		$option = JRequest::getVar( 'option');
		$app = JFactory::getApplication();
		$limit = JRequest::getVar('limit', $app->getCfg('list_limit'));
		$limitstart = JRequest::getVar('limitstart', 0);

		$db =& JFactory::getDbo();
		$query = "SELECT count(*) FROM #__myquestions";
		$db->setQuery( $query );
		$total = $db->loadResult();

		$query = "SELECT * FROM #__myquestions ORDER BY date DESC";
		$db->setQuery( $query, $limitstart, $limit );
		$rows = $db->loadObjectList();
		if ($db->getErrorNum())
		{
			echo $db->stderr();
			$db->__destruct();
			return false;
		}
		jimport('joomla.html.pagination');
		$pageNav = new JPagination($total, $limitstart, $limit);
		HTML_questions::showQuestions( $option, $rows, $pageNav );
		//$db->__destruct();
	}
	function removeQuestions()
	{	
		$cid = JFactory::getApplication()->input->get('cid', array(), 'array');
		$db =& JFactory::getDbo();
		if(count($cid))
		{
			$cids = implode( ',', $cid );
			$query = "DELETE FROM #__myquestions WHERE id IN ( $cids)";
			$db->setQuery( $query );
			if ( !$db->query() )
			{
				echo "<script> alert('".$db->getErrorMsg()."'); window.history.go(-1); </script>\n"; 
			}
		}
		$option = JRequest::getVar( 'option');
		JFactory::getApplication()->redirect( 'index.php?option=' . $option, JText::_('COM_MYQUESTIONS_QUESTION_DELETED') );
		//$db->__destruct();
		
	}
	function send()
	{
		//ini_set("smtp_port", "26");
			
		$option = JRequest::getVar( 'option');
		$task = JRequest::getVar( 'task');
		$row_new = $this->save();
		$q = $row_new->question;
		$a = $row_new->answer;
		
		$config = JFactory::getConfig();
		$sender = array( 
		$config->getValue( 'config.mailfrom' ),
		$config->getValue( 'config.fromname' ) );
		
		//$mailer =& JFactory::getMailer();
		//$mailer->setSender($sender);
		$params = JComponentHelper::getParams($option);
		//$mailer->setSender($params->get('email_admin','admin@mysite.ru'));
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$headers .= 'From: admin@mysite.ru'; 
		$headers .= 'Bcc: admin@mysite.ru';
		
		if ($task == 'sendToExpert')
		{
		/*	$mailer->addRecipient($params->get('email_expert','admin@mail.ru'));
			$mailer->setSubject(JText::_('COM_MYQUESTIONS_NEW_QUESTION'));
			$mailer->setBody(JText::sprintf('COM_MYQUESTIONS_EMAIL_EXPERT_BODY',$q,"http://mysite.ru/administrator/index.php?option=com_myquestions&task=reply&cid[]={$row_new->id}"));*/
	
			$recipient = "admin@mail.ru";
			$subject = JText::_('COM_MYQUESTIONS_NEW_QUESTION');
			$body = JText::sprintf('COM_MYQUESTIONS_EMAIL_EXPERT_BODY',$q,"http://mysite.ru/administrator/index.php?option=com_myquestions&task=reply&cid[]={$row_new->id}");
			
			
			if (mail("admin@mail.ru", $subject, $body, $headers) !== true)		
		//if ($mailer->Send() !== true)
			$message = 'COM_MYQUESTIONS_EMAIL_ERROR';
		else
		{
			$message = 'COM_MYQUESTIONS_EMAIL_SUCCESS';
			
			$db =& JFactory::getDbo();
			if ($task == 'sendToExpert')
				$query = "UPDATE #__myquestions SET senttoexpert=1 WHERE id={$row_new->id}";
			else
				$query = "UPDATE #__myquestions SET senttoauthor=1 WHERE id={$row_new->id}";
			
			$db->setQuery( $query );
			$db->query();
			if ($db->getErrorNum())
			{
				echo $db->stderr();
				$db->__destruct();
				return false;
			}
			//$db->__destruct();
		}
		
		}
		else
		{
			/*$mailer->addRecipient($row_new->email);
			$mailer->setSubject(JText::_('COM_MYQUESTIONS_NEW_ANSWER'));
			$mailer->setBody(JText::sprintf('COM_MYQUESTIONS_EMAIL_USER_BODY',$q,$a));*/
			
			$recipient = $row_new->email;
			$subject = JText::_('COM_MYQUESTIONS_NEW_ANSWER');
			$body = JText::sprintf('COM_MYQUESTIONS_EMAIL_USER_BODY',$q,$a);
			
			if (mail($row_new->email, $subject, $body, $headers) !== true)		
		//if ($mailer->Send() !== true)
			$message = 'COM_MYQUESTIONS_EMAIL_ERROR';
		else
		{
			$message = 'COM_MYQUESTIONS_EMAIL_SUCCESS';
			
			$db =& JFactory::getDbo();
			if ($task == 'sendToExpert')
				$query = "UPDATE #__myquestions SET senttoexpert=1 WHERE id={$row_new->id}";
			else
				$query = "UPDATE #__myquestions SET senttoauthor=1 WHERE id={$row_new->id}";
			
			$db->setQuery( $query );
			$db->query();
			if ($db->getErrorNum())
			{
				echo $db->stderr();
				$db->__destruct();
				return false;
			}
			//$db->__destruct();
		}
		}
		//$mailer->IsHTML(true);
		
		
		$app = JFactory::getApplication();
		$app->redirect( 'index.php?option='.$option.'&task=reply&cid[]='.$row_new->id, JText::_($message) );
	}
	function showCategories()
	{
		$option = JRequest::getVar( 'option');
		$db =& JFactory::getDbo();
		$query = "SELECT * FROM #__myquestions_categories";
		$db->setQuery( $query );
		$rows = $db->loadObjectList();
		if ($db->getErrorNum())
		{
			echo $db->stderr();
			$db->__destruct();
			return false;
		}
		HTML_questions::showCategories( $option, $rows );
		//$db->__destruct();
	}
	function editCategory()
	{
		$option = JRequest::getVar( 'option');
		$row =& JTable::getInstance('Category','Table');
		$cid = JRequest::getVar( 'cid', array(0), '', 'array' );
		$id = $cid[0];
		$row->load($id);
		HTML_questions::editCategory($row, $option);
	}
	function saveCategory($option, $task)
	{
		$option = JRequest::getVar( 'option');
		$task = JRequest::getVar( 'task');
		$row = & JTable::getInstance('category', 'Table');
		if (!$row->bind(JRequest::get('post')))
		{
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}
		$row->desc = JRequest::getVar( 'desc', '', 'post', 'string', JREQUEST_ALLOWRAW );

		if (!$row->store())
		{
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}
		
		$app = JFactory::getApplication();
		if ($task == 'savecat')
			$app->redirect('index.php?option='.$option.'&task=showcat', JText::_('COM_MYQUESTIONS_CATEGORY_SAVED'));
		else
			if ($task == 'applycat')
				$app->redirect('index.php?option='.$option.'&task=editcat&cid[]='.$row->id, JText::_('COM_MYQUESTIONS_CATEGORY_SAVED'));
	}
	function removeCategories()
	{
		$app = JFactory::getApplication();
		$option = JRequest::getVar( 'option');
		$cid = JRequest::getVar( 'cid', array(), '', 'array' );
		$db =& JFactory::getDbo();
		if(count($cid))
		{
			$cids = implode( ',', $cid );
			$query = "DELETE FROM #__myquestions_categories WHERE id IN ( $cids)";
			$db->setQuery( $query );
			if ( !$db->query() )
			{
				echo "<script> alert('".$db->getErrorMsg()."'); window.history.go(-1); </script>\n"; 
			}
		}
		$app->redirect( 'index.php?option=' . $option . '&task=showcat', JText::_('COM_MYQUESTIONS_CATEGORY_DELETED') );
		//$db->__destruct();
	}
}
?>