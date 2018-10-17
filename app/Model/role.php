<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //设置主键
    protected $primaryKey = 'role_id';

    /**
     * 关联资源
     */
    public function resources()
    {
        return $this->hasMany('App\Model\Resource','role_id');
    }
}
