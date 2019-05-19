<?php
/**
 *
 * Log user connections. An extension for the phpBB Forum Software package.
 * French translation by Galixte (http://www.galixte.com)
 *
 * @copyright (c) 2019 david63
 * @license GNU General Public License, version 2 (GPL-2.0-only)
 *
 */

/**
 * DO NOT CHANGE
 */
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ « » “ ” …
//

$lang = array_merge($lang, array(
	'ERROR_LOGIN_ACTIVE'			=> '<strong>Un utilisateur inactif a tenté de se connecter</strong>',
	'ERROR_LOGIN_ATTEMPTS'			=> '<strong>La limite du nombre de tentatives de connexions autorisées a été atteinte</strong>',
	'ERROR_LOGIN_PASSWORD'			=> '<strong>Un mot de passe incorrect a été saisi</strong>',
	'ERROR_LOGIN_PASSWORD_CONVERT'	=> '<strong>Une erreur s’est produite durant la modification du mot de passe</strong>',
	'ERROR_LOGIN_UNKNOWN'			=> '<strong>Une erreur inattendue s’est produite durant la connexion (#%1$s)</strong><br />» %2$s',
	'ERROR_LOGIN_USERNAME'			=> '<strong>Un nom d’utilisateur incorrect a été saisi</strong><br />» %1$s',

	'LOG_AUTO_LOGIN'				=> '<strong>Connexion automatique de l’utilisateur</strong>',
	'LOG_AUTO_LOGIN_BROWSER'		=> '<strong>Connexion automatique de l’utilisateur</strong><br />» %1$s',
	'LOG_CONNECTIONS'				=> 'Journalisation des connexions',
	'LOG_CONNECTIONS_LOG'			=> '<strong>Les paramètres du journalisation des connexions a été mis à jour</strong>',
	'LOG_NEW_USER_CREATED'			=> '<strong>Nouvel utilisateur enregistré</strong><br />» %1$s<br />» %2$s',
	'LOG_SUCCESSFUL'				=> '<strong>Connexion de l’utilisateur effectuée avec succès</strong>',
	'LOG_SUCCESSFUL_BROWSER'		=> '<strong>Connexion de l’utilisateur effectuée avec succès</strong><br />» %1$s',
	'LOG_USER_LOGOUT'				=> '<strong>Déconnexion de l’utilisateur</strong>',

	'MANAGE_DEFAULTS'				=> 'Gestion des paramètres',
));
