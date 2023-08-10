<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.controller' );
class QuestionController extends JControllerLegacy
{
	function display()
	{
		$document =& JFactory::getDocument();
		$viewName = JRequest::getVar('view', 'all');
		$viewType = $document->getType();
		$view = &$this->getView($viewName, $viewType);
		$model =& $this->getModel( $viewName, 'ModelMyQuestions' );
		if (!JError::isError( $model ))
		{
			$view->setModel( $model, true );
		}
		$view->setLayout('default');
		$view->display();
	}
	function showForm()
	{
		$document =& JFactory::getDocument();
		$viewName = JRequest::getVar('view', 'all');
		$viewType = $document->getType();
		$view = &$this->getView($viewName, $viewType);
		$model =& $this->getModel( $viewName, 'ModelMyQuestions' );
		if (!JError::isError( $model ))
		{
			$view->setModel( $model, true );
		}
		$user =&JFactory::getUser();
		if($user->name)
			$view->user_name = $user->name;
		else
			$view->user_name = '';
		echo $view->loadTemplate('form'); 
	}
	function addQuestion()
	{
		$row = & JTable::getInstance('question', 'Table');
		if (!$row->bind(JRequest::get('post')))
		{
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}
		$row->question = nl2br(htmlspecialchars(JRequest::getVar('question', '', 'post', 'string' ,JREQUEST_ALLOWRAW), ENT_QUOTES));
		$row->name = mb_substr(nl2br(htmlspecialchars($row->name, ENT_QUOTES)), 0, 255);
		$row->city = mb_substr(nl2br(htmlspecialchars($row->city, ENT_QUOTES)), 0, 50);
		$row->vk_user_id = nl2br(htmlspecialchars($row->vk_user_id, ENT_QUOTES));//лучше перестраховаться
		$row->vk_name = mb_substr(nl2br(htmlspecialchars($row->vk_name, ENT_QUOTES)), 0, 100);
		$row->vk_photo_100 = mb_substr(nl2br(htmlspecialchars($row->vk_photo_100, ENT_QUOTES)), 0, 255);	
		
		if (strlen($row->question) < 1)
		{
			echo "<script> alert('Empty question!'); window.history.go(-1); </script>\n";
			exit();
		}
		
		$pos = strpos($row->question, "http:");
		if ($pos !== false)
		{
			echo "<script> alert('Urls are not allowed!'); window.history.go(-1); </script>\n";
			exit();
		}
		
		jimport( 'joomla.mail.helper' );
		if (!JMailHelper::isEmailAddress($row->email) OR empty($row->email) OR mb_strlen($row->email)>50)
		{
			echo "<script> alert('Wrong email address!'); window.history.go(-1); </script>\n";
			exit();
		}		

		$row->IP = getenv('REMOTE_ADDR');
		$row->date = new JDate('now'); // Current date and time
		$row->date = $row->date->format('Y-m-d H:i:s');
		
		if (!$row->store())
		{
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}

		//ini_set("smtp_port", "26");
		//$mailer =& JFactory::getMailer();
		$option = JRequest::getVar('option','com_myquestions');
		$params = JComponentHelper::getParams($option);
		
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
$headers .= 'From: admin@mysite.ru';
		
		mail("admin@mail.ru","New question",JText::sprintf('COM_MYQUESTIONS_EMAIL_EXPERT_BODY',$row->question,"http://mysite.ru/administrator/index.php?option=com_myquestions&task=reply&cid[]={$row->id}"),$headers);
		/*
		$config = JFactory::getConfig();
		$sender = array($config->getValue( 'config.mailfrom' ), $config->getValue( 'config.fromname' ) );
		$mailer->setSender("admin@mysite.ru");

		//$mailer->addRecipient($sender);
		/*if ($params->get('is_direct_email_expert', 1) === '0')
		{
			$mailer->addRecipient("admin@mysite.ru");
			$mailer->setSubject(JText::_('COM_MYQUESTIONS_ADMIN_LETTER_SUBJECT'));
			$mailer->setBody(JText::sprintf('COM_MYQUESTIONS_ADMIN_LETTER_NEW_QUESTION',$row->question));
		}
		else
		{*/
			/*
			$mailer->addRecipient("admin@mail.ru");
			$row->senttoexpert = 1;
			
			$mailer->setSubject(JText::_('COM_MYQUESTIONS_NEW_QUESTION'));
			$mailer->setBody(JText::sprintf('COM_MYQUESTIONS_EMAIL_EXPERT_BODY',$row->question,"http://mysite.ru/administrator/index.php?option=com_myquestions&task=reply&cid[]={$row->id}"));
		*/
		//}
		/*
		$mailer->IsHTML(true);
		if ($mailer->Send() !== true)
		{
			echo "<script> alert('".JText::_('COM_MYQUESTIONS_ADMIN_LETTER_ERROR')."'); window.history.go(-1); </script>\n";
			exit();
		}
		*/
		//if ($params->get('is_direct_email_expert', 1) !== '0')
		//{
			//if (!$row->store())
			//{
				//echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
				//exit();
			//}
		//}
		//$this->setRedirect(JRoute::_('index.php?option='.$option.'&view=category&id=all'), JText::sprintf('COM_MYQUESTIONS_QUESTION_SENT',$row->name));
	$app = JFactory::getApplication();

			
		
		$app->redirect(JRoute::_('index.php?option='.$option.'&view=category&id=all'), JText::sprintf('COM_MYQUESTIONS_QUESTION_SENT',$row->name));
	}
}
?>
