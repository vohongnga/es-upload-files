<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends Model implements AuthenticatableContract
{
    use Authenticatable, HasFactory;

    protected $table = "users";
    protected $primaryKey = 'id';
    protected $fillable= ['username','role_id','remember_token'];
    protected $hidden = ['password'];

    /**Get role of user
     *
     * @return mixed
     */
    public function role() {
        return $this->belongsTo(Role::class,'role_id');
    }

}
