<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ZipCode extends Model
{
    use HasFactory;

    protected $table = 'postal_code';

    protected $fillable = [
        'province',
        'populate',
        'zip_code',
    ];
}
