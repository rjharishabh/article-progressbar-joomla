<?php
/**
 * @copyright   (C) 2021 Rishabh Ranjan Jha
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Factory;

/**
 * Article Progressbar Plugin.
 *
 * @since	1.0.0
 */
class PlgSystemRPArticleProgressbar extends CMSPlugin
{
	/**
	 * Application object.
	 *
	 * @var    CMSApplicationInterface
	 * @since  1.0.0
	 */
	protected $app;

	/**
	 * CSS for Site part
	 *
	 * @since	1.0.0
	 */
	public function site_css()
	{
		$params = $this->params;
		$css = '#rpfixedtrack {display:none;position: fixed; ' . $params->get('site_position', 'top') . ': ' . $params->get('site_offset', 0) . '; border-radius:' . $params->get('site_bradius', '100px') . ';z-index: 10000;background-color: ' . $params->get('site_bcolor', '#c7c7c7') . ';';

		if ($params->get('site_position', 'top') === "top" || $arams->get('site_position') === "bottom")
		{
			$css .= 'width: 100%;}';
		}
		else
		{
			$css .= 'height: 100%;}';
		}

		$css .= '#rpbar {border-radius:' . $params->get('site_bradius', '100px') . ';background: ' . $params->get('site_pcolor', '#5abfdd') . ';';

		if ($params->get('site_position', 'top') === "top" || $params->get('site_position') === "bottom")
		{
			$css .= 'height: ' . $params->get('site_height', '8px') . ';;width: 0%;}';
		}
		else
		{
			$css .= 'width: ' . $params->get('site_width', '8px') . ';height: 0%;}';
		}

		return $css;
	}

	/**
	 * Javascript for Site part
	 *
	 * @since	1.0.0
	 */
	public function site_js()
	{
		$params = $this->params;
		$script = '
		<script>
			window.onscroll = function(){
				const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
				let height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
				let scrolled = (winScroll / height) * 100;
				if(scrolled>0 )
				{
					document.getElementById("rpfixedtrack").style.display = "block";';

		if ($params->get('site_position', 'top') === "top" || $params->get('site_position') === "bottom")
		{
			$script .= 'document.getElementById("rpbar").style.width = scrolled + "%";';
		}
		else
		{
			$script .= 'document.getElementById("rpbar").style.height = scrolled + "%";';
		}

				$script .= '}
				else
				{
					document.getElementById("rpfixedtrack").style.display = "none";
				}
			}
		</script>';

		return $script;
	}

	/**
	 * CSS for Admin part
	 *
	 * @since	1.0.0
	 */
	public function admin_css()
	{
		$params = $this->params;
		$css = '#rpfixedtrack {display:none;position: fixed; ' . $params->get('admin_position', 'top') . ': ' . $params->get('admin_offset', 0) . '; border-radius:' . $params->get('admin_bradius', '100px') . ';z-index: 10000;background-color: ' . $params->get('admin_bcolor', '#c7c7c7') . ';';

		if ($params->get('admin_position', 'top') === "top" || $params->get('admin_position') === "bottom")
		{
			$css .= 'width: 100%;}';
		}
		else
		{
			$css .= 'height: 100%;}';
		}

		$css .= '#rpbar {border-radius:' . $params->get('admin_bradius', '100px') . ';background: ' . $params->get('admin_pcolor', '#5abfdd') . ';';

		if ($params->get('admin_position', 'top') === "top" || $params->get('admin_position') === "bottom")
		{
			$css .= 'height: ' . $params->get('admin_height', '8px') . ';;width: 0%;}';
		}
		else
		{
			$css .= 'width: ' . $params->get('admin_width', '8px') . ';height: 0%;}';
		}

		return $css;
	}

	/**
	 * Javascript for Admin part
	 *
	 * @since	1.0.0
	 */
	public function admin_js()
	{
		$params = $this->params;
		$script = '
		<script>
			window.onscroll = function(){
				const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
				let height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
				let scrolled = (winScroll / height) * 100;
				if(scrolled>0 )
				{
					document.getElementById("rpfixedtrack").style.display = "block";';

		if ($params->get('admin_position', 'top') === "top" || $params->get('admin_position') === "bottom")
		{
					$script .= 'document.getElementById("rpbar").style.width = scrolled + "%";';
		}
		else
		{
			$script .= 'document.getElementById("rpbar").style.height = scrolled + "%";';
		}

				$script .= '}
				else
				{
					document.getElementById("rpfixedtrack").style.display = "none";
				}
			}
		</script>';

		return $script;
	}

	/**
	 * Add the styles to the page
	 *
	 * @return  void
	 *
	 * @since   1.0.0
	 */
	public function onBeforeCompileHead()
	{
		$app = $this->app;
		$params = $this->params;
		$doc = Factory::getDocument();

		$site_css = $this->site_css();
		$admin_css = $this->admin_css();

		if ($app->isClient('site') && $params->get('site', 1) === 1)
		{
			$doc->addStyleDeclaration($site_css);
		}

		if (!$app->isClient('site') && $params->get('admin', 0) === 1)
		{
			$doc->addStyleDeclaration($admin_css);
		}
	}

	/**
	 * Add the HTML and Javascript to the page
	 *
	 * @return  void
	 *
	 * @since   1.0.0
	 */
	public function onAfterRespond()
	{
		$app = $this->app;
		$params = $this->params;
		$doc = Factory::getDocument();

		$site_js = $this->site_js();
		$admin_js = $this->admin_js();

		if ($app->isClient('site') && $params->get('site', 1) === 1)
		{
			echo '<div id="rpfixedtrack"><div id="rpbar"></div></div>';
			echo $site_js;
		}

		if (!$app->isClient('site') && $params->get('admin', 0) === 1)
		{
			echo '<div id="rpfixedtrack"><div id="rpbar"></div></div>';
			echo $admin_js;
		}
	}
}
