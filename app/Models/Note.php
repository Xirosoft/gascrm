<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Note extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'subject', 'details', 'conatctable_type', 'conatctable_id', 'actionable_type', 'actionable_id', 'created_by', 'updated_by',
    ];

    protected $appends = [
        'created_time', 'updated_time',
    ];

    public function getCreatedTimeAttribute()
    {
        return dateFormat($this->created_at, 1);
    }

    public function getUpdatedTimeAttribute()
    {
        return dateFormat($this->updated_at, 1);
    }

    public function conatctable()
    {
        return $this->morphTo();
    }

    public function actionable()
    {
        return $this->morphTo();
    }

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected static $logName = 'Industry';

    public function getDescriptionForEvent(string $eventName): string
    {
        return self::$logName. " {$eventName}";
    }

    public function tapActivity(Activity $activity)
    {
        $activity->ip = \request()->ip();
    }
}
