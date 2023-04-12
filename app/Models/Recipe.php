<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $table = 'resep';

    protected $fillable = ['judul','gambar','cara_pembuatan','video','user_email','status_resep'];

    // relasi ke table user
    public function user(){
        // relasi ke table user dengan kunci tamu user_email pada table resep
        // dan kunci utama email pada table user
        return $this->belongsTo(User::class,'user_email','email');
    }
}
