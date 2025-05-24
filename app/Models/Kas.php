<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kas extends Model
{
    use SoftDeletes;

    protected $table= 'kas';
    protected $primaryKey = 'id_kas';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['jenis','tanggal','nominal','keterangan','kategori_id', 'user_id'];

    public function User(){
        return $this->belongsTo(User::class);
    }


    public function Kategori(){
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id_kategori');
    }
}
