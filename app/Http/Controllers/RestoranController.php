<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Gelang;
use App\Room;
use App\Fasilitas;
use App\Periode;
use App\Item;
use App\Item2;
use App\Item3;
use App\TransaksiBar;
use Validator, Input, Redirect, Hash, Auth; 

class RestoranController extends Controller{
    
    public function restoran(){
        if(Periode::activeExist() == 1){
            $noGelang = Input::get('noGelang');
            
            if(Gelang::checkAvailable($noGelang) != 0) {
                return view('restoran.menu')
                    ->with('noGelang', $noGelang);
            }   
            return redirect('restoran')->withErrors("Nomor kartu pelanggan belum dipakai");
        }
        return redirect('restoran')->withErrors('Transaksi belum dibuka');    
    }

    public function ob(){
        if(Periode::activeExist() == 1){
            $noGelang = Input::get('noGelang');
            $saldo = Gelang::getSaldo($noGelang);
            $itemList = Item::where('jenis', 'OB')->get();
            $pesanan = array();

            foreach ($itemList as $index => $item) {
                array_push($pesanan, 
                    [
                        'id_item' => $item->id_item,
                        'nama' => $item->nama,
                        'stock' => $item->stock,
                        'price' => $item->price                      
                    ]
                );
            }

            return view('restoran.ob')
                    ->with('noGelang', $noGelang)
                    ->with('saldo', $saldo)
                    ->with('itemList', $pesanan);
        }
        return redirect('restoran')->withErrors('Transaksi belum dibuka');
    }

    public function obOrder(){
        if(Periode::activeExist() == 1){
            $noGelang = Input::get('noGelang');

            $pesanan = array();

            $iditem = Input::get('id_item');
            $jumlahbeli = Input::get('jumlahbeli');
            
            $jumlah = 0;
            foreach($jumlahbeli as $jb){
                $jumlah += $jb;
            }

            if($jumlah > 0){
                $total = 0;

                foreach($iditem as $index => $id) {
                    if($jumlahbeli[$index] > 0){
                        array_push($pesanan, 
                            [
                                'qty' => $jumlahbeli[$index],
                                'nama' => Item::getNama($id) . ' @ ' . Item::getPrice($id),                      
                                'jumlah' => Item::getPrice($id) * $jumlahbeli[$index]
                            ]
                        );
                        $total += Item::getPrice($id) * $jumlahbeli[$index];
                    }
                }
            
                $saldo = Gelang::getSaldo($noGelang);
                
                Gelang::minSaldo(Input::get('noGelang'), $total);
                
                foreach($iditem as $index => $id) {
                    if($jumlahbeli[$index] > 0){
                        Item::kurangStock($id, $jumlahbeli[$index]);
                        TransaksiBar::add($id, $jumlahbeli[$index], $noGelang);
                    }
                }

                return view('restoran.invoice')
                    ->with('noGelang', Input::get('noGelang'))
                    ->with('transaksiBar', $pesanan)
                    ->with('totalTransaksiBar', $total)
                    ->with('transaksiBar1', $iditem)
                    ->with('transaksiBar2', $jumlahbeli)
                    ->with('sisa' , Gelang::getSaldo($noGelang))
                    ->with('saldo', $saldo);
            }

        }
        return redirect('restoran')->withErrors('Transaksi belum dibuka');
    }

    public function makanan(){
        if(Periode::activeExist() == 1){
            $noGelang = Input::get('noGelang');
            $saldo = Gelang::getSaldo($noGelang);
            $itemList = Item::where('jenis', 'Makanan')->get();
            $pesanan = array();

            foreach ($itemList as $index => $item) {
                array_push($pesanan, 
                    [
                        'id_item' => $item->id_item,
                        'nama' => $item->nama,
                        'stock' => $item->stock,
                        'price' => $item->price                      
                    ]
                );
            }

            return view('restoran.makanan-list')
                    ->with('noGelang', $noGelang)
                    ->with('saldo', $saldo)
                    ->with('itemList', $pesanan);
        }
        return redirect('restoran')->withErrors('Transaksi belum dibuka');
    }

