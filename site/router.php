<?php
defined( '_JEXEC' ) or die ( 'Restricted access' );
function MyQuestionsBuildRoute(&$query)
{
	$segments = array();
    if (isset($query['view']))
	{
		$segments[] = $query['view'];
		unset($query['view']);
	}
	if (isset($query['task']))
	{
		$segments[] = $query['task'];
		unset($query['task']);
	}
	if (isset($query['id']))
	{
		$segments[] = $query['id'];
		unset($query['id']);
	}
	return $segments;
}
function MyQuestionsParseRoute ($segments)
{
	$vars = array();
	$vars['view'] = $segments[0];
	if (count($segments) > 1)
	{
   	    $vars['task'] = $segments[1];
		if (count($segments) > 2)
			$vars['id'] = $segments[2];
	}
	return $vars;
}
?>