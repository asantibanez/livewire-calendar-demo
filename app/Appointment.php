<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Appointment
 * @package App
 * @property int $id
 * @property string $title
 * @property string $notes
 * @property Carbon $scheduled_at
 * @property string priority
 */
class Appointment extends Model
{
    protected $fillable = [
        'title',
        'notes',
        'scheduled_at',
        'priority',
    ];

    protected $dates = [
        'scheduled_at',
    ];
}
