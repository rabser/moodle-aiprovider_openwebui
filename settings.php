<?php
// This file is part of Moodle - https://moodle.org/
//
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Plugin administration pages are defined here.
 *
 * @package     aiprovider_openwebui
 * @copyright   2025 Sergio Rabellino <sergio.rabellino@unito.it>
 * derived from  Matt Porritt <matt.porritt@moodle.com> work on openai provider
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use core_ai\admin\admin_settingspage_provider;

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    // Provider specific settings heading.
    $settings = new admin_settingspage_provider(
        'aiprovider_openwebui',
        new lang_string('pluginname', 'aiprovider_openwebui'),
        'moodle/site:config',
        true,
    );

    $settings->add(new admin_setting_heading(
        'aiprovider_openwebui/general',
        new lang_string('settings', 'core'),
        '',
    ));

    // Setting to store OpenWebUI apiurl.
    $settings->add(new admin_setting_configtext(
        'aiprovider_openwebui/apiurl',
        new lang_string('apiurl', 'aiprovider_openwebui'),
        new lang_string('apiurl_desc', 'aiprovider_openwebui'),
        '',
        PARAM_URL,
    ));

    // Setting to store OpenWebUI API key.
    $settings->add(new admin_setting_configpasswordunmask(
        'aiprovider_openwebui/apikey',
        new lang_string('apikey', 'aiprovider_openwebui'),
        new lang_string('apikey_desc', 'aiprovider_openwebui'),
        '',
    ));

    // Setting to enable/disable global rate limiting.
    $settings->add(new admin_setting_configcheckbox(
        'aiprovider_openwebui/enableglobalratelimit',
        new lang_string('enableglobalratelimit', 'aiprovider_openwebui'),
        new lang_string('enableglobalratelimit_desc', 'aiprovider_openwebui'),
        0,
    ));

    // Setting to set how many requests per hour are allowed for the global rate limit.
    // Should only be enabled when global rate limiting is enabled.
    $settings->add(new admin_setting_configtext(
        'aiprovider_openwebui/globalratelimit',
        new lang_string('globalratelimit', 'aiprovider_openwebui'),
        new lang_string('globalratelimit_desc', 'aiprovider_openwebui'),
        100,
        PARAM_INT,
    ));
    $settings->hide_if('aiprovider_openwebui/globalratelimit', 'aiprovider_openwebui/enableglobalratelimit', 'eq', 0);

    // Setting to enable/disable user rate limiting.
    $settings->add(new admin_setting_configcheckbox(
        'aiprovider_openwebui/enableuserratelimit',
        new lang_string('enableuserratelimit', 'aiprovider_openwebui'),
        new lang_string('enableuserratelimit_desc', 'aiprovider_openwebui'),
        0,
    ));

    // Setting to set how many requests per hour are allowed for the user rate limit.
    // Should only be enabled when user rate limiting is enabled.
    $settings->add(new admin_setting_configtext(
        'aiprovider_openwebui/userratelimit',
        new lang_string('userratelimit', 'aiprovider_openwebui'),
        new lang_string('userratelimit_desc', 'aiprovider_openwebui'),
        10,
        PARAM_INT,
    ));
    $settings->hide_if('aiprovider_openwebui/userratelimit', 'aiprovider_openwebui/enableuserratelimit', 'eq', 0);
}
