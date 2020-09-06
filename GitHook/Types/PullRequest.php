<?php

namespace GitHook\Types;

use GitHook\HookPayload;

class Hook implements HookType
{
    protected HookPayload $payload;

    /**
     * @param json string|array $load
     */
    public function __construct($load)
    {
        $this->payload = new HookPayload($load);
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'PullRequest';
    }

    /**
     * @return HookPayload
     */
    public function getPayload(): HookPayload
    {
        return $this->payload;
    }

    /**
     * Message for Telegram
     * 
     * @return string
     */
    public function getMessage(): string
    {
        $payload = $this->payload;
        $repo = $payload->get('repository');
        $requiredEvent = 'pull_request';
        
        $events = $payload->get('hook')->get('events');
        if (!in_array($requiredEvent, $events)) {
            $message = implode("\n", [
                'Error!',
                'You should select "pull request" option',
                'Author: ' . $payload->get('sender')->get('login'),
                'Repository: ' . $repo->get('full_name'),
                'Url: ' . $repo->get('html_url'),
            ]);
        } else {
            $message = implode("\n", [
                'New webhook!',
                $this->getZen(),
                'Webhook url: ' . $payload->get('hook')->get('config')->get('url'),
                'Author: ' . $payload->get('sender')->get('login'),
                'Repository: ' . $repo->get('full_name'),
                'Url: ' . $repo->get('html_url')
            ]);

            $otherEvents = array_diff($events, [$requiredEvent]);
            if(count($otherEvents) > 0) {
                $message .= "\n\n" . implode("\n", [
                    'Notice!',
                    'These methods are not yet available.:',
                    implode(', ', $otherEvents),
                ]);
            }
        }

        return $message;
    }
}
