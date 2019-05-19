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
	'LOG_BROWSER'				=> 'Journaliser le navigateur des utilisateurs',
	'LOG_BROWSER_EXPLAIN'		=> 'Permet d’inclure le navigateur Web de l’utilisateur dans le journal de connexions des utilisateurs.',
	'LOG_CONNECTION'			=> 'Journaliser les connexions réussies',
	'LOG_CONNECTION_EXPLAIN'	=> 'Permet d’inclure au « Journal d’utilisateur » les connexions réussies sur le forum.',
	'LOG_CONNECTIONS_EXPLAIN'	=> 'Depuis cette page il est possible de paramétrer les options concernant le type de connections à journaliser.',
	'LOG_CONNECTIONS_OPTIONS'	=> 'Options de journalisation des connexions',
	'LOG_FAILED'				=> 'Journaliser les tentatives de connexions échouées',
	'LOG_FAILED_EXPLAIN'		=> 'Permet d’inclure au « Journal d’utilisateur » les connexions échouées sur le forum.',
	'LOG_LOGOUT'				=> 'Journaliser les déconnexions',
	'LOG_LOGOUT_EXPLAIN'		=> 'Permet d’inclure au « Journal d’utilisateur » les déconnexions des utilisateurs sur le forum.',
	'LOG_NEW_USER'				=> 'Journaliser les enregistrements de nouveaux utilisateurs',
	'LOG_NEW_USER_EXPLAIN'		=> 'Permet d’inclure au « Journal d’utilisateur » lorsqu’un nouvel utilisateur s’enregistre sur le forum.',

	'VERSION'					=> 'Version',
));

// Donate
$lang = array_merge($lang, array(
	'DONATE'					=> 'Donation',
	'DONATE_EXTENSIONS'			=> 'Soutenir le développement de mes extensions',
	'DONATE_EXTENSIONS_EXPLAIN'	=> 'Cette extension, comme toutes mes extensions, est totalement libre d’utilisation et ce sans frais. Si vous estimez qu’elle vous est bénéfique merci de soutenir son développement en effectuant un don via le bouton « Faire un don via PayPal » - J’apprécierai grandement votre geste. Aussi, je m’engage à ne pas divulguer à quiconque votre contact ni à vous envoyer des demandes de soutiens tels que les dons.',
	
	'PAYPAL_BUTTON'				=> 'Faire un don via PayPal',
	'PAYPAL_TITLE'				=> 'PayPal - Le paiement en ligne, simple et sécurisé.',
));
