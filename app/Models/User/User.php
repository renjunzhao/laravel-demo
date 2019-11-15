<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    /**
     * 与模型关联的表名
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * @return mixed
     */
    public function getJWTIdentifier(){
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims(){
        return [];
    }
}
