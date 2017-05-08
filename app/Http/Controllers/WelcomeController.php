<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Ruang;

class WelcomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('welcome');
	}

	public function statusRuang(){
		$data = Ruang::all()->where('lantai', '3');
		return view('ruang-3')->with('data', $data);
	}

	public function setActive($id){
		Ruang::setAvailable($id);
		$data = Ruang::all()->where('lantai', '3');
		return view('ruang-3')->with('data', $data);
	}	

	public function setInactive($id){
		Ruang::setRoomUnavailable($id);
		$data = Ruang::all()->where('lantai', '3');
		return view('ruang-3')->with('data', $data);
	}

	public function statusRuang2(){
		$data = Ruang::all()->where('lantai', '4');
		return view('ruang-4')->with('data', $data);
	}

	public function setActive2($id){
		Ruang::setAvailable($id);
		$data = Ruang::all()->where('lantai', '4');
		return view('ruang-4')->with('data', $data);
	}	

	public function setInactive2($id){
		Ruang::setRoomUnavailable($id);
		$data = Ruang::all()->where('lantai', 4);
		return view('ruang-4')->with('data', $data);
	}
}
