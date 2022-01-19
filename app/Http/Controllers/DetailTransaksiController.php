<?php

namespace App\Http\Controllers;
use App\Models\detailTransaksi;
use App\Models\Paket;
use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use JWTAuth;

class detailTransaksiController extends Controller
{
    public $user;
    public $response;
    public function __construct()
    {
        $this->response = new ResponseHelper();
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    //tambah
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_transaksi' => 'required',
            'id_paket' => 'required',
            'quantity' => 'required',
        ]);

        if($validator->fails()) {
            return $this->response->errorResponse($validator->fails());
        }
        
        $detail = new detailTransaksi();
        $detail->id_transaksi = $request->id_transaksi;
        $detail->id_paket = $request->id_paket;

        //tampil
        $paket = Paket::where('id', '=', $detail->id_paket)->first();
        $harga = $paket->harga;

        $detail->quantity = $request->quantity;
        $detail->subtotal = $detail->quantity * $harga;

        $detail->save();

        $data = detailTransaksi::where('id', '=', $detail->id)->first();

        return response()->json(['message' => 'Berhasil tambah detail transaksi', 'data' => $data]);

        //*
    }

    public function getById($id)
    {
        //ambil detail dari transaksi tertentu

        $data = DB::table('detail_transaksi')->join('paket', 'detail_transaksi.id_paket', 'paket.id')
                                            ->select('detail_transaksi.*', 'paket.jenis')
                                            ->where('detail_transaksi.id_transaksi', '=', $id)
                                            ->get();
        return response()->json($data);                        
    }

    public function getTotal($id)
    {
        $total = detailTransaksi::where('id_transaksi', $id)->sum('subtotal');
        
        return response()->json([
            'total' => $total
        ]);
    }
}
// return $this->response->successResponseData('Berhasil tambah detail transaksi', $data);