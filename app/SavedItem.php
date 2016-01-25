<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SavedItem extends Model
{
    protected $table='saved_items';
    protected $fillable = ['user_id','type','uri','status','body'];

    public function user(){
        return $this->belongsTo('\App\User');
    }
    public function lists(){
        return $this->belongsToMany('\App\UserList', 'lists_items', 'item_id', 'list_id');
    }
}
