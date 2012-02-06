<?php

/**
 * @file
 * The PHP page that serves all page requests on a Drupal installation.
 *
 * The routines here dispatch control to the appropriate handler, which then
 * prints the appropriate page.
 *
 * All Drupal code is released under the GNU General Public License.
 * See COPYRIGHT.txt and LICENSE.txt.
 */

/**
 * Root directory of Drupal installation.
 */
define('DRUPAL_ROOT', getcwd());

$hostname = $_SERVER['HTTP_HOST'];
#if (strlen($hostname) > 10) {
#	if (substr($hostname, -10)==='headdev.dk') {
  		error_reporting(E_ALL);
  		ini_set('display_errors', TRUE);
  		ini_set('display_startup_errors', TRUE);
#	}
#	elseif (substr($hostname, -11)==='headtest.dk') {
#  		error_reporting(E_ALL);
#  		ini_set('display_errors', TRUE);
#  		ini_set('display_startup_errors', TRUE);
#	}
#}

require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
menu_execute_active_handler();
