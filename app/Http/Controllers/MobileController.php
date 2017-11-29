<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Redirect;
use Hash;
use DateTime;
use App\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Routing\Controller;
use App\ToDoList;
use App\Item;
use Carbon\Carbon;
use App\Category;

class MobileController extends Controller
{
    public function login(Request $req){
		$userdata = array(
            'username'    => $req['username'],
            'password' => $req['password']
        );

        if(Auth::attempt($userdata))
            return response()->json(['message'=> 'Login Berhasil', 'code'=> '200','user'=>Auth::User()]);
        return response()->json(['message'=> 'Username dan password tidak tepat.', 'code'=> '401']);
    }

    public function register(Request $req){
        date_default_timezone_set('Asia/Jakarta');
        $current = Carbon::now()->format('y-m-d H:i:s');
        $day = Carbon::now()->format('D');
		$bbIdeal = ($req['TB'] - 100) * 0.9;
		$aktivitas = 0;
		$kalori = 0;
		$umur = $req['umur'];
		$aktivitass = "";

		switch ($req['aktivitas']) {
			case 'Sangat Ringan':
				$aktivitas = 1.2;
				$aktivitass = "Rest";
				break;
			case 'Ringan':
                $aktivitas = 1.375;
				$aktivitass = "Light";
                break;
            case 'Biasa':
                $aktivitas = 1.55;
                $aktivitass = "Normal";
                break;
            case 'Berat':
                $aktivitas = 1.725;
                $aktivitass = "Heavy";
                break;
            case 'Sangat Berat':
                $aktivitas = 1.9;
                $aktivitass = "Very Heavy";
                break;
            default:
                $aktivitas = 1.55;
                $aktivitass = "Normal";
                break;
		}

		if ($req['JK'] == 'Male')
			$kalori = 66 + (13.7 * $req['BB']) + (5 * $req['TB']) - (6.8 * $umur);
		else
			$kalori = 655 + (9.6 * $req['BB']) + (1.8 * $req['TB']) - (4.7 * $umur);

        $kalori *= $aktivitas;

        if($req['BB'] < $bbIdeal)
            $kalori -= 500;
        else if($req['BB'] > $bbIdeal)
            $kalori += 500;
		$kalori = round($kalori);
        $protein = round($kalori * 0.15);
		$lemak = round($kalori * 0.25);
		$karbo = $kalori - $protein - $lemak;
		$imt = round($req['BB']/($req['TB']*$req['TB']/10000));

    	$userdata = array(
    		'username' => $req['username'],
    		'password' => bcrypt($req['password']),
    		'access_id' => '2',
    		'first_name' => $req['namaDepan'],
    		'last_name' => $req['namaBelakang'], 
    		'email' => $req['email'],
    		'gender' => $req['JK'],
    		'height' => $req['TB'],
    		'weight' => $req['BB'],
    		'birthday' => date_format(date_create($req['tglLahir']), "Y/m/d"),
    		'imt' => $imt,
    		'protein' => $protein,
    		'fat' => $lemak,
    		'carbohydrate' => $karbo,
    		'calories' => $kalori,
    		'bb_ideal' => $bbIdeal,
    		'physic_activity' => $aktivitass,
    		'last_login' => $current
    	);
        // dd($data);
        $existUs = User::where('username', $userdata['username'])->exists();
        $existEmail = User::where('email', $userdata['email'])->exists();
        // dd($existUs);
        if (! $existUs){
            if (! $existEmail){
                $tambahUser = DB::table('user')->insert($userdata);  
                if ($tambahUser){
	                $id = DB::table('user')
	                      ->select('id')
	                      ->orderby('id', 'desc')
	                      ->first();
	                DB::table('notification')
	                ->insert(['user_id'=>$id->id, 'information'=>'Daftar pada hari ' . $day, 'time'=>$current]);
	            	return response()->json(['message'=> 'Daftar akun berhasil', 'code'=> '200']);
	            }
	            else{
	            	return response()->json(['message'=> 'Terjadi kesalahan. Periksa kembali data anda', 'code'=>'401']);
	            }
            }
            else{
		        return response()->json(['message'=> 'Email sudah ada', 'code'=> '401']);
            }
        }
        else{
		    return response()->json(['message'=> 'Username sudah ada', 'code'=> '401']);
        }
    }
}
