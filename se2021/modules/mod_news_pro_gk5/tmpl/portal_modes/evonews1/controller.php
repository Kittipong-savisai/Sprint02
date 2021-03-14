<?php

/**
* EvoNews1 Portal Mode
* @package News Show Pro GK5
* @Copyright (C) 2009-2014 Gavick.com
* @ All rights reserved
* @ Joomla! is Free Software
* @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
* @version $Revision: GK5 1.6.2 $
**/

// access restriction
defined('_JEXEC') or die('Restricted access');

class NSP_GK5_EVONEWS1 {
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
		return ($parent->config['portal_mode_evonews1_num_leading'] + $parent->config['portal_mode_evonews1_num_intro'] + $parent->config['portal_mode_evonews1_num_links']);
	}
	// output generator
	function output() {
	    // call from source controller.
        if(!class_exists('NSP_GK5_'.$this->parent->source.'_Controller')) {
            require_once (dirname(__FILE__).'/../../../data_sources'.DS.$this->parent->source.DS.'controller.php');
        }
        //
        if(!class_exists('NSP_GK5_'.$this->parent->source.'_View')) {
            require_once(JModuleHelper::getLayoutPath('mod_news_pro_gk5', $this->parent->source.'/view'));
        }
        /** GENERATING FINAL XHTML CODE START **/
        // always set the link amount = 0;
        $this->parent->config['news_short_pages'] = 0;
        $this->parent->params->set('news_short_pages', 0);
        $this->parent->config['links_columns_amount'] = 0;
        $this->parent->params->set('links_columns_amount', 0);
        $this->parent->config['links_amount'] = 0;
        $this->parent->params->set('links_amount', 0);
        $controller_class = 'NSP_GK5_'.$this->parent->source.'_Controller';
        $controller = new $controller_class();
        $controller_data = $controller->initialize($this->parent->config, $this->parent->content);

        $news_config_json = '{
					"animation_speed": '.($this->parent->config['animation_speed']).',
					"animation_interval": '.($this->parent->config['animation_interval']).',
					"animation_function": "'.($this->parent->config['animation_function']).'",
					"news_column": '.($this->parent->config['news_column']).',
					"news_rows": '.($this->parent->config['news_rows']).',
					"links_columns_amount": '.($this->parent->config['links_columns_amount']).',
					"links_amount": '.($this->parent->config['links_amount']).'
				}';
				
				// 
				$news_config_json = str_replace('"', '\'', $news_config_json);

        $contentarr = array_merge($controller_data['arts'], $controller_data['featured']);
		// main wrapper
		echo '<div class="nspMain gkNspPM gkNspPM-EvoNews1" data-config="'.$news_config_json.'">';

		if(!empty($this->parent->config['nsp_pre_text']) && trim($this->parent->config['nsp_pre_text'])) {
			echo $this->parent->config['nsp_pre_text'];
		}

		$num_leading = $this->parent->config['portal_mode_evonews1_num_leading'];

		$num_intro = $this->parent->config['portal_mode_evonews1_num_intro'] + $num_leading;

		$num_links = $this->parent->config['portal_mode_evonews1_num_links'] + $num_intro;

		// render images
		$leading_array = [];
		$intro_array = [];
		$link_array = [];

		for($i = 0; $i < count($contentarr); $i++) {
		   
      // new data.
			$html = '';
			$html .= '<div class="art clearfix">'.$contentarr[$i].'</div>';
      if ($num_leading>0 && $i<$num_leading) {
          $leading_array[] = $html;
      }
      if ($num_intro>$num_leading && $i<$num_intro && $i>=$num_leading) {
          $intro_array[] = $html;
      }
      if ($num_links>$num_intro && $i>=$num_intro) {
          $link_array[] = $html;
      }
		}

		if (!empty($leading_array)) {
            echo '<div class="leading">';
            echo implode(' ', $leading_array);
            echo '</div>';
        }

        if (!empty($intro_array)) {
            echo '<div class="intro">';
            echo implode(' ', $intro_array);
            echo '</div>';
        }

        if (!empty($link_array)) {
            echo '<div class="links">';
            echo implode(' ', $link_array);
            echo '</div>';
        }

		if(!empty($this->parent->config['nsp_post_text']) && trim($this->parent->config['nsp_post_text'])) {
			echo $this->parent->config['nsp_post_text'];
		}

		// closing main wrapper
		echo '</div>';
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

	// author generator
	function get_author($num) {
		$item = $this->parent->content[$num];
		return (trim(htmlspecialchars($item['author_alias'])) != '') ? htmlspecialchars($item['author_alias']) : htmlspecialchars($item['author_username']);
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
			// generate the EasyBlog image URL only
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
