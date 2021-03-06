<?php
/**
*
* @package Log Connections
* @copyright (c) 2017 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\logconnections\controller;

use phpbb\config\config;
use phpbb\request\request;
use phpbb\template\template;
use phpbb\user;
use phpbb\log\log;
use phpbb\language\language;
use david63\logconnections\ext;

/**
* Admin controller
*/
class admin_controller implements admin_interface
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\log */
	protected $log;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var string Custom form action */
	protected $u_action;

	/**
	* Constructor for admin controller
	*
	* @param \phpbb\config\config		$config		Config object
	* @param \phpbb\request\request		$request	Request object
	* @param \phpbb\template\template	$template	Template object
	* @param \phpbb\user				$user		User object
	* @param \phpbb\log\log				$log		phpBB log
	* @param \phpbb\language\language	$language	Language object
	*
	* @return \david63\logconnections\controller\admin_controller
	* @access public
	*/
	public function __construct(config $config, request $request, template $template, user $user, log $log, language $language)
	{
		$this->config	= $config;
		$this->request	= $request;
		$this->template	= $template;
		$this->user		= $user;
		$this->log		= $log;
		$this->language	= $language;
	}

	/**
	* Display the ouptions for this extension
	*
	* @return null
	* @access public
	*/
	public function display_options()
	{
		// Add the language file
		$this->language->add_lang('acp_logconnections', 'david63/logconnections');

		$form_key = 'log_connections';
		add_form_key($form_key);

		if ($this->request->is_set_post('submit'))
		{
			if (!check_form_key($form_key))
			{
				trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			// If no errors, process the form data
			// Set the options the user configured
			$this->set_options();

			// Add option settings change action to the admin log
			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_CONNECTIONS_LOG');
			trigger_error($this->user->lang('CONFIG_UPDATED') . adm_back_link($this->u_action));
		}

		// Template vars for header panel
		$this->template->assign_vars(array(
			'HEAD_TITLE'		=> $this->language->lang('LOG_CONNECTIONS'),
			'HEAD_DESCRIPTION'	=> $this->language->lang('LOG_CONNECTIONS_EXPLAIN'),

			'VERSION_NUMBER'	=> ext::LOG_CONNECTIONS_VERSION,
		));

		$this->template->assign_vars(array(
			'LOG_BROWSER'				=> isset($this->config['log_browser']) ? $this->config['log_browser'] : false,
			'LOG_CONNECTION'			=> isset($this->config['log_connect_user']) ? $this->config['log_connect_user'] : true,
			'LOG_CONNECTIONS_VERSION'	=> ext::LOG_CONNECTIONS_VERSION,
			'LOG_FAILED'				=> isset($this->config['log_connect_failed']) ? $this->config['log_connect_failed'] : true,
			'LOG_LOGOUT'				=> isset($this->config['log_connect_logout']) ? $this->config['log_connect_logout'] : false,
			'LOG_NEW_USER'				=> isset($this->config['log_connect_new_user']) ? $this->config['log_connect_new_user'] : true,

			'U_ACTION'					=> $this->u_action,
		));
	}

	/**
	* Set the options a user can configure
	*
	* @return null
	* @access protected
	*/
	protected function set_options()
	{
		$this->config->set('log_browser', $this->request->variable('log_browser', false));
		$this->config->set('log_connect_failed', $this->request->variable('log_connect_failed', true));
		$this->config->set('log_connect_logout', $this->request->variable('log_connect_logout', false));
		$this->config->set('log_connect_new_user', $this->request->variable('log_connect_new_user', true));
		$this->config->set('log_connect_user', $this->request->variable('log_connect_user', true));
	}

	/**
	* Set page url
	*
	* @param string $u_action Custom form action
	* @return null
	* @access public
	*/
	public function set_page_url($u_action)
	{
		$this->u_action = $u_action;
	}
}
