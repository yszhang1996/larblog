<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function blogs(){
        return $this->hasMany(blog::class,'user_id');
    }
    //多对多关联
    public function follower(){
        return $this->belongsToMany(User::class,'follows','user_id','follower');
    }

    public function following(){
        return $this->belongsToMany(User::class,'follows','follower','user_id');
    }
    //指定用户是否为粉丝
    public function isFollow($uid){
        return $this->follower()->wherePivot('follower',$uid)->first();
    }
    //关注或者取关
    public function followToggle($ids){
        $ids= is_array($ids) ?: [$ids];
        return $this->follower()->withTimestamps()->toggle($ids);
    }
}
