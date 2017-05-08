<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Periode;
use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Auth, Validator, Input;
use App\Customer;
use App\GelangCustomer;
use App\Gelang;
use App\Item;
use App\Item2;
use App\Item3;
use App\TransaksiBar;
use App\TransaksiBar2;
use App\TransaksiBar3;
use App\TransaksiKaraoke;
use App\TransaksiMassage;
use App\ResetKartu;

class CashierController extends Controller{
    //
    public function cashierMenu(){

    	if(Auth::check()){
            $id = Auth::user()->id; 
            
            $role = User::getRoles($id);
            
            if ($role == "cashier") {
            if(Periode::activeExist() == 1) {
                return view('cashierMenuClose')->with('success', '');
            } else {
                return view('cashierMenu')->with('success', '');
            }
            }
    	} 

    	return redirect('/auth/cashierLogin')->with('loginError', 'Please login first!');
    }
    
    public function cashierOpened(){
        if (Periode::getLastId() % 3 == 0) {
            TransaksiBar::clear();
            TransaksiBar2::clear();
            TransaksiBar3::clear();
            TransaksiKaraoke::clear();
            TransaksiMassage::clear();
        }
        ResetKartu::clear();
        GelangCustomer::clear();
        return view('cashierMenuClose')->with('success', 'Transaksi berhasil dibuka');
    }
    
    public function cashierClosed(){
        return view('cashierMenu')->with('success', 'Transaksi berhasil ditutup');
    }

    
    public function hasil_cari(){
//        echo Input::get('username');
//        echo Input::get('tglLahir');
        
        $rules = array(
			'noKartu' => 'required'
		);

		$validator = Validator::make(Input::all(), $rules);


		if($validator->fails()){

			return redirect('cariCashier')->withErrors($validator);
		}
    
        return view('hasilCariCashier')->with('saldo', Gelang::getSaldo(Input::get('noKartu')));   

        /*$kartu = Customer::getKartu(Input::get('username'), Input::get('tglLahir'));
        
        if ($kartu != null) {
            return view('hasilCari')->with('nama', Input::get('username'))->with('tglLahir', Input::get('tglLahir'))->with('noKartu', $kartu);   
        } 
        
        return redirect('cari')->withErrors('Nama atau Tanggal Lahir salah');*/
    }
    
     public function cari(){

    	return view('cariCashier');
    }
    
    public function login(){
		
		return view('/auth/cashierLogin');
	}

	public function logout(){
		
		Auth::logout();
		return view('auth/cashierLogin');
	}


	public function loginProcess(){
		
		$rules = array(
			'username' => 'required',			
			'password' => 'required'
		);

		$validator = Validator::make(Input::all(), $rules);


		if($validator->fails()){

			return redirect('auth/cashierLogin')->withErrors($validator);
		}

		$user = array(
			'username' => Input::get('username'),
			'password' => Input::get('password') 
		);        
        
		if(Auth::attempt($user)){
            
            $role = User::getRole(Input::get('username'));
            
            if ($role == "cashier") {
			     return redirect('/cashierMenu');
            }
		}

		return redirect('auth/cashierLogin')->with('loginError', 'Wrong username or password');
	}
    
   public function openTransaction() {
        
        // $id = Auth::user()->id;
        
        // $password = User::getPassword($id);
        
        // $username = Auth::user()->username;
        
        $username = User::where('role', 'anton')->take(1)->pluck('username');

        $user = array(
			'username' => $username,
			'password' => Input::get('passnya') 
		);    
        
        if(Auth::attempt($user)){
            Periode::start();
            return redirect('cashierOpen');
		}
        
         return view('cashierMenu')->withErrors('Wrong password')->with('success', '');
        
    }
    
    public function closeTransaction() {
        
        // $id = Auth::user()->id;
        
        // $password = User::getPassword($id);
        
        // $username = Auth::user()->username;
        
        $username = User::where('role', 'anton')->take(1)->pluck('username');

        $user = array(
			'username' => $username,
			'password' => Input::get('passnya') 
		);    
        
        if(Auth::attempt($user)){
            Periode::stop();
            return redirect('cashierClose');
		}
        
         return view('cashierMenuClose')->withErrors('Wrong password')->with('success', '');
    }
    public function stock(){
        return view('stock')->with('itemList', Item::all());
    }

    public function stock_update(){
        return view('stock_update')->with('nama', Input::get('nama'));
    }
    
