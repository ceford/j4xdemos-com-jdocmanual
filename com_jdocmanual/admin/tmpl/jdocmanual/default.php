<?php
/**
 * @package     jdocmanual.Administrator
 * @subpackage  com_jdocmanual
 *
 * @copyright   Copyright (C) 2021 Clifford E Ford
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->document->getWebAssetManager();
$wa->useStyle('com_jdocmanual.jdocmanual')
->useScript('com_jdocmanual.jdocmanual');

// make the toolbar not sticky
$wa->addInlineStyle('.subhead { position: inherit; ');

Text::script('COM_JDOCMANUAL_JDOCMANUAL_TOC_IN_THIS_PAGE', true);

$url = '';

// if using proxy do not show link to original
$proxy = false;
if (strpos($url, '/proxy/') !== false)
{
	$proxy = true;
}

?>

<form action="<?php echo Route::_('index.php?option=com_jdocmanual'); ?>"
	method="post" name="adminForm" id="adminForm">
	<input type="hidden" name="task" id="task" value="">
	<input type="hidden" name="jform[manual_id]" id="jform_manual_id" value="<?php echo $this->manual_id; ?>">
	<input type="hidden" name="jform[index_language_code]" id="jform_index_language_code" value="<?php echo $this->index_language_code; ?>">
	<input type="hidden" name="jform[page_language_code]" id="jform_page_language_code" value="<?php echo $this->page_language_code; ?>">
	<input type="hidden" name="jform[page_path]" id="jform_page_path" value="<?php echo $this->page_path; ?>">
	<input type="hidden" name="jform[index_url]" id="jform_index_url" value="<?php echo $this->source->index_url; ?>">

	<?php echo HTMLHelper::_('form.token'); ?>
</form>

	<?php if (empty($this->menu)) : ?>
		<?php
		echo Text::_('COM_JDOCMANUAL_JDOCMANUAL_FIRST_FETCH_INDEX');
		?>
	<?php else : ?>
	<div class="row jdocmanual-container">
		<div class="col-12 col-md-3 g-0">
			<nav id="jdocmanual-wrapper" aria-label="JDOC Manual Menu" class="sidebar-menu">
				<?php echo $this->menu->menu; ?>
			</nav>
		</div>
		<div class="col-12 col-md-6">
			<div class="document-title">
			<h2 id="document-title">
			<?php echo Text::_('COM_JDOCMANUAL_JDOCMANUAL_DOCUMENT_TITLE'); ?>
			</h2>
			</div>

			<div id="document-panel" class="" tabindex="0">
				<?php echo Text::_('COM_JDOCMANUAL_JDOCMANUAL_FIRST_SELECT'); ?>
			</div>
		</div>

		<div class="col-12 col-md-3 g-0 d-none d-md-block">
			<div id="toc-panel"></div>
		</div>
	</div>
	<?php endif; ?>

