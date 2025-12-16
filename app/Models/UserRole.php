<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    //table name is 'user_roles' by default, no need to specify it unless different
    protected $table = 'user_roles';
    protected $fillable = [
        'user_id',
        'app',
        'role',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    use HasFactory;
}
