<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebScraping extends Model
{
    protected $fillable = [
        'type', 
        'id', 
        'title', 
        'description', 
        'publication', 
        'deadline', 
        'url', 
        'self'];
   

    use HasFactory;
}
