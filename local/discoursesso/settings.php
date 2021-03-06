<?php
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * local_discoursesso
 *
 *
 * @package    local
 * @subpackage discoursesso
 * @copyright  2017 Saylor Academy
 * @author     John Azinheira
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
*/

defined('MOODLE_INTERNAL') || die;


if ( $hassiteconfig ){
 
	// Create the new settings page
	// - in a local plugin this is not defined as standard, so normal $settings->methods will throw an error as
	// $settings will be NULL
	$settings = new admin_settingpage( 'local_discoursesso', get_string('settingstitle', 'local_discoursesso'));
 
	// Create 
	$ADMIN->add( 'localplugins', $settings );
 
	$settings->add(
		new admin_setting_configtext('discoursesso_secret_key', get_string('secretkeylabel', 'local_discoursesso'), get_string('secretkeyhelp', 'local_discoursesso'), '', PARAM_RAW)
	);

	$settings->add(
		new admin_setting_configtext('discoursesso_discourse_url', get_string('discourseurllabel', 'local_discoursesso'), get_string('discourseurlhelp', 'local_discoursesso'), 'https://discourse.example', PARAM_TEXT)
	);
 
}