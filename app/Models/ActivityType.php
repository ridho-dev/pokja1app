<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityType extends Model
{
    protected $fillable = [
        'activity_type',
    ];

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class, 'activity_type_id');
    }
}