    public function makananReview(){
        if(Periode::activeExist() == 1){
            $noGelang = Input::get('noGelang');
            
            $pesanan = array();

            $iditem = Input::get('id_item');
            $jumlahbeli = Input::get('jumlahbeli');
            
            $total = 0;

            foreach($iditem as $index => $id) {
                if($jumlahbeli[$index] > 0){
                    array_push($pesanan, 
                        [
                            'index' => $index,
                            'qty' => $jumlahbeli[$index],
                            'id_item' => $id,
                            'nama' => Item::getNama($id),                      
                            'price' => Item::getPrice($id),
                            'jumlah' => Item::getPrice($id) * $jumlahbeli[$index]
                        ]
                    );
                    $total += Item::getPrice($id) * $jumlahbeli[$index];
                }
            }
            return view('restoran.makanan-review')
                ->with('noGelang', $noGelang)
                ->with('pesanan', $pesanan)
                ->with('iditem', $iditem)
                ->with('jumlahbeli', $jumlahbeli);    
        }
        return redirect('restoran')->withErrors('Transaksi belum dibuka');
    }

    public function makananDelete() {
        if(Periode::activeExist() == 1){
            $pesanan = array();
            $total = 0;
            
            $noGelang = Input::get('noGelang');
            $iditem = Input::get('id_item');
            $jumlahbeli = Input::get('jumlahbeli');
            $idn = Input::get('idarray');

            unset($iditem[$idn]);
            unset($jumlahbeli[$idn]);

            foreach($iditem as $index => $id) {
                if($jumlahbeli[$index] > 0){
                    array_push($pesanan, 
                        [
                            'index' => $index,
                            'qty' => $jumlahbeli[$index],
                            'id_item' => $id,
                            'nama' => Item::getNama($id),                      
                            'price' => Item::getPrice($id),
                            'jumlah' => Item::getPrice($id) * $jumlahbeli[$index]
                        ]
                    );
                    $total += Item::getPrice($id) * $jumlahbeli[$index];
                }
            }
            if($pesanan != NULL){
                return view('restoran.makanan-review')
                    ->with('noGelang', $noGelang)
                    ->with('pesanan', $pesanan)
                    ->with('iditem', $iditem)
                    ->with('jumlahbeli', $jumlahbeli);    
            }else{
                return view('restoran.menu')
                    ->with('noGelang', $noGelang);
            }
        }
        return redirect('restoran')->withErrors('Transaksi belum dibuka');
    }

    public function makananBeli(){
        if(Periode::activeExist() == 1){
            $noGelang = Input::get('noGelang');

            $pesanan = array();

            $iditem = Input::get('id_item');
            $jumlahbeli = Input::get('jumlahbeli');
            
            $jumlah = 0;
            foreach($jumlahbeli as $jb){
                $jumlah += $jb;
            }

            if($jumlah > 0){
                $total = 0;

                foreach($iditem as $index => $id) {
                    if($jumlahbeli[$index] > 0){
                        array_push($pesanan, 
                            [
                                'qty' => $jumlahbeli[$index],
                                'nama' => Item::getNama($id) . ' @ ' . Item::getPrice($id),                      
                                'jumlah' => Item::getPrice($id) * $jumlahbeli[$index]
                            ]
                        );
                        $total += Item::getPrice($id) * $jumlahbeli[$index];
                    }
                }
            
                $saldo = Gelang::getSaldo($noGelang);
                $sisa = $saldo - $total;
                if($sisa < 0) {
                    return view('restoran.makanan-list')
                        ->with('itemList', Item::where('jenis', 'Makanan')->get())
                        ->with('jumlahbeli', $jumlahbeli)
                        ->with('id_item', $iditem)
                        ->with('noGelang', $noGelang)
                        ->withErrors('Saldo tidak mencukupi');
                }
                
                Gelang::minSaldo(Input::get('noGelang'), $total);
                
                foreach($iditem as $index => $id) {
                    if($jumlahbeli[$index] > 0){
                        Item::kurangStock($id, $jumlahbeli[$index]);
                        TransaksiBar::add($id, $jumlahbeli[$index], $noGelang);
                    }
                }

                return view('restoran.invoice')
                    ->with('noGelang', Input::get('noGelang'))
                    ->with('transaksiBar', $pesanan)
                    ->with('totalTransaksiBar', $total)
                    ->with('transaksiBar1', $iditem)
                    ->with('transaksiBar2', $jumlahbeli)
                    ->with('sisa' , Gelang::getSaldo($noGelang))
                    ->with('saldo', $saldo);
            }

        }
        return redirect('restoran')->withErrors('Transaksi belum dibuka');
    }

