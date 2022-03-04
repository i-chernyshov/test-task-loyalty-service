<?php

namespace App\Models;

use App\Mail\AccountActivated;
use App\Mail\AccountDeactivated;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * App\Models\LoyaltyAccount
 *
 * @property int $id
 * @property string $phone
 * @property string $card
 * @property string $email
 * @property int $email_notification
 * @property int $phone_notification
 * @property int $active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|LoyaltyAccount newModelQuery()
 * @method static Builder|LoyaltyAccount newQuery()
 * @method static Builder|LoyaltyAccount query()
 * @method static Builder|LoyaltyAccount whereActive($value)
 * @method static Builder|LoyaltyAccount whereCard($value)
 * @method static Builder|LoyaltyAccount whereCreatedAt($value)
 * @method static Builder|LoyaltyAccount whereEmail($value)
 * @method static Builder|LoyaltyAccount whereEmailNotification($value)
 * @method static Builder|LoyaltyAccount whereId($value)
 * @method static Builder|LoyaltyAccount wherePhone($value)
 * @method static Builder|LoyaltyAccount wherePhoneNotification($value)
 * @method static Builder|LoyaltyAccount whereUpdatedAt($value)
 * @mixin Eloquent
 */
class LoyaltyAccount extends Model
{
    protected $table = 'loyalty_account';

    protected $fillable = [
        'phone',
        'card',
        'email',
        'email_notification',
        'phone_notification',
        'active',
    ];

    public function getBalance(): float
    {
        return LoyaltyPointsTransaction::where('canceled', '=', 0)
            ->where('account_id', '=', $this->id)
            ->sum('points_amount');
    }

    public function notify()
    {
        if ($this->email != '' && $this->email_notification) {
            if ($this->active) {
                Mail::to($this)->send(new AccountActivated($this->getBalance()));
            } else {
                Mail::to($this)->send(new AccountDeactivated());
            }
        }

        if ($this->phone != '' && $this->phone_notification) {
            // instead SMS component
            Log::info('Account: phone: ' . $this->phone . ' ' . ($this->active ? 'Activated' : 'Deactivated'));
        }
    }
}
