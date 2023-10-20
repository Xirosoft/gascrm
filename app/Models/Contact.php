<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Contact extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'owner_id', 'salutation', 'first_name', 'last_name', 'name', 'phone', 'mobile', 'email', 'account_id', 'title', 'parent_id', 'fax', 'phone_home', 'phone_other', 'phone_assistant', 'assistant', 'department', 'source_id', 'birth_date', 'description', 'status', 'converted_lead_id', 'created_by', 'updated_by',
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

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function parent()
    {
        return $this->belongsTo(Contact::class, 'parent_id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id');
    }

    public function addresses()
    {
        return $this->hasMany(ContactAddress::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected static $logName = 'Lead';

    public function getDescriptionForEvent(string $eventName): string
    {
        return self::$logName. " {$eventName}";
    }

    public function tapActivity(Activity $activity)
    {
        $activity->ip = \request()->ip();
    }
}
