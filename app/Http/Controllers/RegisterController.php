<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\User;
use App\Customer;
use App\Gelang;
use App\Periode;
use App\GelangCustomer;
use Validator, Input, Redirect, Auth, Hash; 

class RegisterController extends Controller {

	public function register(){
        if(Periode::activeExist() == 1) {
		  	return view('auth/register');     
        } else {
            return redirect('cashierMenu')->withErrors('Transaksi belum dibuka');
        }
	}

	public function regisProcess(){
		
		$rules = array(
			'saldoKartu' => 'required',
			'noGelang' => 'required'
		);

		$validator = Validator::make(Input::all(), $rules);


		if($validator->fails()){

			return redirect('auth/register')->withErrors($validator);
		}

		$no_gelang = Input::get('noGelang'); 
		$saldo = str_replace(',', '', Input::get('saldoKartu'));
		

        if(Gelang::checkAvailable($no_gelang) != 0) {
            return redirect('auth/register')->withErrors('Nomer kartu telah digunakan');
        }
        
		$customer = new Gelang;
        $customer->id_gelang = $no_gelang;
        $customer->saldo = $saldo;
        $customer->save();
        
        $transaksi = new GelangCustomer;
        $transaksi->id_gelang = $no_gelang;
        $transaksi->jenis = 'Registrasi';
        $transaksi->total = $saldo;
        $transaksi->nama_kasir = User::getName(Auth::user()->username);
        $transaksi->id_periode = Periode::getActive();
        $transaksi->save();
        
        
//        $id = Customer::getId($nama, $tglLahir);
//        
//        $gelangCustomer = new GelangCustomer;
//        $gelangCustomer->id_customer = $id;
//        $gelangCustomer->id_gelang = $no_gelang;
//        $gelangCustomer->save();
//        
//        Periode::plus();
        
        return view('auth/registerInvoice')
        ->with('noKartu', $no_gelang)
        ->with('saldo', $saldo);
		
	}

	public function regisPrint(){

		return view('cashierMenuClose')->with('success', 'Registrasi customer berhasil');
	}
}

