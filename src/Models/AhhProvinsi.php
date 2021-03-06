<?php
namespace Satudata\Ahhprovinsi\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AhhProvinsi extends Model
{
    protected $table = 'ahhprovinsi';
    protected $primaryKey = 'ahhprovinsiid';
    public $timestamps = false;

    public static function ahhprovinsiById($id)
    {
        return DB::table('ahhprovinsi')
            ->select(DB::raw('*'))
            ->where('ahhprovinsistatus',$id)
            ->where('ahhprovinsistatus',1)
            ->where('ahhprovinsilogid')
            ->orderBy('ahhprovinsiid', 'ASC');
    }

    public static function year()
    {
        $nYear = Date('Y');
        $sYear = $nYear - 5;

        return DB::table('ahhprovinsi')
            ->select(DB::raw(' EXTRACT(YEAR FROM ahhprovinsitgl) as tahun'))
            ->whereBetween('ahhprovinsitgl', array($sYear.'-01-01', $nYear.'-12-31'))
            ->groupBy('tahun');
    }

    public static function kotakode()
    {
        return DB::table('ahhprovinsi')
            ->select(DB::raw('ahhprovinsikotakode, kota_nama'))
            ->join('master_kota','master_kota.kota_kode','=','ahhprovinsi.ahhprovinsikotakode')
            ->groupBy(array('ahhprovinsikotakode', 'kota_nama'));
    }
}
