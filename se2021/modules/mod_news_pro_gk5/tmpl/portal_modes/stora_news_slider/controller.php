<?php

/**
* New News Header
* @package News Show Pro GK5
* @Copyright (C) 2009-2015 Gavick.com
* @ All rights reserved
* @ Joomla! is Free Software
* @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
* @version $Revision: GK5 1.9.2 $
**/

// access restriction
defined('_JEXEC') or die('Restricted access');

class NSP_GK5_Stora_News_Slider {
	// necessary class fields
	private $parent;
	private $mode;
	// constructor
	function __construct($parent) {
		$this->parent = $parent;
		// detect the supported Data Sources
		if(stripos($this->parent->config['data_source'], 'com_content_') !== FALSE) {
			$this->mode = 'com_content';
		} else if(stripos($this->parent->config['data_source'], 'k2_') !== FALSE) { 
			$this->mode = 'com_k2';
		} else {
			$this->mode = false;
		}
	}
	// static function which returns amount of articles to render - VERY IMPORTANT!!
	static function amount_of_articles($parent) {
		return $parent->config['portal_mode_stora_news_slider_amount'];
	}
	// output generator	
	function output() {
		// main wrapper
		echo '<div class="gkNspPM gkNspPM-StoraNewsSlider" id="'.$this->parent->config['module_id'].'">';
		
		if(!empty($this->parent->config['nsp_pre_text']) && trim($this->parent->config['nsp_pre_text'])) {
			echo $this->parent->config['nsp_pre_text'];
		}
		
		// images wrapper
		echo '<div class="gkListWrapper" data-arrows="'.$this->parent->config['portal_mode_stora_news_slider_arrows'].'">';
		echo '<div class="gkList owl-carousel owl-theme">';
		// render images
		for($i = 0; $i < count($this->parent->content); $i++) {			
			echo '<div class="gkItem item">';
			echo '<div class="gkItemWrap">';
			
			if($this->parent->config['portal_mode_stora_news_slider_images'] == '1') {
				echo '<a href="'.strip_tags($this->get_link($i)).'" class="gkImageWrapper">';
				echo '<img class="gkImage" src="'.$this->get_image($i).'" alt="" width="'.$this->parent->config['img_width'].'" height="'.$this->parent->config['img_height'].'" />';
				echo '</a>';
			}
			echo '<dl class="article-info"><dt class="hidden">Date</dt><dd class="published">'.JHtml::_('date', strip_tags($this->parent->content[$i]['date_publish']), JText::_('DATE_FORMAT_LC3')).'</dd></dl>';
			echo '<h2 class="gkTitle"><a href="'.strip_tags($this->get_link($i)).'">'.strip_tags($this->parent->content[$i]['title']).'</a></h2>';
			$string = substr(strip_tags($this->parent->content[$i]['text']), 0, $this->parent->config['portal_mode_stora_news_slider_max_lenght']);
			$string = substr($string, 0, strrpos($string, ' ')) . " ...";
			echo '<p class="gkDesc">'.$string.'<p>';
			echo '</div>';
			echo '</div>';	
		}
		// closing images wrapper
		echo '</div>';
		echo '</div>';
		
		if(!empty($this->parent->config['nsp_post_text']) && trim($this->parent->config['nsp_post_text'])) {
			echo $this->parent->config['nsp_post_text'];
		}
		// closing main wrapper
		echo '</div>';
	
		?>
		<script>
			jQuery(document).ready(function() {
				jQuery('.owl-carousel').owlCarousel({
			    loop: true,
			    margin: 40,
			    <?php if($this->parent->config['portal_mode_stora_news_slider_arrows'] == '1') echo 'nav: true,'; ?>
			    items: <?php echo $this->parent->config['portal_mode_stora_news_slider_number_of_column']; ?>,
			    autoplay: <?php echo $this->parent->config['portal_mode_stora_news_slider_interval'] ? 'true' : 'false'; ?>,
			    autoplayTimeout: <?php echo $this->parent->config['portal_mode_stora_news_slider_interval']; ?>,
// 			    autoplayHoverPause: true,
			    responsive : {
				    // breakpoint from 0 up
				    0 : {
				        items: 1
				    },
				    // breakpoint from 480 up
				    480 : {
				        items: 1
				    },
				    // breakpoint from 768 up
				    768 : {
				        items: 2
				    }, 
				    980 : {
				    		items: 3
				    },
				    1200 : {
				    		items: 4
				    }
				}
			  })
			});
		</script>
	<?php
	}
	// function used to retrieve the item URL
	function get_link($num) {
		if($this->mode == 'com_content') {
			// load necessary com_content View class
			if(!class_exists('NSP_GK5_com_content_View')) {
				require_once(JModuleHelper::getLayoutPath('mod_news_pro_gk5', 'com_content/view'));
			}
			return NSP_GK5_com_content_View::itemLink($this->parent->content[$num], $this->parent->config);
		} else if($this->mode == 'com_k2') {
			// load necessary k2 View class
			if(!class_exists('NSP_GK5_com_k2_View')) {
				require_once(JModuleHelper::getLayoutPath('mod_news_pro_gk5', 'com_k2/view'));
			}
			return NSP_GK5_com_k2_View::itemLink($this->parent->content[$num], $this->parent->config);
		} else {
			return false;
		}
	}
	// image generator
	function get_image($num) {		
		// used variables
		$url = false;
		$output = '';
		// select the proper image function
		if($this->mode == 'com_content') {
			// load necessary com_content View class
			if(!class_exists('NSP_GK5_com_content_View')) {
				require_once(JModuleHelper::getLayoutPath('mod_news_pro_gk5', 'com_content/view'));
			}
			// generate the com_content image URL only
			$url = NSP_GK5_com_content_View::image($this->parent->config, $this->parent->content[$num], true, true);
		} else if($this->mode == 'com_k2') {
			// load necessary k2 View class
			if(!class_exists('NSP_GK5_com_k2_View')) {
				require_once(JModuleHelper::getLayoutPath('mod_news_pro_gk5', 'com_k2/view'));
			}
			// generate the K2 image URL only
			$url = NSP_GK5_com_k2_View::image($this->parent->config, $this->parent->content[$num], true, true);
		}
		// check if the URL exists
		if($url === FALSE) {
			return false;
		} else {
			// if URL isn't blank - return it!
			if($url != '') {
				return $url;
			} else {
				return false;
			}
		}
	}
}

// EOF
