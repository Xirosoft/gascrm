<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Account extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'owner_id', 'parent_id', 'name', 'mobile', 'fax', 'email', 'website', 'account_type_id', 'industry_id', 'info_employees', 'info_revenue', 'description', 'status', 'converted_lead_id', 'created_by', 'updated_by',
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
        return $this->belongsTo(Account::class, 'parent_id');
    }

    public function type()
    {
        return $this->belongsTo(AccountType::class, 'account_type_id');
    }

    public function industry()
    {
        return $this->belongsTo(Industry::class, 'industry_id');
    }

    public function addresses()
    {
        return $this->hasMany(AccountAddress::class);
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
