<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class GelangCustomer extends Model
{
    //
    protected $table = 'gelang_customer';
    public $timestamps = false;
    
    public static function deleteTuple($id) {
        DB::table('gelang_customer')->where('id_gelang', $id)->delete();   
    }
    
    public static function getId($noGelang) {
        return DB::table('gelang_customer')->where('id_gelang', $noGelang)->pluck('id_customer');
    }
    
     public static function clear() {
        DB::table('gelang_customer')->truncate();
    }
    
    public static function getTotalOn($id) {
        return DB::table('gelang_customer')->where('id_periode', $id)->sum('total');
    }

     public static function getLaporanKasir() {
        return DB::table('gelang_customer')
        ->select('nama_kasir', DB::raw('count(case jenis when "Registrasi" then 1 else null end) as total_berapa, sum(total) as total_kasir'))
        ->groupBy('nama_kasir')
        ->where('id_periode', Periode::getActive())
        ->get();
    }

    public static function getTotalKartu($id) {
        return DB::table('gelang_customer')
        ->where('id_periode', $id)
        ->where('jenis', 'Registrasi')
        ->count();
    }
}