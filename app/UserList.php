<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserList extends Model
{
    protected $table = 'lists';
    protected $fillable = ['user_id','name'];

    public function user(){
        return $this->belongsTo('\App\User');
    }
    public function items(){
        return $this->belongsToMany('\App\SavedItem', 'lists_items', 'list_id', 'item_id');
    }
}
