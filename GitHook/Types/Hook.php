<?php

namespace GitHook\Types;

use App\Facade\Response;
use GitHook\HookPayload;

class Hook implements HookType
{
    protected HookPayload $payload;

    /**
     * @param json string|array $load
     * 
     * @throws JsonException if $load is string and it is a wrong json object
     * @throws InvalidArgumentException if $load is not a string or an array
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
        return 'Hook';
    }

    /**
     * @return HookPayload
     */
    public function getPayload(): HookPayload
    {
        return $this->payload;
    }

    /**
     * @return string
     */
    public function getZen(): string
    {
        return $this->payload->get('zen');
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
        $requiredEvent = ['*', 'pull_request'];

        $events = $payload->get('hook')->get('events');
        if (count(array_intersect($requiredEvent, $events)) == 0) {
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

            if ($events == ['*']) {
                $message .= "\n\n" . implode("\n", [
                    'Notice!',
                    'You chose all events. Some of them may not be available.',
                ]);
            } else {
                $otherEvents = array_diff($events, [$requiredEvent]);
                if (count($otherEvents) > 0) {
                    $message .= "\n\n" . implode("\n", [
                        'Notice!',
                        'These methods are not yet available.:',
                        implode(', ', $otherEvents),
                    ]);
                }
            }
        }

        return $message;
    }
}
