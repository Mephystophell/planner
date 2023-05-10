<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{

    const ROLE_ADMIN = 1;
    const ROLE_USER = 2;
    const ROLE_TESTER = 3;

    use HasFactory;
}
