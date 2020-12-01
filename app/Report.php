<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Report
 *
 * @property int $id
 * @property string $visit_date
 * @property int $customer_id
 * @property string $detail
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Customer $customer
 * @method static \Illuminate\Database\Eloquent\Builder|Report newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Report newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Report query()
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Report whereVisitDate($value)
 * @mixin \Eloquent
 */
class Report extends Model
{
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