    public function minuman(){
        if(Periode::activeExist() == 1){
            $noGelang = Input::get('noGelang');
            $saldo = Gelang::getSaldo($noGelang);
            $itemList = Item::where('jenis', 'Minuman')->get();
            $pesanan = array();

            foreach ($itemList as $index => $item) {
                array_push($pesanan, 
                    [
                        'id_item' => $item->id_item,
                        'nama' => $item->nama,
                        'stock' => $item->stock,
                        'price' => $item->price                      
                    ]
                );
            }

            return view('restoran.minuman-list')
                    ->with('noGelang', $noGelang)
                    ->with('saldo', $saldo)
                    ->with('itemList', $pesanan);
        }
        return redirect('restoran')->withErrors('Transaksi belum dibuka');
    }

    public function minumanReview(){
        if(Periode::activeExist() == 1){
            $noGelang = Input::get('noGelang');
            
            $pesanan = array();

            $iditem = Input::get('id_item');
            $jumlahbeli = Input::get('jumlahbeli');
            
            $total = 0;

            foreach($iditem as $index => $id) {
                if($jumlahbeli[$index] > 0){
                    array_push($pesanan, 
                        [
                            'index' => $index,
                            'qty' => $jumlahbeli[$index],
                            'id_item' => $id,
                            'nama' => Item::getNama($id),                      
                            'price' => Item::getPrice($id),
                            'jumlah' => Item::getPrice($id) * $jumlahbeli[$index]
                        ]
                    );
                    $total += Item::getPrice($id) * $jumlahbeli[$index];
                }
            }
            return view('restoran.minuman-review')
                ->with('noGelang', $noGelang)
                ->with('pesanan', $pesanan)
                ->with('iditem', $iditem)
                ->with('jumlahbeli', $jumlahbeli);    
        }
        return redirect('restoran')->withErrors('Transaksi belum dibuka');
    }

    public function minumanDelete() {
        if(Periode::activeExist() == 1){
            $pesanan = array();
            $total = 0;
            
            $noGelang = Input::get('noGelang');
            $iditem = Input::get('id_item');
            $jumlahbeli = Input::get('jumlahbeli');
            $idn = Input::get('idarray');

            unset($iditem[$idn]);
            unset($jumlahbeli[$idn]);

            foreach($iditem as $index => $id) {
                if($jumlahbeli[$index] > 0){
                    array_push($pesanan, 
                        [
                            'index' => $index,
                            'qty' => $jumlahbeli[$index],
                            'id_item' => $id,
                            'nama' => Item::getNama($id),                      
                            'price' => Item::getPrice($id),
                            'jumlah' => Item::getPrice($id) * $jumlahbeli[$index]
                        ]
                    );
                    $total += Item::getPrice($id) * $jumlahbeli[$index];
                }
            }
            if($pesanan != NULL){
                return view('restoran.minuman-review')
                    ->with('noGelang', $noGelang)
                    ->with('pesanan', $pesanan)
                    ->with('iditem', $iditem)
                    ->with('jumlahbeli', $jumlahbeli);    
            }else{
                return view('restoran.menu')
                    ->with('noGelang', $noGelang);
            }
        }
        return redirect('restoran')->withErrors('Transaksi belum dibuka');
    }

