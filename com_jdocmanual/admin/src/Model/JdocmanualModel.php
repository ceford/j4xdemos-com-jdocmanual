<?php
/**
 * @package     jdocmanual.Administrator
 * @subpackage  com_jdocmanual
 *
 * @copyright   Copyright (C) 2021 Clifford E Ford
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace J4xdemos\Component\Jdocmanual\Administrator\Model;

defined('_JEXEC') or die;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Model\ListModel;
use Joomla\Database\ParameterType;

/**
 * Methods supporting a list of jdocmanual records.
 *
 * @since  1.6
 */
class JdocmanualModel extends ListModel
{

	public function getPage()
	{
	}

	/**
	 * Populate the index of pages that appears in the left column
	 *
	 * @return string html created by Fetch index
	 */
	public function getMenu($manual_id, $index_language_code)
	{
		//$app = Factory::getApplication();

		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$query->select('menu')
		->from('#__jdocmanual_menu')
		->where('state = 1')
		->where('source_id = :source_id')
		->where('language_code = :language_code')
		->bind(':source_id', $manual_id, ParameterType::INTEGER)
		->bind(':language_code', $index_language_code, ParameterType::STRING)
		->order('id desc');
		//var_dump($index_language, $query->__tostring());die;
		$db->setQuery($query);
		$menu = $db->loadObject();
		//var_dump($menu);die;
		if (empty($menu && $index_language_code != 'en'))
		{
			// try again with English
			$query = $db->getQuery(true);
			$query->select('menu')
			->from('#__jdocmanual_menu')
			->where('state = 1')
			->where('source_id = :source_id')
			->where('language_code = ' . $db->quote('en'))
			->bind(':source_id', $manual_id, ParameterType::INTEGER)
			->order('id desc');
			//var_dump($index_language, $query->__tostring());die;
			$db->setQuery($query);
			$menu = $db->loadObject();
		}
		//var_dump($menu);die;
		return $menu;
	}

	public function getManuals()
	{
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$query->select('*')
		->from('#__jdocmanual_sources')
		->where('state = 1')
		->order('id');
		$db->setQuery($query);
		return $db->loadObjectList();
	}

	public function getLanguages($which)
	{
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$query->select('id, code, title')
		->from('#__jdocmanual_languages')
		->where('state = 1')
		->where($which . '_language = 1')
		->order('code');
		$db->setQuery($query);
		return $db->loadObjectList();
	}

	public function getSourceData($id)
	{
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$query->select('title, page_url, index_url')
		->from('#__jdocmanual_sources')
		->where('id = ' . $id);
		$db->setQuery($query);
		return $db->loadObject();
	}
}
