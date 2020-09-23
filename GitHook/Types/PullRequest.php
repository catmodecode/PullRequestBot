<?php

namespace GitHook\Types;

use App\Facade\Response;
use Exception;
use GitHook\HookPayload;

class PullRequest implements HookType
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
        $eventMessages = [
            'opened' => 'New pull request!',
            'edited' => 'Pull request was edited!',
            'assigned' => 'Pull request was assigned!',
            'unassigned' => 'Pull request was unassigned!',
            'review_requested' => 'Review requested!',
            'review_request_removed' => 'Review request removed!',
            'ready_for_review' => 'Ready for review!',
            'reopened' => 'Pull request was reopened!',
            'synchronize' => 'Pull request was updated!'
        ];
        $payload = $this->payload;
        $pullRequest = $payload->get('pull_request');
        $repo = $payload->get('repository');

        $event = $payload->get('action');

        if (!in_array($event, array_keys($eventMessages))) {
            throw new Exception('No action needed');
        }

        $eventMessage = $eventMessages[$event];

        $message = implode("\n", [
            $eventMessage,
            $pullRequest->get('title'),
            '',
            'From '
                . $pullRequest->get('head')->get('ref')
                .  ' to '
                . $pullRequest->get('base')->get('ref'),
            'Url: ' . $pullRequest->get('html_url'),
            'Author: ' . $payload->get('sender')->get('login'),
            '',
            'Repository: ' . $repo->get('full_name'),
            'Repo url: ' . $repo->get('html_url')
        ]);

        return $message;
    }
}
