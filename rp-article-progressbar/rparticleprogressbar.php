<?php
/**
 *
 * @copyright   (C) 2021 Rishabh Ranjan Jha
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Factory;

/**
 * Article Progressbar Plugin.
 *
 */
class PlgSystemRPArticleProgressbar extends CMSPlugin
{
	/**
	 * Application object.
	 *
	 * @var    CMSApplicationInterface
	 */
	protected $app;

	public function site_css()
	{
		$css = '#rpfixedtrack {display:none;position: fixed; ' . $this->params->get('site_position', 'top') . ': ' . $this->params->get('site_offset', 0) . '; border-radius:' . $this->params->get('site_bradius', '100px') . ';z-index: 10000;background-color: ' . $this->params->get('site_bcolor', '#d9d9d9') . ';';

		if ($this->params->get('site_position', 'top') === "top" || $this->params->get('site_position') === "bottom")
		{
			$css .= 'width: 100%;}';
		}
		else
		{
			$css .= 'height: 100%;}';
		}

		$css .= '#rpbar {border-radius:' . $this->params->get('site_bradius', '100px') . ';background: ' . $this->params->get('site_pcolor', '#000') . ';';

		if ($this->params->get('site_position', 'top') === "top" || $this->params->get('site_position') === "bottom")
		{
			$css .= 'height: ' . $this->params->get('site_height', '8px') . ';;width: 0%;}';
		}
		else
		{
			$css .= 'width: ' . $this->params->get('site_width', '8px') . ';height: 0%;}';
		}

		return $css;
	}

	public function site_js()
	{
		$script = '
		<script>
			window.onscroll = function(){
				const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
				let height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
				let scrolled = (winScroll / height) * 100;
				if(scrolled>0 )
				{
					document.getElementById("rpfixedtrack").style.display = "block";';

		if ($this->params->get('site_position', 'top') === "top" || $this->params->get('site_position') === "bottom")
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

	public function admin_css()
	{
		$css = '#rpfixedtrack {display:none;position: fixed; ' . $this->params->get('admin_position', 'top') . ': ' . $this->params->get('admin_offset', 0) . '; border-radius:' . $this->params->get('admin_bradius', '100px') . ';z-index: 10000;background-color: ' . $this->params->get('admin_bcolor', '#d9d9d9') . ';';

		if ($this->params->get('admin_position', 'top') === "top" || $this->params->get('admin_position') === "bottom")
		{
			$css .= 'width: 100%;}';
		}
		else
		{
			$css .= 'height: 100%;}';
		}

		$css .= '#rpbar {border-radius:' . $this->params->get('admin_bradius', '100px') . ';background: ' . $this->params->get('admin_pcolor', '#000') . ';';

		if ($this->params->get('admin_position', 'top') === "top" || $this->params->get('admin_position') === "bottom")
		{
			$css .= 'height: ' . $this->params->get('admin_height', '8px') . ';;width: 0%;}';
		}
		else
		{
			$css .= 'width: ' . $this->params->get('admin_width', '8px') . ';height: 0%;}';
		}

		return $css;
	}

	public function admin_js()
	{
		$script = '
		<script>
			window.onscroll = function(){
				const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
				let height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
				let scrolled = (winScroll / height) * 100;
				if(scrolled>0 )
				{
					document.getElementById("rpfixedtrack").style.display = "block";';

		if ($this->params->get('admin_position', 'top') === "top" || $this->params->get('admin_position') === "bottom")
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

	public function onBeforeCompileHead()
	{
		$doc = Factory::getDocument();

		$site_css = $this->site_css();
		$admin_css = $this->admin_css();

		if ($this->app->isClient('site') && $this->params->get('site', 1) === 1)
		{
			$doc->addStyleDeclaration($site_css);
		}

		if (!$this->app->isClient('site') && $this->params->get('admin', 0) === 1)
		{
			$doc->addStyleDeclaration($admin_css);
		}
	}

	public function onAfterRespond()
	{
			$doc = Factory::getDocument();

			$site_js = $this->site_js();
			$admin_js = $this->admin_js();

		if ($this->app->isClient('site') && $this->params->get('site', 1) === 1)
		{
			echo '<div id="rpfixedtrack"><div id="rpbar"></div></div>';
			echo $site_js;
		}

		if (!$this->app->isClient('site') && $this->params->get('admin', 0) === 1)
		{
			echo '<div id="rpfixedtrack"><div id="rpbar"></div></div>';
			echo $admin_js;
		}
	}
}
