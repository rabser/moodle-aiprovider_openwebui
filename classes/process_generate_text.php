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

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

/**
 * Class process text generation.
 *
 * @package    aiprovider_openwebui
 * @copyright  2025 Sergio Rabellino <sergio.rabellino@unito.it>
 * derived_from  Matt Porritt <matt.porritt@moodle.com> work on openai provider
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class process_generate_text extends abstract_processor {
    #[\Override]
    protected function get_endpoint(): UriInterface {
        return new Uri(get_config('aiprovider_openwebui', 'apiurl') .
                       get_config('aiprovider_openwebui', 'action_generate_text_endpoint'));
    }

    #[\Override]
    protected function get_model(): string {
        return get_config('aiprovider_openwebui', 'action_generate_text_model');
    }

    #[\Override]
    protected function get_system_instruction(): string {
        return get_config('aiprovider_openwebui', 'action_generate_text_systeminstruction');
    }

    #[\Override]
    protected function create_request_object(string $userid): RequestInterface {
        // Create the user object.
        $userobj = new \stdClass();
        $userobj->role = 'user';
        $userobj->content = $this->action->get_configuration('prompttext');

        // Create the request object.
        $requestobj = new \stdClass();
        $requestobj->model = $this->get_model();
        $requestobj->user = $userid;

        // If there is a system string available, use it.
        $systeminstruction = $this->get_system_instruction();
        if (!empty($systeminstruction)) {
            $systemobj = new \stdClass();
            $systemobj->role = 'system';
            $systemobj->content = $systeminstruction;
            $requestobj->messages = [$systemobj, $userobj];
        } else {
            $requestobj->messages = [$userobj];
        }

        return new Request(
            method: 'POST',
            uri: '',
            body: json_encode($requestobj),
            headers: [
                'Content-Type' => 'application/json',
            ],
        );
    }

    /**
     * Handle a successful response from the external AI api.
     *
     * @param ResponseInterface $response The response object.
     * @return array The response.
     */
    protected function handle_api_success(ResponseInterface $response): array {
        $responsebody = $response->getBody();
        $bodyobj = json_decode($responsebody->getContents());

        // Cleanup thinking before returning text if any
        $thinkclean = preg_replace('/<think>.*?<\/think>/s', '', $bodyobj->choices[0]->message->content);

        return [
            'success' => true,
            'id' => $bodyobj->id,
            'finishreason' => $bodyobj->choices[0]->finish_reason,
            'generatedcontent' => ltrim($thinkclean),
            'prompttokens' => $bodyobj->usage->prompt_tokens,
            'completiontokens' => $bodyobj->usage->completion_tokens,
        ];
    }
}
