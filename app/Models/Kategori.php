<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kategori extends Model
{
    use SoftDeletes;

    protected $table = 'kategoris';
    protected $primaryKey = 'id_kategori';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['nama_kategori', 'jenis', 'deskripsi'];

    public function Kas(){
        return $this->hasMany(Kas::class, 'kategori_id');
    }
}
