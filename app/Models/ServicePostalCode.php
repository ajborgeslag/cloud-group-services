<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePostalCode extends Model
{
    use HasFactory;

    protected $table = 'service_postal_code';

    protected $fillable = [
        'service_id',
        'postal_code_id',
        'pluss_price'
    ];
}
