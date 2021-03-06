<?php
/**
*
* @package Log Connections
* @copyright (c) 2017 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\logconnections\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use phpbb\config\config;
use phpbb\log\log;
use phpbb\user;
use phpbb\auth\auth;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\log\log */
	protected $log;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\auth\auth */
	protected $auth;

	/**
	* Constructor for listener
	*
	* @param \phpbb\config\config	$config	Config object
	* @param \phpbb\log\log			$log	phpBB log
	* @param \phpbb\user            $user	User object
	* @param \phpbb\auth\auth 		$auth	Auth object
	*
	* @access public
	*/
	public function __construct(config $config, log $log, user $user, auth $auth)
	{
		$this->config	= $config;
		$this->log		= $log;
		$this->user		= $user;
		$this->auth		= $auth;
	}

	/**
	* Assign functions defined in this class to event listeners in the core
	*
	* @return array
	* @static
	* @access public
	*/
	static public function getSubscribedEvents()
	{
		return array(
			'core.user_add_after' 		=> 'log_new_user',
			'core.session_kill_after'	=> 'log_logout',
			'core.login_box_failed' 	=> 'failed_login',
			'core.login_box_redirect'	=> array(
				'login_connect',
				90, // Need to allow this extension to run before any others.
			),
		);
	}

	/**
	* Log the new user
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function log_new_user($event)
	{
		if ($this->config['log_connect_new_user'])
		{
			$new_user_row = $event['user_row'];

			$additional_data['reportee_id']	= $event['user_id'];
			$additional_data[] 				= $new_user_row['user_email'];
			$additional_data[] 				= $this->user->data['session_browser'];

			$this->log->add('user', $event['user_id'], $new_user_row['user_ip'], 'LOG_NEW_USER_CREATED', time(), $additional_data);
		}
	}

	/**
	* Log the successful connection
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function login_connect($event)
	{
		if ($this->config['log_connect_user'])
		{
			// We don't need to log Admin logins as they are already logged
			$user_type = ($this->auth->acl_raw_data($this->user->data['user_id'], 'a_')) ? 'admin' : 'user';

			if ($user_type == 'user')
			{
				$additional_data['reportee_id']	= $this->user->data['user_id'];
				$log_message 					= ($this->user->data['session_autologin']) ? 'LOG_AUTO_LOGIN' : 'LOG_SUCCESSFUL';

				if ($this->config['log_browser'])
				{
					$additional_data[]	= $this->user->data['session_browser'];
					$log_message 		= ($this->user->data['session_autologin']) ? 'LOG_AUTO_LOGIN_BROWSER' : 'LOG_SUCCESSFUL_BROWSER';
				}

				//$this->log->add('user', $this->user->data['user_id'], $this->user->data['user_ip'], $log_message, time(), $additional_data);
				$this->log->add('user', $this->user->data['user_id'], $this->user->ip, $log_message, time(), $additional_data);
			}
		}
	}

	/**
	* Log failed login attempts
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function failed_login($event)
	{
		if ($this->config['log_connect_failed'])
		{
			$result		= $event['result'];
			$username	= $event['username'];
			$user_row 	= $result['user_row'];
			$user_id	= $user_row['user_id'];
			$user_ip 	= (in_array('user_ip', $user_row)) ? $user_row['user_ip'] : $this->user->ip;

			// If we do not have a user id then set it to anonymous user
			$user_id = (!$user_id) ? ANONYMOUS : $user_id;

			$additional_data = array();
			$additional_data['reportee_id']	= $user_id;

			// We want to log Admin fails to the Admin log and User fails to the user log
			$log_type = ($this->auth->acl_raw_data($user_id, 'a_')) ? 'admin' : 'user';

			switch ($result['status'])
			{
				case LOGIN_ERROR_USERNAME:
					$error_msg			= 'ERROR_LOGIN_USERNAME';
					$log_type			= 'user'; // This can only be user as we have no data to test
					$additional_data[]	= $username;
				break;

				case LOGIN_ERROR_PASSWORD:
					$error_msg	= 'ERROR_LOGIN_PASSWORD';
				break;

				case LOGIN_ERROR_ACTIVE:
					$error_msg	= 'ERROR_LOGIN_ACTIVE';
				break;

				case LOGIN_ERROR_ATTEMPTS:
					$error_msg	= 'ERROR_LOGIN_ATTEMPTS';
				break;

				case LOGIN_ERROR_PASSWORD_CONVERT:
					$error_msg	= 'ERROR_LOGIN_PASSWORD_CONVERT';
				break;

				default: // Let's have a catchall for any other failed logins
					$error_msg			= 'ERROR_LOGIN_UNKNOWN';
					$log_type			= 'user';
					$additional_data[]	= $result['status'];
					$additional_data[]	= $username;
				break;
			}

			$this->log->add($log_type, $user_id, $user_ip, $error_msg, time(), $additional_data);
		}
	}

	/**
	* Log the user logging out
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/
	public function log_logout($event)
	{
		if ($this->config['log_connect_logout'])
		{
			$user_id 						= $event['user_id'];
			$session_id						= $event['session_id'];
			$additional_data['reportee_id']	= $user_id;

			// No need to log ANONYMOUS logouts
			if ($this->user->data['user_ip'] && $user_id <> ANONYMOUS)
			{
				$this->log->add('user', $user_id, $this->user->data['user_ip'], 'LOG_USER_LOGOUT', time(), $additional_data);
			}
		}
	}
}