    public function updateStock(){
        $nama = Input::get('nama');

        $rules = array(          
            'jumlah' => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);


        if($validator->fails()){

            return view('stock_update')->withErrors($validator)->with('nama', $nama);
        }
        
        if (Item2::exist($nama) == 0) {
            
            return view('stock_update')->withErrors('Nama item tidak terdaftar')->with('nama', $nama)->with('jumlah', $jumlah);
        }

        $jumlah = Input::get('jumlah');
        $id = Item::getId($nama);
        
        Item::addStock($nama, $jumlah);
        
        return view('stock_update_proof')
            ->with('jumlah', $jumlah)
            ->with('nama', $nama)
            ->with('id', $id);
    }
    
    public function update_stock_print(){

        return view('stock')->with('itemList', Item::all());
    }
    
    public function deleteItem(){
        Item::deleteItemWithNama(Input::get('nama'));
        return view('stock')->with('itemList', Item::all());
    }

    /*stock2*/
    public function stock2(){
        return view('cashier.stock2')->with('itemList', Item2::all());
    }

    public function stock2_update(){
        return view('cashier.stock2_update')->with('nama', Input::get('nama'));
    }
    
    public function updateStock2(){
        $nama = Input::get('nama');

        $rules = array(         
            'jumlah' => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);

        if($validator->fails()){

            return view('cashier.stock2_update')->withErrors($validator)->with('nama', $nama);
        }
        
        $jumlah = Input::get('jumlah');
        $id = Item2::getId($nama);
        
        if (Item2::exist($nama) == 0) {
            
            return view('cashier.stock2_update')->withErrors('Nama item tidak terdaftar')->with('nama', $nama)->with('jumlah', $jumlah);
        }

	if (Item::exist($nama) != 0){
            $stok_utama = Item::getStock($nama);
            if ($jumlah > $stok_utama){
                return view('cashier.stock2_update')->withErrors('Jumlah penambahan melebihi jumlah di gudang utama')->with('nama', $nama)->with('jumlah', $jumlah);
            }
            else{
                Item::minStock($nama, $jumlah);
            }
        }
        
        
        Item2::addStock($nama, $jumlah);

        return view('cashier.stock2_update_proof')
            ->with('jumlah', $jumlah)
            ->with('nama', $nama)
            ->with('id', $id);
    }
    
    public function update_stock2_print(){

        return view('cashier.stock2')->with('itemList', Item2::all());
    }
    
    public function deleteItem2(){
        Item2::deleteItemWithNama(Input::get('nama'));
        return view('cashier.stock2')->with('itemList', Item2::all());
    }

    /*stock3*/
    public function stock3(){
        return view('cashier.stock3')->with('itemList', Item3::all());
    }

    public function stock3_update(){
        return view('cashier.stock3_update')->with('nama', Input::get('nama'));
    }
    
    public function updateStock3(){
        $nama = Input::get('nama');
        
        $rules = array(           
            'jumlah' => 'required'
        );

        $validator = Validator::make(Input::all(), $rules);


        if($validator->fails()){

            return view('cashier.stock3_update')->withErrors($validator)->with('nama', $nama);
        }
        
        $jumlah = Input::get('jumlah');
        $id = Item3::getId($nama);
        
        if (Item3::exist($nama) == 0) {
            
            return view('cashier.stock3_update')->withErrors('Nama item tidak terdaftar')->with('nama', $nama)->with('jumlah', $jumlah);
        }
	
	if (Item::exist($nama) != 0){
            $stok_utama = Item::getStock($nama);
            if ($jumlah > $stok_utama){
                return view('cashier.stock3_update')->withErrors('Jumlah penambahan melebihi jumlah di gudang utama')->with('nama', $nama)->with('jumlah', $jumlah);
            }
            else{
                Item::minStock($nama, $jumlah);
            }
        }
        
        Item3::addStock($nama, $jumlah);
        
        return view('cashier.stock3_update_proof')
            ->with('jumlah', $jumlah)
            ->with('nama', $nama)
            ->with('id', $id);
    }
    
    public function update_stock3_print(){

        return view('cashier.stock3')->with('itemList', Item3::all());
    }
    
    public function deleteItem3(){
        Item3::deleteItemWithNama(Input::get('nama'));
        return view('cashier.stock3')->with('itemList', Item3::all());
    }

}
