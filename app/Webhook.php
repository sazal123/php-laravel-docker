<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Webhook extends Model
{
    use HasFactory;
    protected $table = 'webhook';

    // Define the attributes that are mass assignable
    protected $fillable = ['data'];
}
