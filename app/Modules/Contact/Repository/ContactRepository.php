<?php

/**
 * Website project: garethcmatthews.co.uk
 *
 * @link        https://github.com/garethcmatthews/garethcmatthews.co.uk
 * @copyright   Copyright (c) Gareth C Matthews
 * @license     https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

declare(strict_types=1);

namespace App\Modules\Contact\Repository;

use App\Modules\Contact\Repository\Models\ContactBlockedListModel;
use App\Modules\Contact\Repository\Models\ContactModel;
use Illuminate\Database\Eloquent\Collection;

class ContactRepository
{
    /**
     * Check is the email is in the blocked list
     *
     * @param string $email
     * @return Collection
     */
    public function getContactBlockedListAddress(string $email): Collection
    {
        return ContactBlockedListModel::query()
            ->where('email', $email)
            ->limit(1)
            ->get();
    }

    /**
     * Store the contact
     *
     * @param array $input
     * @return boolean
     */
    public function storeContact(array $input): bool
    {
        $contact = ContactModel::create($input);
        return $contact->save();
    }
}