    public function minumanBeli(){
        if(Periode::activeExist() == 1){
            $noGelang = Input::get('noGelang');

            $pesanan = array();

            $iditem = Input::get('id_item');
            $jumlahbeli = Input::get('jumlahbeli');
            
            $jumlah = 0;
            foreach($jumlahbeli as $jb){
                $jumlah += $jb;
            }

            if($jumlah > 0){
                $total = 0;

                foreach($iditem as $index => $id) {
                    if($jumlahbeli[$index] > 0){
                        array_push($pesanan, 
                            [
                                'qty' => $jumlahbeli[$index],
                                'nama' => Item::getNama($id) . ' @ ' . Item::getPrice($id),                      
                                'jumlah' => Item::getPrice($id) * $jumlahbeli[$index]
                            ]
                        );
                        $total += Item::getPrice($id) * $jumlahbeli[$index];
                    }
                }
            
                $saldo = Gelang::getSaldo($noGelang);
                $sisa = $saldo - $total;
                if($sisa < 0) {
                    return view('restoran.minuman-list')
                        ->with('itemList', Item::where('jenis', 'Minuman')->get())
                        ->with('jumlahbeli', $jumlahbeli)
                        ->with('id_item', $iditem)
                        ->with('noGelang', $noGelang)
                        ->withErrors('Saldo tidak mencukupi');
                }
                
                Gelang::minSaldo(Input::get('noGelang'), $total);
                
                foreach($iditem as $index => $id) {
                    if($jumlahbeli[$index] > 0){
                        Item::kurangStock($id, $jumlahbeli[$index]);
                        TransaksiBar::add($id, $jumlahbeli[$index], $noGelang);
                    }
                }

                return view('restoran.invoice')
                    ->with('noGelang', Input::get('noGelang'))
                    ->with('transaksiBar', $pesanan)
                    ->with('totalTransaksiBar', $total)
                    ->with('transaksiBar1', $iditem)
                    ->with('transaksiBar2', $jumlahbeli)
                    ->with('sisa' , Gelang::getSaldo($noGelang))
                    ->with('saldo', $saldo);
            }

        }
        return redirect('restoran')->withErrors('Transaksi belum dibuka');
    }

    public function rokok(){
        if(Periode::activeExist() == 1){
            $noGelang = Input::get('noGelang');
            $saldo = Gelang::getSaldo($noGelang);
            $itemList = Item::where('jenis', 'Rokok')->get();
            $pesanan = array();

            foreach ($itemList as $index => $item) {
                array_push($pesanan, 
                    [
                        'id_item' => $item->id_item,
                        'nama' => $item->nama,
                        'stock' => $item->stock,
                        'price' => $item->price                      
                    ]
                );
            }

            return view('restoran.rokok-list')
                    ->with('noGelang', $noGelang)
                    ->with('saldo', $saldo)
                    ->with('itemList', $pesanan);
        }
        return redirect('restoran')->withErrors('Transaksi belum dibuka');
    }

    public function rokokReview(){
        if(Periode::activeExist() == 1){
            $noGelang = Input::get('noGelang');
            
            $pesanan = array();

            $iditem = Input::get('id_item');
            $jumlahbeli = Input::get('jumlahbeli');
            
            $total = 0;

            foreach($iditem as $index => $id) {
                if($jumlahbeli[$index] > 0){
                    array_push($pesanan, 
                        [
                            'index' => $index,
                            'qty' => $jumlahbeli[$index],
                            'id_item' => $id,
                            'nama' => Item::getNama($id),                      
                            'price' => Item::getPrice($id),
                            'jumlah' => Item::getPrice($id) * $jumlahbeli[$index]
                        ]
                    );
                    $total += Item::getPrice($id) * $jumlahbeli[$index];
                }
            }
            return view('restoran.rokok-review')
                ->with('noGelang', $noGelang)
                ->with('pesanan', $pesanan)
                ->with('iditem', $iditem)
                ->with('jumlahbeli', $jumlahbeli);    
        }
        return redirect('restoran')->withErrors('Transaksi belum dibuka');
    }

