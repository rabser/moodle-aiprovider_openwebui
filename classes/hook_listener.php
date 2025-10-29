<?php
// This file is part of Moodle - http://moodle.org/
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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

namespace aiprovider_openwebui;

use aiprovider_openwebui\model\base;
use core_ai\hook\after_ai_action_settings_form_hook;
use core_ai\hook\after_ai_provider_form_hook;

/**
 * Hook listener for OpenWebUI provider.
 *
 * @package    aiprovider_openwebui
 * @copyright   2025 Sergio Rabellino <sergio.rabellino@unito.it>
 * derived from  Matt Porritt <matt.porritt@moodle.com> work on openai provider
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class hook_listener {

    /**
     * Hook listener for the OpenWebUI instance setup form.
     *
     * @param after_ai_provider_form_hook $hook The hook to add to the AI instance setup.
     */
    public static function set_form_definition_for_aiprovider_openwebui(after_ai_provider_form_hook $hook): void {
        if ($hook->plugin !== 'aiprovider_openwebui') {
            return;
        }

        $mform = $hook->mform;

        // Setting to store OpenWebUI url api
        $mform->addElement(
            'text',
            'apiurl',
            get_string('apiurl', 'aiprovider_openwebui'),
            ['size' => 255],
        );
        $mform->setType('apiurl', PARAM_TEXT);
        $mform->addHelpButton('apiurl', 'apiurl', 'aiprovider_openwebui');
        $mform->addRule('apiurl', get_string('required'), 'required', null, 'client');

        // Required setting to store OpenWebUI API key.
        $mform->addElement(
            'passwordunmask',
            'apikey',
            get_string('apikey', 'aiprovider_openwebui'),
            ['size' => 75],
        );
        $mform->addHelpButton('apikey', 'apikey', 'aiprovider_openwebui');
        $mform->addRule('apikey', get_string('required'), 'required', null, 'client');

    }

    /**
     * Hook listener for the OpenWebUI action settings form.
     *
     * @param after_ai_action_settings_form_hook $hook The hook to add to config action settings.
     */
    public static function set_model_form_definition_for_aiprovider_openwebui(after_ai_action_settings_form_hook $hook): void {
        if ($hook->plugin !== 'aiprovider_openwebui') {
            return;
        }

        $mform = $hook->mform;
        if (isset($mform->_elementIndex['modeltemplate'])) {
            $model = $mform->getElementValue('modeltemplate');
            if (is_array($model)) {
                $model = $model[0];
            }

            if ($model == 'custom') {
                $mform->addElement('header', 'modelsettingsheader', get_string('settings', 'aiprovider_openwebui'));
                $settingshelp = \html_writer::tag('p', get_string('settings_help', 'aiprovider_openwebui'));
                $mform->addElement('html', $settingshelp);
                $mform->addElement(
                    'textarea',
                    'modelextraparams',
                    get_string('extraparams', 'aiprovider_openwebui'),
                    ['rows' => 5, 'cols' => 20],
                );
                $mform->setType('modelextraparams', PARAM_TEXT);
                $mform->addElement('static', 'modelextraparams_help', null, get_string('extraparams_help', 'aiprovider_openwebui'));
            } else {
                $targetmodel = helper::get_model_class($model);
                if ($targetmodel) {
                    if ($targetmodel->has_model_settings()) {
                        $mform->addElement('header', 'modelsettingsheader', get_string('settings', 'aiprovider_openwebui'));
                        $settingshelp = \html_writer::tag('p', get_string('settings_help', 'aiprovider_openwebui'));
                        $mform->addElement('html', $settingshelp);
                        $targetmodel->add_model_settings($mform);
                    }
                }
            }
        }
    }
}
