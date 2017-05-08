<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Gelang;
use App\Room;
use App\Fasilitas;
use App\Periode;
use App\Item2;
use App\TransaksiBar;
use Validator, Input, Redirect, Hash, Auth; 

class Restoran2Controller extends Controller{
    
    public function restoran(){
        if(Periode::activeExist() == 1){
            $noGelang = Input::get('noGelang');
            
            if(Gelang::checkAvailable($noGelang) != 0) {
                $saldo = Gelang::getSaldo($noGelang);

                $makananlist = Item2::where('jenis', 'Makanan')->get();
                $minumanlist = Item2::where('jenis', 'Minuman')->get();
                $rokoklist = Item2::where('jenis', 'Rokok')->get();        

                return view('restoran2.menu')
                    ->with('noGelang', $noGelang)
                    ->with('saldo', $saldo)
                    ->with('makananlist', $makananlist)
                    ->with('minumanlist', $minumanlist)
                    ->with('rokoklist', $rokoklist);
            }
            return redirect('restoran2')->withErrors("Nomor kartu pelanggan belum dipakai");
        }
        return redirect('restoran2')->withErrors('Transaksi belum dibuka');    
    }

    public function review(){
        if(Periode::activeExist() == 1){
            $noGelang = Input::get('noGelang');
            $iditem = Input::get('id_item');
            $jumlahbeli = Input::get('jumlahbeli');
            
            $pesanan = array();
            $total = 0;

            foreach($iditem as $index => $id) {
                if($jumlahbeli[$index] > 0){
                    array_push($pesanan, 
                        [
                            'index' => $index,
                            'qty' => $jumlahbeli[$index],
                            'id_item' => $id,
                            'nama' => Item2::getNama($id),                      
                            'price' => Item2::getPrice($id),
                            'jumlah' => Item2::getPrice($id) * $jumlahbeli[$index]
                        ]
                    );
                    $total += Item2::getPrice($id) * $jumlahbeli[$index];
                }
            }
            return view('restoran2.review')
                ->with('noGelang', $noGelang)
                ->with('pesanan', $pesanan)
                ->with('iditem', $iditem)
                ->with('jumlahbeli', $jumlahbeli)    
                ->with('total', $total);
        }
        return redirect('restoran2')->withErrors('Transaksi belum dibuka');
    }

    public function delete($id) {
        if(Periode::activeExist() == 1){
            $pesanan = array();
            $total = 0;
            
            $noGelang = Input::get('noGelang');
            $iditem = Input::get('id_item');
            $jumlahbeli = Input::get('jumlahbeli');

            $jumlahbeli[$id] = 0;

            foreach($iditem as $index => $item) {

                if($jumlahbeli[$index] > 0){
                    array_push($pesanan, 
                        [
                            'index' => $index,
                            'qty' => $jumlahbeli[$index],
                            'id_item' => $item,
                            'nama' => Item2::getNama($item),                      
                            'price' => Item2::getPrice($item),
                            'jumlah' => Item2::getPrice($item) * $jumlahbeli[$index]
                        ]
                    );
                    $total += Item2::getPrice($item) * $jumlahbeli[$index];
                }
            }
            if($pesanan != NULL){
                return view('restoran2.review')
                    ->with('noGelang', $noGelang)
                    ->with('pesanan', $pesanan)
                    ->with('iditem', $iditem)
                    ->with('jumlahbeli', $jumlahbeli)    
                    ->with('total', $total);
            }else{
                return view('restoran2.menu')
                    ->with('noGelang', $noGelang)
                    ->with('saldo', Gelang::getSaldo($noGelang))
                    ->with('makananlist', Item2::where('jenis', 'Makanan')->get())
                    ->with('minumanlist', Item2::where('jenis', 'Minuman')->get())
                    ->with('rokoklist', Item2::where('jenis', 'Rokok')->get())
                    ->with('total', $total);
            }
        }
        return redirect('restoran2')->withErrors('Transaksi belum dibuka');
    }

