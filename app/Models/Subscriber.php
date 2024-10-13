<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    public $timestamps = false; //vô hiệu hóa tự đông thêm created_at và updated_at
    protected $fillable = ['email', 'subscribed_at'];
}