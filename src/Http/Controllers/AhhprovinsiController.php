<?php
namespace Satudata\Ahhprovinsi\Http\Controllers;

use Satudata\Ahhprovinsi\Models\AhhProvinsi;
use Satudata\Ahhprovinsi\Models\MasterWilayah;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AhhProvinsiController extends Controller
{
    public function getIndex(Request $request){
        return view('main');
    }

    public function getList(Request $request)
    {
        $default_order = 'ahhprovinsiid';
        $order_field = array(
            'ahhprovinsiid',
            'ahhprovinsivalue',
            'ahhprovinsikotakode'
        );
        $order_key 	= (!$request->input('iSortCol_0'))?0:$request->input('iSortCol_0');
        $order 		= (!$request->input('iSortCol_0'))?$default_order:$order_field[$order_key];
        $sort 		= (!$request->input('sSortDir_0'))?'desc':$request->input('sSortDir_0');
        $search 	= (!$request->input('sSearch'))?'':strtoupper($request->input('sSearch'));

        $limit 		= (!$request->input('iDisplayLength'))?10:$request->input('iDisplayLength');
        $start 		= (!$request->input('iDisplayStart'))?0:$request->input('iDisplayStart');

        $sEcho 			= (!$request->input('callback'))?0:$request->input('callback');
        $iTotalRecords 	= count(AhhProvinsi::kotakode()->get());

        $year = AhhProvinsi::year()->get();
        $kota = AhhProvinsi::kotakode()->get();

        $a=0;
        $b=0;
        $datas = array();
        foreach ($kota as $kotas){
            foreach ($year as $years){

                $query = DB::table('ahhprovinsi');
                $query = $query->select(DB::raw("ahhprovinsikotakode, kota_nama, SUM(ahhprovinsivalue) as ahhprovinsivalue, EXTRACT(YEAR FROM ahhprovinsitgl) as tahun"));
                $query = $query->join('master_kota','master_kota.kota_kode','=','ahhprovinsi.ahhprovinsikotakode');

                if($search!='' AND $order_field!=''){
                    $likeclause = '';
                    $i=0;
                    foreach($order_field as $field){
                        if($i==count($order_field)-1) {
                            $likeclause .= "UPPER(".$field.") LIKE '%".strtoupper($search)."%' COLLATE utf8mb4_unicode_ci";
                        } else {
                            $likeclause .= "UPPER(".$field.") LIKE '%".strtoupper($search)."%' COLLATE utf8mb4_unicode_ci OR ";
                        }
                        ++$i;
                    }
                    $query = $query->whereRaw($likeclause);
                }

                $query = $query->whereBetween('ahhprovinsitgl', array($years->tahun.'-01-01', $years->tahun.'-12-31'));
                $query = $query->where('ahhprovinsikotakode', $kotas->ahhprovinsikotakode);
                $query = $query->groupBy(array('ahhprovinsikotakode', 'kota_nama', 'tahun'));
                $haragaberlaku = $query->limit($limit)->offset($start)->get();

                if(!$haragaberlaku->isEmpty()){
                    foreach ($haragaberlaku as $harga){
                        $datas[$a]['kode'] = $harga->ahhprovinsikotakode;
                        $datas[$a]['kota'] = $harga->kota_nama;
                        $datas[$a][$years->tahun] = $harga->ahhprovinsivalue;
                    }
                }else{
                    $datas[$a][$years->tahun] = '-';
                }
                $b++;
            }
            $a++;
        }

        return response()->json($datas);
    }

    public function createAhhProvinsiSave(Request $request)
    {
        $ahhprovinsi = new AhhProvinsi();
        $ahhprovinsi->ahhprovinsivalue            = $request->input('ahhprovinsiValue');
        $ahhprovinsi->ahhprovinsitgl              = $request->input('ahhprovinsiTgl');
        $ahhprovinsi->ahhprovinsiprovincekode     = $request->input('ahhprovinsiProvinceKode');
        $ahhprovinsi->ahhprovinsikotakode         = $request->input('ahhprovinsiKotaKode');
        $ahhprovinsi->ahhprovinsicreatedate       = date('Y-m-d H:i:s');
        $ahhprovinsi->ahhprovinsicreateby         = $request->session()->get('userId');
        $ahhprovinsi->ahhprovinsistatus           = 1;

        if($ahhprovinsi->save())
        {
            $responses = array('message' => 'Penambahan telah disimpan.');
        }else{
            $responses = array('message' => 'Terjadi kesalaahan. Penambahan gagal disimpan.');
        }
        return response()->json($responses);
    }

    public function detailAhhProvinsi($id)
    {
        $header = '<div class="block-header">';
        $header .= '<h2 style="display: inline;">Organisasi</h2>';
        $header .= '</div>';

        $ahhprovinsi = AhhProvinsi::ahhprovinsiById($id)->get();

        return view('backend.laporan.ahhprovinsi.detail')
            ->with('header', $header)
            ->with('ahhprovinsi', $ahhprovinsi);
    }

    public function export($type){
        $year = AhhProvinsi::year()->get();
        $kota = AhhProvinsi::kotakode()->get();

        $a=0;
        $b=0;
        $datas = array();
        foreach ($kota as $kotas){
            foreach ($year as $years){
                $query = DB::table('ahhprovinsi');
                $query = $query->select(DB::raw("ahhprovinsikotakode, kota_nama, SUM(ahhprovinsivalue) as ahhprovinsivalue, EXTRACT(YEAR FROM ahhprovinsitgl) as tahun"));
                $query = $query->join('master_kota','master_kota.kota_kode','=','ahhprovinsi.ahhprovinsikotakode');

                $query = $query->whereBetween('ahhprovinsitgl', array($years->tahun.'-01-01', $years->tahun.'-12-31'));
                $query = $query->where('ahhprovinsikotakode', $kotas->ahhprovinsikotakode);
                $query = $query->groupBy(array('ahhprovinsikotakode', 'kota_nama', 'tahun'));
                $haragaberlaku = $query->get();
                $datas[$a]['Kota/Kabupaten'] = $kotas->kota_nama;

                if(!$haragaberlaku->isEmpty()){
                    foreach ($haragaberlaku as $harga){
                        $datas[$a][$years->tahun] = $harga->ahhprovinsivalue;
                    }
                }else{
                    $datas[$a][$years->tahun] = '-';
                }
                $b++;
            }
            $a++;
        }
        return Excel::create('Angka Harapan Hidup Provinsi Banten', function($excel) use ($datas) {
            $excel->sheet('mySheet', function($sheet) use ($datas)
            {
                $sheet->fromArray($datas);
            });
        })->download($type);
    }

    public function getKota($id)
    {
        $kota = MasterWilayah::kotaByKode($id)->get();
        return response()->json($kota->toArray());
    }

    public function getProvinsi(){
        $provinsi = MasterWilayah::provinsi()->get();
        return response()->json($provinsi);
    }

    public function getColumns()
    {
        $data1 = array(
            array(
                'label' => 'Kode',
                'field' => 'kode',
                'numeric' => false,
                'html' => false
            ),
            array(
                'label' => 'Kota',
                'field' => 'kota',
                'numeric' => false,
                'html' => false
            ),
        );

        $year = AhhProvinsi::year()->orderBy('tahun','ASC')->get();
        $data2 = array();
        $i=0;
        foreach($year as $y){
            $data2[$i]['label'] = $y->tahun;
            $data2[$i]['field'] = $y->tahun;
            $data2[$i]['numeric'] = true;
            $data2[$i]['html'] = false;
            $i++;
        }
        $datas = array_merge($data1, $data2);
        return response()->json($datas);
    }
}