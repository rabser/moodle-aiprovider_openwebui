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

namespace aiprovider_openwebui\privacy;

use core_privacy\local\metadata\collection;
use core_privacy\local\request\approved_contextlist;
use core_privacy\local\request\approved_userlist;
use core_privacy\local\request\contextlist;
use core_privacy\local\request\userlist;

/**
 * Privacy provider implementation for OpenWebUI provider
 *
 * @package    aiprovider_openwebui
 * @copyright  2025 Sergio Rabellino <sergio.rabellino@unito.it>
 * @this_is_derived_from  Matt Porritt <matt.porritt@moodle.com> work on openai provider
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @codeCoverageIgnore
 */
class provider implements
    \core_privacy\local\metadata\provider,
    \core_privacy\local\request\core_userlist_provider,
    \core_privacy\local\request\plugin\provider {
    #[\Override]
    public static function get_metadata(collection $collection): collection {
        $collection->add_external_location_link('aiprovider_openwebui', [
            'prompttext' => 'privacy:metadata:aiprovider_openwebui:prompttext',
            'model' => 'privacy:metadata:aiprovider_openwebui:model',
            'numberimages' => 'privacy:metadata:aiprovider_openwebui:numberimages',
            'responseformat' => 'privacy:metadata:aiprovider_openwebui:responseformat',
        ], 'privacy:metadata:aiprovider_openwebui:externalpurpose');
        return $collection;
    }

    #[\Override]
    public static function get_contexts_for_userid(int $userid): contextlist {
        return new contextlist();
    }

    #[\Override]
    public static function get_users_in_context(userlist $userlist) {
    }

    #[\Override]
    public static function export_user_data(approved_contextlist $contextlist) {
    }

    #[\Override]
    public static function delete_data_for_all_users_in_context(\context $context) {
    }

    /**
     * Delete multiple users within a single context.
     *
     * @param approved_userlist $userlist The approved context and user information to delete information for.
     */
    public static function delete_data_for_users(approved_userlist $userlist) {
    }

    #[\Override]
    public static function delete_data_for_user(approved_contextlist $contextlist) {
    }
}
