<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_search
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>

<?php foreach ($this->results as $result) : ?>
	<div class="search-results">
		<div>
		<?php echo $this->pagination->limitstart + $result->count . '. ';?>
		<?php if ($result->href) :?>
			<a href="<?php echo JRoute::_($result->href); ?>"<?php if ($result->browsernav == 1) :?> target="_blank"<?php endif;?>>
			<?php echo $this->escape($result->title);?>
			</a>
		<?php else:?>
			<?php echo $this->escape($result->title);?>
		<?php endif; ?>
		<?php if ($result->section) : ?>
			<span class="small<?php echo $this->pageclass_sfx; ?>">
			(<?php echo $this->escape($result->section); ?>)
			</span>
		<?php endif; ?>
			<?php if ($this->params->get('show_date')) : ?>
			<span class="result-created<?php echo $this->pageclass_sfx; ?>">
			<?php echo JText::sprintf('JGLOBAL_CREATED_DATE_ON', $result->created); ?>
			</span>
		<?php endif; ?>
		</div>
		<div class="result-text">
			<?php echo $result->text; ?>
		</div>
	</div>
<?php endforeach; ?>

<div class="pagination">
	<?php echo $this->pagination->getPagesLinks(); ?>
</div>
