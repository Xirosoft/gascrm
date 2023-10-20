<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Lead extends Model
{
    use SoftDeletes, LogsActivity;

    protected $fillable = [
        'owner_id', 'lead_status_id', 'salutation', 'first_name', 'last_name', 'name', 'company', 'mobile', 'email', 'website', 'title', 'rating_id', 'follow_up', 'address_street', 'address_city', 'address_state', 'address_postalcode', 'address_country', 'info_employees', 'info_revenue', 'source_id', 'industry_id', 'description', 'is_completed', 'is_converted', 'status', 'created_by', 'updated_by',
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

    public function lead_status()
    {
        return $this->belongsTo(LeadStatus::class);
    }

    public function rating()
    {
        return $this->belongsTo(Rating::class);
    }

    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    public function industry()
    {
        return $this->belongsTo(Industry::class);
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
