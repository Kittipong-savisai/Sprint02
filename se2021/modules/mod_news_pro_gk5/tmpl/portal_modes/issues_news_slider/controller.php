<?php

/**
* Issues_News_Slider Portal Mode
* @package News Show Pro GK5
* @Copyright (C) 2009-2014 Gavick.com
* @ All rights reserved
* @ Joomla! is Free Software
* @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
* @version $Revision: GK5 1.6.2 $
**/

// access restriction
defined('_JEXEC') or die('Restricted access');

$document = JFactory::getDocument();
$document->addStyleSheet('modules/mod_news_pro_gk5/tmpl/portal_modes/issues_news_slider/owl-carousel/owl.carousel.min.css');
$document->addStyleSheet('modules/mod_news_pro_gk5/tmpl/portal_modes/issues_news_slider/owl-carousel/owl.theme.default.min.css');
$document->addScript('modules/mod_news_pro_gk5/tmpl/portal_modes/issues_news_slider/owl-carousel/owl.carousel.min.js');

// JHtml::script(Juri::base() . 'modules/mod_news_pro_gk5/tmpl/portal_modes/issues_news_slider/tada.js');

class NSP_GK5_ISSUES_NEWS_SLIDER {
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
		return ($parent->config['news_column'] * $parent->config['news_full_pages']);
	}

	// Get Custom Fields
	public function getCustomFields($id, $context) {
		if ($context == 'article')
		$context = 'com_content.article';

		$currentLanguage = JFactory::getLanguage();
		$currentTag = $currentLanguage->getTag();

		$sql = 'SELECT fv.value, fg.title AS gtitle, f.title AS ftitle, f.name
				FROM #__fields_values fv
				LEFT JOIN #__fields f ON fv.field_id = f.id
				LEFT JOIN #__fields_groups fg ON fg.id = f.group_id
				WHERE fv.item_id = '.$id.'
				AND f.context = "'.$context.'"
				AND f.language IN ("*", "'.$currentTag.'")
				AND f.access = 1
				';
			// echo $sql;
		$db = JFactory::getDbo();
		$db->setQuery($sql);
		$result = $db->loadObjectList();
		$arr = array();
		foreach ($result AS $r) {
			$arr[$r->name] = $r->value;
		}

		return $arr;
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

    $news_column = $this->parent->config['news_column'];
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
		echo '<div class="nspMain gkNspPM gkNspPM-Issues_News_Slider" data-config="'.$news_config_json.'">';

		if(!empty($this->parent->config['nsp_pre_text']) && trim($this->parent->config['nsp_pre_text'])) {
			echo $this->parent->config['nsp_pre_text'];
		}

		$items = [];
		for($i = 0; $i < count($contentarr); $i++) {
      // new data.
			$html = '';
			$html .= '<div class="nspArt';
			$html .= '">' . $contentarr[$i];

			$html .= '</div>';

			$items[] = $html;
		}

		echo '<div class="row">';
			echo '<div class="owl-carousel owl-theme">';
		  	echo implode(' ', $items);
			echo '</div>';
		echo '</div>';

		if(isset($this->parent->config['articles_link']) && $this->parent->config['articles_link'] == '1') {
			$article_bottom_url = $this->parent->config['articles_link_url'];

			echo '<div class="readon-button-wrap">';
			echo '<a href="' . $article_bottom_url . '" class="readon-button">';
				if($this->parent->config['articles_link_label'] != '') {
					echo $this->parent->config['articles_link_label'];
				}
				else {
					echo JText::_('MOD_NEWS_PRO_GK5_ARTICLES_LINK_LABEL_DEFAULT');
				}
			echo ' <span class="fa fa-long-arrow-right"></span></a>';
			echo '</div>';
		}

		if(!empty($this->parent->config['nsp_post_text']) && trim($this->parent->config['nsp_post_text'])) {
			echo $this->parent->config['nsp_post_text'];
		}

		if ($this->parent->config['top_interface_style'] != 'none') {
		echo '<div class="owl-control">';
			if (
				$this->parent->config['top_interface_style'] == 'arrows' ||
				$this->parent->config['top_interface_style'] == 'arrows_with_pagination'
		  ) {
				echo '<div class="owl-nav"></div>';
			}

			if (
				$this->parent->config['top_interface_style'] == 'pagination' ||
				$this->parent->config['top_interface_style'] == 'arrows_with_pagination'
		  ) {
		  	echo '<div class="owl-dots"></div>';
		  }
		echo '</div>';
		}
		// closing main wrapper
		echo '</div>';

		echo '
		<script>
			jQuery(document).ready(function(){
				jQuery(".gkNspPM-Issues_News_Slider .owl-carousel").owlCarousel({
		';
			if ( $this->parent->config['top_interface_style'] == 'none' ) {
				echo '
					nav: false,
					dots: false,
				';
			} elseif ( $this->parent->config['top_interface_style'] == 'pagination' ) {
				echo '
					nav: false,
					dots: true,
					dotsContainer: \'.gkNspPM-Issues_News_Slider .owl-control .owl-dots\',
				';
			} elseif ( $this->parent->config['top_interface_style'] == 'arrows' ) {
				echo '
					dots: false,
					nav: true,
					navContainer: \'.gkNspPM-Issues_News_Slider .owl-control .owl-nav\',
				';
			} else {
				echo '
					dots: true,
					nav: true,
					dotsContainer: \'.gkNspPM-Issues_News_Slider .owl-control .owl-dots\',
					navContainer: \'.gkNspPM-Issues_News_Slider .owl-control .owl-nav\',
				';
			}

				echo '
					autoHeight:true,
					dotsEach: true,
					lazyLoad:true,
					loop: true,
					responsive: {
		        0: {
	            items: 1,
		        },
		        768: {
	            items: 2,
		        },
		        992: {
				';

      	echo 'items: ' . $news_column . ',';

      echo '
		        }
			    }
		    });
		  });
	  </script>';
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
