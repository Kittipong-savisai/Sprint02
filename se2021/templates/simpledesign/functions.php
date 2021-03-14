<?php
defined('_JEXEC') or die('Restricted access');
JHtml::_('bootstrap.framework');
$user_a_count = ($this->countModules('user1')>0) + ($this->countModules('user2')>0) + ($this->countModules('user3')>0);
$user_a_floor = $user_a_count > 0 ? 'user' . floor(99 / $user_a_count) : '';
$user_b_count = ($this->countModules('user4')>0) + ($this->countModules('user5')>0) + ($this->countModules('user6')>0);
$user_b_floor = $user_b_count > 0 ? 'user' . floor(99 / $user_b_count) : '';
$user_c_count = ($this->countModules('user7')>0) + ($this->countModules('user8')>0) + ($this->countModules('user9')>0);
$user_c_floor = $user_c_count > 0 ? 'user' . floor(99 / $user_c_count) : '';
$footer_count = ($this->countModules('footer1')>0) + ($this->countModules('footer2')>0) + ($this->countModules('footer3')>0) + ($this->countModules('footer4')>0) + ($this->countModules('footer5')>0);
$footer_floor = $footer_count > 0 ? 'footer' . floor(99 / $footer_count) : '';
$app = JFactory::getApplication();
$doc = JFactory::getDocument();
$logo = $this->params->get('logo');
$sitename = $app->getCfg('sitename');
$left = $this->countModules('left');
$right = $this->countModules('right');
function getLayout ($left, $right){
if ($left && !$right) { $layout = "-left-layout"; }
if ($right && !$left) { $layout = "-right-layout"; }
if ($left && $right) { $layout = "-left-right"; }
if (!$left && !$right) { $layout = "-no-layout"; }
return $layout; }
$doc->setMetaData( 'viewport', 'width=device-width, initial-scale=1.0' );
$doc->addStyleSheet(JUri::base() . 'templates/' . $this->template . '/css/template.css', $type = 'text/css');
$doc->addScript($this->baseurl . '/templates/' . $this->template . '/js/respond.min.js', 'text/javascript');
function powered_by(){ $file = dirname(__FILE__).DIRECTORY_SEPARATOR.'index.php'; $links = 'www.primerthemes.com'; $filedata = fopen($file,'r'); $cheaklink=fread($filedata,filesize($file)); fclose($filedata); if(strpos($cheaklink, $links)==0){ echo '<br><center>Template by www.primerthemes.com</center>'; die; } } powered_by();
?>