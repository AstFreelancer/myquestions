<?php
defined('_JEXEC') or die('Restricted access');
class TableQuestion extends JTable
{
	var $id = null;
	var $name = null;
	var $date = null;
	var $question = null;
	var $city = null;
	var $email = null;
	var $IP = null;
	var $id_cat = null;
	var $published = null;
	var $checked_out_time = null;
	var $senttoexpert = null;
	var $answer = null;
	var $senttoauthor = null;
	
	//vk.com
	var $vk_user_id = null;
	var $vk_name = null;
	var $vk_photo_100 = null;
	
	function __construct(&$db)
	{
		parent::__construct( '#__myquestions', 'id', $db );
	}
}
?>
