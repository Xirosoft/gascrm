<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles, LogsActivity;

    protected $fillable = [
        'name', 'image', 'mobile', 'email', 'password', 'type', 'status', 'email_signature', 'created_by', 'updated_by',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected static $logName = 'User';

    public function getDescriptionForEvent(string $eventName): string
    {
        return self::$logName. " {$eventName}";
    }

    public function tapActivity(Activity $activity)
    {
        $activity->ip = \request()->ip();
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'user_id');
    }
    public function leads()
    {
        return $this->hasMany(Lead::class, 'owner_id');
    }
    public function accounts()
    {
        return $this->hasMany(Account::class, 'owner_id');
    }
    public function contacts()
    {
        return $this->hasMany(Contact::class, 'owner_id');
    }
    public function followings()
    {
        return $this->hasMany(Follow::class, 'user_id');
    }
    public function events()
    {
        return $this->hasMany(Event::class, 'user_id');
    }
    public function notifications()
    {
        return $this->hasMany(UserNotification::class, 'user_id');
    }
}