    public function rokokDelete() {
        if(Periode::activeExist() == 1){
            $pesanan = array();
            $total = 0;
            
            $noGelang = Input::get('noGelang');
            $iditem = Input::get('id_item');
            $jumlahbeli = Input::get('jumlahbeli');
            $idn = Input::get('idarray');

            unset($iditem[$idn]);
            unset($jumlahbeli[$idn]);

            foreach($iditem as $index => $id) {
                if($jumlahbeli[$index] > 0){
                    array_push($pesanan, 
                        [
                            'index' => $index,
                            'qty' => $jumlahbeli[$index],
                            'id_item' => $id,
                            'nama' => Item::getNama($id),                      
                            'price' => Item::getPrice($id),
                            'jumlah' => Item::getPrice($id) * $jumlahbeli[$index]
                        ]
                    );
                    $total += Item::getPrice($id) * $jumlahbeli[$index];
                }
            }
            if($pesanan != NULL){
                return view('restoran.rokok-review')
                    ->with('noGelang', $noGelang)
                    ->with('pesanan', $pesanan)
                    ->with('iditem', $iditem)
                    ->with('jumlahbeli', $jumlahbeli);    
            }else{
                return view('restoran.menu')
                    ->with('noGelang', $noGelang);
            }
        }
        return redirect('restoran')->withErrors('Transaksi belum dibuka');
    }

    public function rokokBeli(){
        if(Periode::activeExist() == 1){
            $noGelang = Input::get('noGelang');

            $pesanan = array();

            $iditem = Input::get('id_item');
            $jumlahbeli = Input::get('jumlahbeli');
            
            $jumlah = 0;
            foreach($jumlahbeli as $jb){
                $jumlah += $jb;
            }

            if($jumlah > 0){
                $total = 0;

                foreach($iditem as $index => $id) {
                    if($jumlahbeli[$index] > 0){
                        array_push($pesanan, 
                            [
                                'qty' => $jumlahbeli[$index],
                                'nama' => Item::getNama($id) . ' @ ' . Item::getPrice($id),                      
                                'jumlah' => Item::getPrice($id) * $jumlahbeli[$index]
                            ]
                        );
                        $total += Item::getPrice($id) * $jumlahbeli[$index];
                    }
                }
            
                $saldo = Gelang::getSaldo($noGelang);
                $sisa = $saldo - $total;
                if($sisa < 0) {
                    return view('restoran.rokok-list')
                        ->with('itemList', Item::where('jenis', 'Rokok')->get())
                        ->with('jumlahbeli', $jumlahbeli)
                        ->with('id_item', $iditem)
                        ->with('noGelang', $noGelang)
                        ->withErrors('Saldo tidak mencukupi');
                }
                
                Gelang::minSaldo(Input::get('noGelang'), $total);
                
                foreach($iditem as $index => $id) {
                    if($jumlahbeli[$index] > 0){
                        Item::kurangStock($id, $jumlahbeli[$index]);
                        TransaksiBar::add($id, $jumlahbeli[$index], $noGelang);
                    }
                }

                return view('restoran.invoice')
                    ->with('noGelang', Input::get('noGelang'))
                    ->with('transaksiBar', $pesanan)
                    ->with('totalTransaksiBar', $total)
                    ->with('transaksiBar1', $iditem)
                    ->with('transaksiBar2', $jumlahbeli)
                    ->with('sisa' , Gelang::getSaldo($noGelang))
                    ->with('saldo', $saldo);
            }

        }
        return redirect('restoran')->withErrors('Transaksi belum dibuka');
    }
}
