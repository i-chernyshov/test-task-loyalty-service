<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\LoyaltyPointsRule
 *
 * @property int $id
 * @property string $points_rule
 * @property string $accrual_type
 * @property float $accrual_value
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|LoyaltyPointsRule newModelQuery()
 * @method static Builder|LoyaltyPointsRule newQuery()
 * @method static Builder|LoyaltyPointsRule query()
 * @method static Builder|LoyaltyPointsRule whereAccrualType($value)
 * @method static Builder|LoyaltyPointsRule whereAccrualValue($value)
 * @method static Builder|LoyaltyPointsRule whereCreatedAt($value)
 * @method static Builder|LoyaltyPointsRule whereId($value)
 * @method static Builder|LoyaltyPointsRule wherePointsRule($value)
 * @method static Builder|LoyaltyPointsRule whereUpdatedAt($value)
 * @mixin Eloquent
 */
class LoyaltyPointsRule extends Model
{
    public const ACCRUAL_TYPE_RELATIVE_RATE = 'relative_rate';
    public const ACCRUAL_TYPE_ABSOLUTE_POINTS_AMOUNT = 'absolute_points_amount';

    protected $table = 'loyalty_points_rule';

    protected $fillable = [
        'points_rule',
        'accrual_type',
        'accrual_value',
    ];
}
