<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function facebookAccounts()
    {
        return $this->hasMany('App\FacebookAccount');
    }
    public function googleAccounts()
    {
        return $this->hasMany('App\GoogleAccount');
    }
    public function graphs()
    {
        return $this->hasMany('App\Graph');
    }
    public function getGraphPath(){
        return $this->graphs()->orderBy('id','asc')->first()['filepath'];
    }

    public function lists(){
        return $this->hasMany('\App\UserList');
    }
    public function savedItems(){
        return $this->hasMany('\App\SavedItem');
    }
    public function favorites(){
        return $this->savedItems()->where('status'=='liked');
    }
    public function blocked(){
        return $this->savedItems()->where('status'=='blocked');
    }
    public function hasSocialAccount(){
        if(count($this->googleAccounts()->get())){
            return true;
        }
        return false;
    }

}
