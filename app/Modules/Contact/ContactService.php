<?php

/**
 * Website project: garethcmatthews.co.uk
 *
 * @link        https://github.com/garethcmatthews/garethcmatthews.co.uk
 * @copyright   Copyright (c) Gareth C Matthews
 * @license     https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

declare(strict_types=1);

namespace App\Modules\Contact;

use App\Modules\Contact\Repository\ContactRepository;
use Illuminate\Config\Repository as ConfigRepository;

use function mail;

class ContactService
{
    private ConfigRepository $config;
    private ContactRepository $repository;

    public function __construct(ContactRepository $repository, ConfigRepository $config)
    {
        $this->config     = $config;
        $this->repository = $repository;
    }

    /**
     * Store
     * Store the message and email
     *
     * @param array $input
     * @return void
     */
    public function store(array $input): void
    {
        $email = $input['email'] ?? '';
        if ($this->repository->getContactBlockedListAddress($email)->count() > 0) {
            return;
        }

        $this->repository->storeContact($input);
        if ($this->config->get('app.env') === "production") {
            $to      = 'MOVETOCONFIG@CONFIG.com';
            $subject = $input['reason'];
            $message = "FROM: {$input['fullname']}\nMESSAGE:\n{$input['message']}";
            $headers = 'From: ' . $input['email'] . "\r\n" . 'Reply-To: ' . $input['email'];
            mail($to, $subject, $message, $headers);
        }
    }
}
