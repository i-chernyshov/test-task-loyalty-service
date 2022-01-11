<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\LoyaltyPointsTransaction
 *
 * @property int $id
 * @property int $account_id
 * @property float $points_amount
 * @property float|null $payment_amount
 * @property string|null $payment_id
 * @property int|null $payment_time
 * @property string $description
 * @property int|null $points_rule
 * @property int $canceled
 * @property string|null $cancellation_reason
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|LoyaltyPointsTransaction newModelQuery()
 * @method static Builder|LoyaltyPointsTransaction newQuery()
 * @method static Builder|LoyaltyPointsTransaction query()
 * @method static Builder|LoyaltyPointsTransaction whereAccountId($value)
 * @method static Builder|LoyaltyPointsTransaction whereCanceled($value)
 * @method static Builder|LoyaltyPointsTransaction whereCancellationReason($value)
 * @method static Builder|LoyaltyPointsTransaction whereCreatedAt($value)
 * @method static Builder|LoyaltyPointsTransaction whereDescription($value)
 * @method static Builder|LoyaltyPointsTransaction whereId($value)
 * @method static Builder|LoyaltyPointsTransaction wherePaymentAmount($value)
 * @method static Builder|LoyaltyPointsTransaction wherePaymentId($value)
 * @method static Builder|LoyaltyPointsTransaction wherePaymentTime($value)
 * @method static Builder|LoyaltyPointsTransaction wherePointsAmount($value)
 * @method static Builder|LoyaltyPointsTransaction wherePointsRule($value)
 * @method static Builder|LoyaltyPointsTransaction whereUpdatedAt($value)
 * @mixin Eloquent
 */
class LoyaltyPointsTransaction extends Model
{
    protected $table = 'loyalty_points_transaction';

    protected $fillable = [
        'account_id',
        'points_rule',
        'points_amount',
        'description',
        'payment_id',
        'payment_amount',
        'payment_time',
    ];

    public static function performPaymentLoyaltyPoints($account_id, $points_rule, $description, $payment_id, $payment_amount, $payment_time)
    {
        $points_amount = 0;

        if ($pointsRule = LoyaltyPointsRule::where('points_rule', '=', $points_rule)->first()) {
            $points_amount = match ($pointsRule->accrual_type) {
                LoyaltyPointsRule::ACCRUAL_TYPE_RELATIVE_RATE => ($payment_amount / 100) * $pointsRule->accrual_value,
                LoyaltyPointsRule::ACCRUAL_TYPE_ABSOLUTE_POINTS_AMOUNT => $pointsRule->accrual_value
            };
        }

        return LoyaltyPointsTransaction::create([
            'account_id' => $account_id,
            'points_rule' => $pointsRule?->id,
            'points_amount' => $points_amount,
            'description' => $description,
            'payment_id' => $payment_id,
            'payment_amount' => $payment_amount,
            'payment_time' => $payment_time,
        ]);
    }

    public static function withdrawLoyaltyPoints($account_id, $points_amount, $description)
    {
        return LoyaltyPointsTransaction::create([
            'account_id' => $account_id,
            'points_rule' => 'withdraw',
            'points_amount' => -$points_amount,
            'description' => $description,
        ]);
    }
}