    public function invoice(){
        if(Periode::activeExist() == 1){
            $noGelang = Input::get('noGelang');
            $iditem = Input::get('id_item');
            $jumlahbeli = Input::get('jumlahbeli');
            
            $pesanan = array();

            $total = 0;

            foreach($iditem as $index => $id) {
                if($jumlahbeli[$index] > 0){
                    if(Item2::getStockById($id) < $jumlahbeli[$index]){
                        return redirect('restoran')->withErrors('Stok '.Item2::getNama($id).' tidak tersedia');
                    }
                    array_push($pesanan, 
                        [
                            'qty' => $jumlahbeli[$index],
                            'nama' => Item2::getNama($id),                      
                            'jumlah' => Item2::getPrice($id) * $jumlahbeli[$index]
                        ]
                    );
                    $total += Item2::getPrice($id) * $jumlahbeli[$index];
                }
            }
        
            $saldo = Gelang::getSaldo($noGelang);
            
            if($total <= $saldo){
                foreach($iditem as $index => $id) {
                    if($jumlahbeli[$index] > 0){
                        Item2::kurangStock($id, $jumlahbeli[$index]);
                        TransaksiBar2::add($id, $jumlahbeli[$index], $noGelang);
                    }
                }

                Gelang::minSaldo(Input::get('noGelang'), $total);    

                return view('restoran2.invoice')
                    ->with('noGelang', Input::get('noGelang'))
                    ->with('transaksiBar', $pesanan)
                    ->with('totalTransaksiBar', $total)
                    ->with('transaksiBar1', $iditem)
                    ->with('transaksiBar2', $jumlahbeli)
                    ->with('sisa' , Gelang::getSaldo($noGelang))
                    ->with('saldo', $saldo)
                    ->with('date', date('Y-m-d H:i:s'));
            }
            else{
                return redirect('restoran2')->withErrors('Saldo anda tidak mencukupi');
            }
        }
        return redirect('restoran2')->withErrors('Transaksi belum dibuka');
    }

    public function back(){
        if(Periode::activeExist() == 1){
            $noGelang = Input::get('noGelang');
            $iditem = Input::get('id_item');
            $jumlahbeli = Input::get('jumlahbeli');
            $total = Input::get('total');

            $jml = array();

            foreach ($iditem as $index => $item) {
                if($jumlahbeli[$index] > 0){
                    $jml[$item] = $jumlahbeli[$index];
                }
            }

            $makananlist = Item2::where('jenis', 'Makanan')->get();
            $minumanlist = Item2::where('jenis', 'Minuman')->get();
            $rokoklist = Item2::where('jenis', 'Rokok')->get();        

            return view('restoran2.menu')
                ->with('noGelang', $noGelang)
                ->with('saldo', Gelang::getSaldo($noGelang))
                ->with('makananlist', $makananlist)
                ->with('minumanlist', $minumanlist)
                ->with('rokoklist', $rokoklist)
                ->with('jml', $jml)
                ->with('total', $total);
        }
        return redirect('restoran2')->withErrors('Transaksi belum dibuka');    
    }

    public function ob(){
        if(Periode::activeExist() == 1){
            $noGelang = Input::get('noGelang');
            $saldo = Gelang::getSaldo($noGelang);
            $itemList = Item2::where('jenis', 'OB')->get();
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

            return view('restoran2.ob')
                    ->with('noGelang', $noGelang)
                    ->with('saldo', $saldo)
                    ->with('itemList', $pesanan);
        }
        return redirect('restoran2')->withErrors('Transaksi belum dibuka');
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
                                'nama' => Item2::getNama($id),                      
                                'jumlah' => Item2::getPrice($id) * $jumlahbeli[$index]
                            ]
                        );
                        $total += Item2::getPrice($id) * $jumlahbeli[$index];
                    }
                }
            
                $saldo = Gelang::getSaldo($noGelang);
                
                Gelang::minSaldo(Input::get('noGelang'), $total);
                
                foreach($iditem as $index => $id) {
                    if($jumlahbeli[$index] > 0){
                        Item2::kurangStock($id, $jumlahbeli[$index]);
                        TransaksiBar2::add($id, $jumlahbeli[$index], $noGelang);
                    }
                }

                return view('restoran2.invoice')
                    ->with('noGelang', Input::get('noGelang'))
                    ->with('transaksiBar', $pesanan)
                    ->with('totalTransaksiBar', $total)
                    ->with('transaksiBar1', $iditem)
                    ->with('transaksiBar2', $jumlahbeli)
                    ->with('sisa' , Gelang::getSaldo($noGelang))
                    ->with('saldo', $saldo)
                    ->with('date', date('Y-m-d H:i:s'));
            }

        }
        return redirect('restoran2')->withErrors('Transaksi belum dibuka');
    }
}
