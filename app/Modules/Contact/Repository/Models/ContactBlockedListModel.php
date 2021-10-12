<?php

/**
 * Website project: garethcmatthews.co.uk
 *
 * @link        https://github.com/garethcmatthews/garethcmatthews.co.uk
 * @copyright   Copyright (c) Gareth C Matthews
 * @license     https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

declare(strict_types=1);

namespace App\Modules\Contact\Repository\Models;

use Illuminate\Database\Eloquent\Model;

class ContactBlockedListModel extends Model
{
    /** @var string */
    protected $table = 'contact_blocked_list';
}
