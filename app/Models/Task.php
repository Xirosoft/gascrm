<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Task extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'user_id', 'lead_id', 'contact_id', 'account_id', 'actionable_type', 'actionable_id', 'subject', 'comment', 'due_date', 'reminder_at', 'status', 'priority', 'is_completed', 'created_by', 'updated_by',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function actionable()
    {
        return $this->morphTo();
    }

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected static $logName = 'Task';

    public function getDescriptionForEvent(string $eventName): string
    {
        return self::$logName. " {$eventName}";
    }

    public function tapActivity(Activity $activity)
    {
        $activity->ip = \request()->ip();
    }
}
