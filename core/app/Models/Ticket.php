<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = ['subject','user_id','file','message','status'];

    public function messages()
    {
    	return $this->hasMany('App\Models\Message');
    }
    public function lastMessage()
    {
        return $this->hasOne('App\Models\Message')->latest();
    }
    public function user()
    {
        return $this->hasOne('App\Models\User','id','user_id')->withDefault();
    }
    public function isRepliedByAdmin()
{
   if (!$this->lastMessage) {
        return false;
    }
      $userId = $this->lastMessage->user_id;
        if ($userId == 0) {
        return true;
    }
      $admin = \App\Models\Admin::where('id', $userId)->first();
      
    return $admin && $admin->role_id == 0 || !empty($admin);;

}
}
