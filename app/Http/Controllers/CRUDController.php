<?php

namespace App\Http\Controllers;
use App\Http\Requests\validasiRegister;
use App\Http\Requests\validasiLogin;
use App\Http\Requests\validasiEmail;
use Illuminate\Http\Request;
use Auth;
use DB;
use Redirect;
use Hash;
use App\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Routing\Controller;
use App\ToDoList;
use App\Item;
use Carbon\Carbon;
use App\Category;

class CRUDController extends Controller
{
    public function login(validasiLogin $validasi){
        date_default_timezone_set('Asia/Jakarta');
        $username = Input::get('username');
        $password = Input::get('password');
        $email = Input::get('email');
        $current = Carbon::now()->format('y-m-d H:i:s');
        $day = Carbon::now()->format('D');

    	if (Auth::attempt(['username' => $username, 'password' => $password])){
            $userId = User::select('id')->where('username', $username)->first();
            DB::table('notification')
            ->insert(['user_id'=>$userId->id, 'information'=>'Login pada hari ' . $day, 'time'=>$current]);
    		return Redirect::to('/todolist');
        }
        else if (Auth::atempt(['email' => $email, 'password' => $password])){
            $data = User::select('id')->where('email', $email)->get();
            $data = $data[0];
            $email = $data->email;
            User::where('id', $email)->update(['last_login'=>Carbon::now()->format('y-m-d')]);
            return Redirect::to('/todolist');
        }
    	else
    		return Redirect::to('/')->with('msglogin', 'username atau password tidak ditemukan');
    }

    public function logout(){
        date_default_timezone_set('Asia/Jakarta');
        $current = Carbon::now()->format('y-m-d H:i:s');
        $day = Carbon::now()->format('D');
        DB::table('notification')
        ->insert(['user_id'=>Auth::user()->id, 'information'=>'Logout pada hari ' . $day, 'time'=>$current]);
        $current = '1990-01-01 0:0:0';
        User::where('id', Auth::user()->id)
        ->update(['last_login'=>$current]);
        Auth::logout();
        return Redirect::to('/')->with('messages', 'Berhasil logout');
    }
    public function register(validasiRegister $data){
        date_default_timezone_set('Asia/Jakarta');
        $current = Carbon::now()->format('y-m-d H:i:s');
        $day = Carbon::now()->format('D');
    	$data = array(
    		'username' => Input::get('usernames'),
    		'password' => bcrypt(Input::get('passwords')),
    		'access_id' => '2',
    		'first_name' => Input::get('first_name'),
    		'last_name' => Input::get('last_name'), 
    		'email' => Input::get('emails'),
    		'gender' => Input::get('gender'),
    		'height' => Input::get('height'),
    		'weight' => Input::get('weight'),
    		'birthday' => Input::get('birthday'),
    		'imt' => Input::get('imt'),
    		'protein' => Input::get('protein'),
    		'fat' => Input::get('lipid'),
    		'carbohydrate' => Input::get('carbohydrate'),
    		'bb_ideal' => Input::get('ideal'),
    		'physic_activity' => Input::get('activity'),
            'calories' => Input::get('calories'),
    		'last_login' => $current
    	);
        // dd($data);
        $existUs = User::where('username', $data['username'])->exists();
        $existEmail = User::where('email', $data['email'])->exists();
        if (! $existUs){
            if (! $existEmail){
                DB::table('user')->insert($data);  
                $id = DB::table('user')
                      ->select('id')
                      ->orderby('id', 'desc')
                      ->get();
                DB::table('notification')
                ->insert(['user_id'=>$id[0]->id, 'information'=>'Daftar pada hari ' . $day, 'time'=>$current]);
    	       return Redirect::to('/todolist')->with('messages', 'berhasil daftar, silahkan login');
            }
            else{
                return Redirect::to('/register')->with('message', 'email sudah ada');
            }
        }
        else{
            return Redirect::to('/register')->with('message', 'username sudah ada');
        }
    }

    public function forgotPassword(validasiEmail $data){
        date_default_timezone_set('Asia/Jakarta');
        $current = Carbon::now()->format('y-m-d H:i:s');
        $day = Carbon::now()->format('D');
        $email = $data->email;
        $count = DB::table('user')->where('email', '=', $email)->count();
        if ($count < 1)
            return Redirect::to('/forgotpassword')->with('message', 'email tidak terdaftar');
        else{
            $id = DB::table('user')
                  ->select('id')
                  ->where('email', $email)
                  ->first();
            DB::table('notification')
            ->insert(['user_id'=>$id->id, 'information'=>'Mereset password pada hari ' . $day, 'time'=>$current]);
            return Redirect::to('testing');
        }
    }

    public function index(Request $request){
        $to_do_list_dtl = ToDoList::latest()->paginate(5);
        return response()->json($to_do_list_dtl);
    }

    public function resetall($date){
        $listid = DB::table('to_do_list')
                  ->select('id')
                  ->where('date', $date)
                  ->where('user_id', Auth::user()->id)
                  ->get();

        for($i=1;$i<=6;$i++){
            DB::table('to_do_list_dtl')
            ->where('list_id', $listid[$i-1]->id)
            ->delete();

            if ($i <= 3){
                DB::table('recommended')
                ->where('list_id', $listid[$i-1]->id)
                ->delete();
            }
        }

        DB::table('history')
        ->where('user_id', Auth::user()->id)
        ->where('date', $date)
        ->delete();

        return Redirect::to('todolist');
    }

    public function todolist(){
        if (Auth::user()){
            date_default_timezone_set('Asia/Jakarta');
            $current = date("Y-m-d H:m:s");
            $userId = Auth::user()->id;
            User::where('id', $userId)
            ->update(['last_login'=>$current]);
            $now = Carbon::now()->format('y-m-d');
            $userfullname = Auth::user()->first_name . " " . Auth::user()->last_name;
            if (Auth::user()->access_id == '2'){
                $exist = DB::table('steps')
                         ->where('user_id', $userId)
                         ->where('date', $now)
                         ->exists();
                if (! $exist){
                    DB::table('steps')
                    ->insert(['user_id'=>$userId, 'user_fullname'=>$userfullname, 'date'=>$now]);
                }

                $streak = DB::table('streak')
                        ->select('best_streak', 'now_streak')
                        ->where('user_id', $userId)
                        ->first();                        

                for($i=1;$i<=7;$i++){
                    $cat = Category::select('id', 'category')
                           ->orderby('id')
                           ->get();
                    $categoryId = $cat[$i-1]->id;
                    $categoryName = $cat[$i-1]->category;
                    $exist = DB::table('to_do_list')
                             ->where('user_id', $userId)
                             ->where('category_id', $categoryId)
                             ->where('date', $now)
                             ->exists();
                    if (! $exist){
                        $insert = DB::table('to_do_list')
                                ->insert(['user_id'=>$userId, 'user_fullname'=>$userfullname, 'category_id'=>$categoryId, 
                                'category'=>$categoryName, 'date'=>$now]);
                    }

                    if(is_null($streak)){ //belum ada data streak, create ulang semua
                        DB::table('streak')
                        ->insert(['user_id'=>$userId, 'user_fullname'=>$userfullname, 'cat_id'=>$categoryId, 
                            'category'=>$categoryName, 'best_streak'=>0, 'now_streak'=>0]);
                    }
                }

                return View('todolist');
            }
            else{
                return Redirect::to('profile');
            }
        }
        else{
            return View('index');
        }
    }

    public function addSuggest($date){
        date_default_timezone_set('Asia/Jakarta');
        $current = Carbon::now()->format('y-m-d H:i:s');
        $now = Carbon::now()->format('y-m-d');
        $userId = Auth::user()->id;
        User::where('id', $userId)
        ->update(['last_login'=>$current]);

        for($i=1;$i<=3;$i++){
            $listId = DB::table('to_do_list')
                     ->select('id')
                     ->where('user_id', $userId)
                     ->where('date', $date)
                     ->get();   

            DB::table('recommended')
            ->where('list_id', $listId[$i-1]->id)
            ->delete();
            for ($k=1;$k<=5;$k++){
                $ttlCarb = 0;
                $ttlPro = 0;
                $ttlLip = 0;
                $ttlCal = 0;      
                $userCal = round(Auth::user()->calories / 3);
                $userPro = round($userCal * 0.15);
                $userLip = round($userCal * 0.25);
                $userCarb = round($userCal * 0.6);
                $idRekomend = array();
                $subQuery = DB::table('calories_list as a')
                            ->join('calories_list_dtl as b', 'a.id', 'b.cal_id')
                            ->join('satuan_dtl as c', 'c.cal_id', 'b.id')
                            ->join('satuan as d', 'd.id', 'c.unit_id')
                            ->select('a.id as iid', 'b.id', 'b.carbohydrate', 'b.protein', 'b.fat', 
                              'b.title', 'b.cal_id', 'b.BDD', 'c.portion', 'c.gram', 'c.unit_id')
                            ->where('d.category', 'Makanan')
                            ->inRandomOrder();
                $rekom = DB::table(DB::raw("({$subQuery->toSql()}) as item"))
                         ->mergeBindings($subQuery)
                         ->groupby('iid')
                         ->get();

                for($j=0;$j<count($rekom);$j++){
                    $carb = round(($rekom[$j]->BDD / 100) * ($rekom[$j]->gram / 100) * 
                            $rekom[$j]->carbohydrate * 4);
                    $pro = round(($rekom[$j]->BDD / 100) * ($rekom[$j]->gram / 100) * 
                            $rekom[$j]->protein * 4);
                    $lip = round(($rekom[$j]->BDD / 100) * ($rekom[$j]->gram / 100) * 
                            $rekom[$j]->fat * 9);
                    $ttlCarb += $carb;
                    $ttlPro += $pro;
                    $ttlLip += $lip;      
                    $idRekomend[$j] = (object)[
                        'id' => $rekom[$j]->id,
                        'title' => $rekom[$j]->title,
                        'carb' => $carb,
                        'pro' => $pro,
                        'lip' => $lip,
                        'total' => ($carb + $lip + $pro),
                        'gram' => $rekom[$j]->gram,
                        'portion' => $rekom[$j]->portion,
                        'satuan' => $rekom[$j]->unit_id
                    ];
                }
                $ttlCal = $ttlCarb + $ttlPro + $ttlLip;
                do{
                    if ($userCal - $ttlCal < -200){
                        if ($userCarb - $ttlCarb < - 150){ //kurang 1/4 porsi pokok
                            $ttlCarb -= (0.25 * $idRekomend[0]->carb);
                            $ttlPro -= (0.25 * $idRekomend[0]->pro);
                            $ttlLip -= (0.25 * $idRekomend[0]->lip);
                            $ttlCal -= (0.25 * $idRekomend[0]->carb) + (0.25 * $idRekomend[0]->pro) + (0.25 * $idRekomend[0]->lip);
                            $idRekomend[0]->carb -= (0.25 * $idRekomend[0]->carb);
                            $idRekomend[0]->pro -= (0.25 * $idRekomend[0]->pro);
                            $idRekomend[0]->lip -= (0.25 * $idRekomend[0]->lip);
                            $idRekomend[0]->portion -= (0.25 * $idRekomend[0]->portion);
                            $idRekomend[0]->gram -= (0.25 * $idRekomend[0]->gram);
                        }
                        if ($userCal - $ttlCal < -200 && $userLip - $ttlLip <= 50){ // kurang 1/4 porsi hewani
                            $ttlCarb -= (0.25 * $idRekomend[2]->carb);
                            $ttlPro -= (0.25 * $idRekomend[2]->pro);
                            $ttlLip -= (0.25 * $idRekomend[2]->lip);
                            $ttlCal -= (0.25 * $idRekomend[2]->carb) + (0.25 * $idRekomend[2]->pro) + (0.25 * $idRekomend[2]->lip);
                            $idRekomend[2]->carb -= (0.25 * $idRekomend[2]->carb);
                            $idRekomend[2]->pro -= (0.25 * $idRekomend[2]->pro);
                            $idRekomend[2]->lip -= (0.25 * $idRekomend[2]->lip);
                            $idRekomend[2]->portion -= (0.25 * $idRekomend[2]->portion);
                            $idRekomend[2]->gram -= (0.25 * $idRekomend[2]->gram);
                        }
                    }
                    else if ($userCal - $ttlCal > 400){ //>2500kal
                        if ($userCarb - $ttlCarb > 100){ //tambah 1/2 pokok
                            $ttlCarb += (0.5 * $idRekomend[0]->carb);
                            $ttlPro += (0.5 * $idRekomend[0]->pro);
                            $ttlLip += (0.5 * $idRekomend[0]->lip);
                            $ttlCal += (0.5 * $idRekomend[0]->carb) + (0.5 * $idRekomend[0]->pro) + (0.5 * $idRekomend[0]->lip);
                            $idRekomend[0]->carb += (0.5 * $idRekomend[0]->carb);
                            $idRekomend[0]->pro += (0.5 * $idRekomend[0]->pro);
                            $idRekomend[0]->lip += (0.5 * $idRekomend[0]->lip);
                            $idRekomend[0]->portion += (0.5 * $idRekomend[0]->portion);
                            $idRekomend[0]->gram += (0.5 * $idRekomend[0]->gram);
                        }
                        if ($userCal - $ttlCal > 150){ //tambah 1/2 nabati
                            $ttlCarb += (0.5 * $idRekomend[1]->carb);
                            $ttlPro += (0.5 * $idRekomend[1]->pro);
                            $ttlLip += (0.5 * $idRekomend[1]->lip);
                            $ttlCal += (0.5 * $idRekomend[1]->carb) + (0.5 * $idRekomend[1]->pro) + (0.5 * $idRekomend[1]->lip);
                            $idRekomend[1]->carb += (0.5 * $idRekomend[1]->carb);
                            $idRekomend[1]->pro += (0.5 * $idRekomend[1]->pro);
                            $idRekomend[1]->lip += (0.5 * $idRekomend[1]->lip);
                            $idRekomend[1]->portion += (0.5 * $idRekomend[1]->portion);
                            $idRekomend[1]->gram += (0.5 * $idRekomend[1]->gram);
                        }
                        if (($userCal - $ttlCal > 100) && ($userCal - $ttlCal <= 150)){ //tambah 1/2 sayuran
                            $ttlCarb += (0.5 * $idRekomend[3]->carb); 
                            $ttlPro += (0.5 * $idRekomend[3]->pro);
                            $ttlLip += (0.5 * $idRekomend[3]->lip);
                            $ttlCal += (0.5 * $idRekomend[3]->carb) + (0.5 * $idRekomend[3]->pro) + (0.5 * $idRekomend[3]->lip);
                            $idRekomend[3]->carb += (0.5 * $idRekomend[3]->carb);
                            $idRekomend[3]->pro += (0.5 * $idRekomend[3]->pro);
                            $idRekomend[3]->lip += (0.5 * $idRekomend[3]->lip);
                            $idRekomend[3]->portion += (0.5 * $idRekomend[3]->portion);
                            $idRekomend[3]->gram += (0.5 * $idRekomend[3]->gram); 
                        }
                        if (($userCal - $ttlCal >= 50) && ($userCal - $ttlCal <= 100)){ //tambah 1/2 buah
                            $ttlCarb += (0.5 * $idRekomend[4]->carb);
                            $ttlPro += (0.5 * $idRekomend[4]->pro);
                            $ttlLip += (0.5 * $idRekomend[4]->lip);
                            $ttlCal += (0.5 * $idRekomend[4]->carb) + (0.5 * $idRekomend[4]->pro) + (0.5 * $idRekomend[4]->lip);
                            $idRekomend[4]->carb += (0.5 * $idRekomend[4]->carb);
                            $idRekomend[4]->pro += (0.5 * $idRekomend[4]->pro);
                            $idRekomend[4]->lip += (0.5 * $idRekomend[4]->lip);
                            $idRekomend[4]->portion += (0.5 * $idRekomend[4]->portion);
                            $idRekomend[4]->gram += (0.5 * $idRekomend[4]->gram);
                        }
                    }
                    else if ($userCal - $ttlCal > 300){ //>2000kal
                        if ($userCarb - $ttlCarb > 100){ //tambah 1/2 pokok
                            $ttlCarb += (0.5 * $idRekomend[0]->carb);
                            $ttlPro += (0.5 * $idRekomend[0]->pro);
                            $ttlLip += (0.5 * $idRekomend[0]->lip);
                            $ttlCal += (0.5 * $idRekomend[0]->carb) + (0.5 * $idRekomend[0]->pro) + (0.5 * $idRekomend[0]->lip);
                            $idRekomend[0]->carb += (0.5 * $idRekomend[0]->carb);
                            $idRekomend[0]->pro += (0.5 * $idRekomend[0]->pro);
                            $idRekomend[0]->lip += (0.5 * $idRekomend[0]->lip);
                            $idRekomend[0]->portion += (0.5 * $idRekomend[0]->portion);
                            $idRekomend[0]->gram += (0.5 * $idRekomend[0]->gram);
                        }
                        if (($userCal - $ttlCal >= 125) || ($userPro - $ttlPro >= 15)){ //tambah 1/2 nabati
                            $ttlCarb += (0.5 * $idRekomend[1]->carb);
                            $ttlPro += (0.5 * $idRekomend[1]->pro);
                            $ttlLip += (0.5 * $idRekomend[1]->lip);
                            $ttlCal += (0.5 * $idRekomend[1]->carb) + (0.5 * $idRekomend[1]->pro) + (0.5 * $idRekomend[1]->lip);
                            $idRekomend[1]->carb += (0.5 * $idRekomend[1]->carb);
                            $idRekomend[1]->pro += (0.5 * $idRekomend[1]->pro);
                            $idRekomend[1]->lip += (0.5 * $idRekomend[1]->lip);
                            $idRekomend[1]->portion += (0.5 * $idRekomend[1]->portion);
                            $idRekomend[1]->gram += (0.5 * $idRekomend[1]->gram);
                        }
                        if (($userCal - $ttlCal > 100) && ($userCal - $ttlCal <= 150)){ //tambah 1/4 sayuran
                            $ttlCarb += (0.25 * $idRekomend[3]->carb); 
                            $ttlPro += (0.25 * $idRekomend[3]->pro);
                            $ttlLip += (0.25 * $idRekomend[3]->lip);
                            $ttlCal += (0.25 * $idRekomend[3]->carb) + (0.25 * $idRekomend[3]->pro) + (0.25 * $idRekomend[3]->lip);
                            $idRekomend[3]->carb += (0.25 * $idRekomend[3]->carb);
                            $idRekomend[3]->pro += (0.25 * $idRekomend[3]->pro);
                            $idRekomend[3]->lip += (0.25 * $idRekomend[3]->lip);
                            $idRekomend[3]->portion += (0.25 * $idRekomend[3]->portion);
                            $idRekomend[3]->gram += (0.25 * $idRekomend[3]->gram); 
                        }
                        if (($userCal - $ttlCal >= 70) && ($userCal - $ttlCal <= 100)){ //tambah 1/4 buah
                            $ttlCarb += (0.25 * $idRekomend[4]->carb);
                            $ttlPro += (0.25 * $idRekomend[4]->pro);
                            $ttlLip += (0.25 * $idRekomend[4]->lip);
                            $ttlCal += (0.25 * $idRekomend[4]->carb) + (0.25 * $idRekomend[4]->pro) + (0.25 * $idRekomend[4]->lip);
                            $idRekomend[4]->carb += (0.25 * $idRekomend[4]->carb);
                            $idRekomend[4]->pro += (0.25 * $idRekomend[4]->pro);
                            $idRekomend[4]->lip += (0.25 * $idRekomend[4]->lip);
                            $idRekomend[4]->portion += (0.25 * $idRekomend[4]->portion);
                            $idRekomend[4]->gram += (0.25 * $idRekomend[4]->gram);
                        }
                    }
                    else if ($userCal -  $ttlCal > 150){ //>1750kal
                        if ($userCarb - $ttlCarb > 100){ //tambah 1/4 pokok
                            $ttlCarb += (0.25 * $idRekomend[0]->carb);
                            $ttlPro += (0.25 * $idRekomend[0]->pro);
                            $ttlLip += (0.25 * $idRekomend[0]->lip);
                            $ttlCal += (0.25 * $idRekomend[0]->carb) + (0.25 * $idRekomend[0]->pro) + (0.25 * $idRekomend[0]->lip);
                            $idRekomend[0]->carb += (0.25 * $idRekomend[0]->carb);
                            $idRekomend[0]->pro += (0.25 * $idRekomend[0]->pro);
                            $idRekomend[0]->lip += (0.25 * $idRekomend[0]->lip);
                            $idRekomend[0]->portion += (0.25 * $idRekomend[0]->portion);
                            $idRekomend[0]->gram += (0.25 * $idRekomend[0]->gram);
                        }
                        if (($userCal - $ttlCal >= 125) || ($userPro - $ttlPro >= 15)){ //tambah 1/4 nabati
                            $ttlCarb += (0.25 * $idRekomend[1]->carb);
                            $ttlPro += (0.25 * $idRekomend[1]->pro);
                            $ttlLip += (0.25 * $idRekomend[1]->lip);
                            $ttlCal += (0.25 * $idRekomend[1]->carb) + (0.25 * $idRekomend[1]->pro) + (0.25 * $idRekomend[1]->lip);
                            $idRekomend[1]->carb += (0.25 * $idRekomend[1]->carb);
                            $idRekomend[1]->pro += (0.25 * $idRekomend[1]->pro);
                            $idRekomend[1]->lip += (0.25 * $idRekomend[1]->lip);
                            $idRekomend[1]->portion += (0.25 * $idRekomend[1]->portion);
                            $idRekomend[1]->gram += (0.25 * $idRekomend[1]->gram);
                        }
                        if ($userCal - $ttlCal > 75){ //tambah 1/4 sayuran
                            $ttlCarb += (0.25 * $idRekomend[3]->carb); 
                            $ttlPro += (0.25 * $idRekomend[3]->pro);
                            $ttlLip += (0.25 * $idRekomend[3]->lip);
                            $ttlCal += (0.25 * $idRekomend[3]->carb) + (0.25 * $idRekomend[3]->pro) + (0.25 * $idRekomend[3]->lip);
                            $idRekomend[3]->carb += (0.25 * $idRekomend[3]->carb);
                            $idRekomend[3]->pro += (0.25 * $idRekomend[3]->pro);
                            $idRekomend[3]->lip += (0.25 * $idRekomend[3]->lip);
                            $idRekomend[3]->portion += (0.25 * $idRekomend[3]->portion);
                            $idRekomend[3]->gram += (0.25 * $idRekomend[3]->gram); 
                        }
                        if ($userCal - $ttlCal > 50){ //tambah 1/4 buah
                            $ttlCarb += (0.25 * $idRekomend[4]->carb); 
                            $ttlPro += (0.25 * $idRekomend[4]->pro);
                            $ttlLip += (0.25 * $idRekomend[4]->lip);
                            $ttlCal += (0.25 * $idRekomend[4]->carb) + (0.25 * $idRekomend[4]->pro) + (0.25 * $idRekomend[4]->lip);
                            $idRekomend[4]->carb += (0.25 * $idRekomend[4]->carb);
                            $idRekomend[4]->pro += (0.25 * $idRekomend[4]->pro);
                            $idRekomend[4]->lip += (0.25 * $idRekomend[4]->lip);
                            $idRekomend[4]->portion += (0.25 * $idRekomend[4]->portion);
                            $idRekomend[4]->gram += (0.25 * $idRekomend[4]->gram); 
                        }
                    }
                    else if ($userCal - $ttlCal >= 100){ //>1250kal
                        if ($userCarb - $ttlCarb > 85){ //tambah 1/4 pokok
                            $ttlCarb += (0.25 * $idRekomend[0]->carb);
                            $ttlPro += (0.25 * $idRekomend[0]->pro);
                            $ttlLip += (0.25 * $idRekomend[0]->lip);
                            $ttlCal += (0.25 * $idRekomend[0]->carb) + (0.25 * $idRekomend[0]->pro) + (0.25 * $idRekomend[0]->lip);
                            $idRekomend[0]->carb += (0.25 * $idRekomend[0]->carb);
                            $idRekomend[0]->pro += (0.25 * $idRekomend[0]->pro);
                            $idRekomend[0]->lip += (0.25 * $idRekomend[0]->lip);
                            $idRekomend[0]->portion += (0.25 * $idRekomend[0]->portion);
                            $idRekomend[0]->gram += (0.25 * $idRekomend[0]->gram);
                        }
                        else{ //tambah 1/4 sayuran
                            $ttlCarb += (0.25 * $idRekomend[3]->carb);
                            $ttlPro += (0.25 * $idRekomend[3]->pro);
                            $ttlLip += (0.25 * $idRekomend[3]->lip);
                            $ttlCal += (0.25 * $idRekomend[3]->carb) + (0.25 * $idRekomend[3]->pro) + (0.25 * $idRekomend[3]->lip);
                            $idRekomend[3]->carb += (0.25 * $idRekomend[3]->carb);
                            $idRekomend[3]->pro += (0.25 * $idRekomend[3]->pro);
                            $idRekomend[3]->lip += (0.25 * $idRekomend[3]->lip);
                            $idRekomend[3]->portion += (0.25 * $idRekomend[3]->portion);
                            $idRekomend[3]->gram += (0.25 * $idRekomend[3]->gram);
                        }
                        if ($userPro - $ttlPro >= 25){ //tambah 1/2 nabati
                            $ttlCarb += (0.5 * $idRekomend[1]->carb);
                            $ttlPro += (0.5 * $idRekomend[1]->pro);
                            $ttlLip += (0.5 * $idRekomend[1]->lip);
                            $ttlCal += (0.5 * $idRekomend[1]->carb) + (0.5 * $idRekomend[1]->pro) + (0.5 * $idRekomend[1]->lip);
                            $idRekomend[1]->carb += (0.5 * $idRekomend[1]->carb);
                            $idRekomend[1]->pro += (0.5 * $idRekomend[1]->pro);
                            $idRekomend[1]->lip += (0.5 * $idRekomend[1]->lip);
                            $idRekomend[1]->portion += (0.5 * $idRekomend[1]->portion);
                            $idRekomend[1]->gram += (0.5 * $idRekomend[1]->gram);
                        }
                        else{ //tambah 1/4 nabati
                            $ttlCarb += (0.25 * $idRekomend[1]->carb);
                            $ttlPro += (0.25 * $idRekomend[1]->pro);
                            $ttlLip += (0.25 * $idRekomend[1]->lip);
                            $ttlCal += (0.25 * $idRekomend[1]->carb) + (0.25 * $idRekomend[1]->pro) + (0.25 * $idRekomend[1]->lip);
                            $idRekomend[1]->carb += (0.25 * $idRekomend[1]->carb);
                            $idRekomend[1]->pro += (0.25 * $idRekomend[1]->pro);
                            $idRekomend[1]->lip += (0.25 * $idRekomend[1]->lip);
                            $idRekomend[1]->portion += (0.25 * $idRekomend[1]->portion);
                            $idRekomend[1]->gram += (0.25 * $idRekomend[1]->gram);
                        }
                    }
                } while($userCal - $ttlCal >= 100);

                for($j=0;$j<count($idRekomend);$j++){
                    DB::table('recommended')
                    ->insert(['list_id'=>$listId[$i-1]->id, 'cal_id'=>$idRekomend[$j]->id, 
                        'cal_title'=>$idRekomend[$j]->title, 'protein'=>$idRekomend[$j]->pro, 
                        'fat'=>$idRekomend[$j]->lip, 'carbohydrate'=>$idRekomend[$j]->carb, 
                        'calories'=>($idRekomend[$j]->lip + $idRekomend[$j]->pro + $idRekomend[$j]->carb),
                        'gram'=>$idRekomend[$j]->gram, 'portion'=>$idRekomend[$j]->portion,
                        'unit_id'=>$idRekomend[$j]->satuan]);
                }
            }
        }
        return Redirect::to('todolist')->with('success', 'saran berhasil dibuat');
    }

    public function addToDoListByRecom($listId, $dtlId){
        date_default_timezone_set('Asia/Jakarta');
        $current = Carbon::now()->format('y-m-d H:i:s');
        User::where('id', Auth::user()->id)
        ->update(['last_login'=>$current]);

        DB::table('to_do_list_dtl')
        ->where('list_id', $listId)
        ->delete();

        $data = DB::table('recommended')
                ->select('cal_id', 'cal_title', 'protein', 'fat', 'carbohydrate', 'calories', 'gram', 'portion', 'unit_id')
                ->where('id', '>=', $dtlId)
                ->limit(5)
                ->get();

        for ($i=0;$i<count($data);$i++){
            DB::table('to_do_list_dtl')
            ->insert(['list_id'=>$listId, 'cal_id'=>$data[$i]->cal_id, 'cal_title'=>$data[$i]->cal_title, 'protein'=>$data[$i]->protein, 'fat'=>$data[$i]->fat, 'carbohydrate'=>$data[$i]->carbohydrate, 'calories'=>$data[$i]->calories, 'portion'=>$data[$i]->portion, 'unit_id'=>$data[$i]->unit_id, 'gram'=>$data[$i]->gram]);
        }
        return Redirect::to('todolist')->with('success', 'agenda berhasil ditambahkan berdasarkan saran');;
    }

    public function updateList(){
        $listId = Input::get('listId');
        $dtl = Input::get('dtlId');
        $cat = DB::table('to_do_list')
               ->select('category_id')
               ->where('id', $listId)
               ->first();
        if ($cat->category_id != 4){
            for($i=0;$i<count($dtl);$i++){
                $data = explode(":", $dtl[$i]);
                $unitId = DB::table('satuan_dtl')
                          ->select('unit_id')
                          ->where('id', $data[1])
                          ->first();
                DB::table('to_do_list_dtl')
                ->where('id', $data[0])
                ->update(['protein'=>$data[4], 'fat'=>$data[3], 'carbohydrate'=>$data[5], 'calories'=>$data[2], 'portion'=>$data[6], 'gram'=>$data[7], 'unit_id'=>$unitId->unit_id]);
            }
        }
        else{
            for($i=0;$i<count($dtl);$i++){
                $data = explode(":", $dtl[$i]);
                DB::table('to_do_list_dtl')
                ->where('id', $data[0])
                ->update(['calories'=>$data[1], 'portion'=>$data[2]]);
            }
        }
        return Redirect::to('todolist')->with('success', 'agenda anda berhasil diubah');;
    }

    public function saveList(){
        $data = array(
            "id"=>Input::get('id'),
            "judul"=>Input::get('judul'),
            "deskripsi"=>Input::get('deskripsi'),
            "bagikan"=>is_null(Input::get('shared')) ? '0' : '1',
            "userid"=>Auth::user()->id,
            "userfullname"=>Auth::user()->first_name . " " . Auth::user()->last_name
        );
        $hdr = DB::table('menu')
                ->insert(['user_id'=>$data['userid'], 'user_fullname'=>$data['userfullname'], 'title'=>$data['judul'], 
                'description'=>$data['deskripsi'], 'share'=>$data['bagikan']]);
        if ($hdr){
            $hdrId = DB::table('menu')
                     ->select('id')
                     ->orderby('id', 'desc')
                     ->first();
            $list = DB::table('to_do_list_dtl')
                       ->select('cal_id', 'cal_title', 'protein', 'fat', 'carbohydrate', 'calories', 'portion', 'gram', 'unit_id')
                       ->where('list_id', $data['id'])
                       ->get();
            for($i=0;$i<count($list);$i++){
                DB::table('menu_dtl')
                ->insert(['menu_id'=>$hdrId->id, 'menu_name'=>$data['judul'], 'list_id'=>$list[$i]->cal_id, 'food_name'=>$list[$i]->cal_title, 'protein'=>$list[$i]->protein, 'fat'=>$list[$i]->fat, 'carbohydrate'=>$list[$i]->carbohydrate, 'calories'=>$list[$i]->calories, 'portion'=>$list[$i]->portion, 'gram'=>$list[$i]->gram, 'unit_id'=>$list[$i]->unit_id]);
            }
            return Redirect::to('todolist')->with('success', 'agenda berhasil disimpan');
        }
        else{
            return Redirect::to('todolist')->with('failed', 'agenda gagal disimpan');
        }
    }

    public function updateActivity(){
        date_default_timezone_set('Asia/Jakarta');
        $current = Carbon::now()->format('y-m-d H:i:s');
        User::where('id', Auth::user()->id)
        ->update(['last_login'=>$current]);
        $listId = Input::get('listId');
        $calId = Input::get('calId');

        for($i=0;$i<count($calId);$i++){
            $data = explode(":", $calId[$i]);
            $unitId = DB::table('satuan_dtl')
                      ->select('unit_id')
                      ->where('id', $data[1])
                      ->first();

            if (is_null($unitId))
                $unitId = $data[1];
            else
                $unitId = $unitId->unit_id;

            DB::table('to_do_list_dtl')
            ->insert(['list_id'=>$listId, 'cal_id'=>$data[0], 'cal_title'=>$data[2], 'protein'=>$data[4], 'fat'=>$data[5], 
              'carbohydrate'=>$data[3], 'calories'=>$data[6], 'portion'=>$data[7], 'unit_id'=>$unitId, 'gram'=>$data[8]]);
        }
        return Redirect::to('todolist')->with('success', 'agenda berhasil diubah');;
    }

    public function updateWeight(){
        date_default_timezone_set('Asia/Jakarta');
        $current = Carbon::now()->format('y-m-d H:i:s');
        User::where('id', Auth::user()->id)
        ->update(['last_login'=>$current]);

        $weight = Input::get('weight');
        $date = Input::get('date');

        $user = DB::table('user')
                ->select('gender', 'height', 'birthday', 'physic_activity')
                ->where('id', Auth::user()->id)
                ->first();

        $bmr = $weight * 24;
        $current = date_create($current);
        $birthday = date_create($user->birthday);
        $age = date_diff($current, $birthday);
        $age = $age->y;
        $w_ideal = ($user->height - 100) * 0.9;
        $imt = $weight/($user->height * $user->height / 10000);
        $aktivitas = 0;
        $calories = 0;

        if ($user->physic_activity == 'Rest')
            $aktivitas = 1.2;
        else if ($user->physic_activity == 'Light')
            $aktivitas = 1.375;
        else if ($user->physic_activity == 'Normal')
            $aktivitas = 1.55;
        else if ($user->physic_activity == 'Heavy')
            $aktivitas = 1.725;
        else if ($user->physic_activity == 'Very Heavy')
            $aktivitas = 1.9;

        if ($user->gender == "Male")
            $calories = 66 + (13.7 * $weight) + (5 * $user->height) - (6.8 * $age);
        else
            $calories = 655 + (9.6 * $weight) + (1.8 * $user->height) - (4.7 * $age);

        $calories *= $aktivitas;

        if ($weight < $w_ideal)
            $calories += 500;
        else if ($weight > $w_ideal)
            $calories -= 500;

        $calories = round($calories);
        $protein = round($calories * 0.15);
        $lipid = round($calories * 0.25);
        $carbohydrate = $calories - $protein - $lipid;

        DB::table('user')
        ->where('id', Auth::user()->id)
        ->update(['weight'=>$weight, 'IMT'=>$imt, 'protein'=>$protein, 'fat'=>$lipid, 'carbohydrate'=>$carbohydrate, 'calories'=>$calories, 'bb_ideal'=>$w_ideal]);

        $history = DB::table('history')
                   ->where('date', $date)
                   ->where('user_id', Auth::user()->id)
                   ->exists();
        if ($history){
            DB::table('history')
            ->where('date', $date)
            ->where('user_id', Auth::user()->id)
            ->update(['weight'=>$weight, 'protein_goal'=>$protein, 'fat_goal'=>$lipid, 'carbohydrate_goal'=>$carbohydrate, 'calories_goal'=>$calories, 'weight_goal'=>$w_ideal]);
        }
        else{
            DB::table('history')        
            ->insert(['user_id'=>Auth::user()->id, 'date'=>$date, 'weight'=>$weight, 'protein_goal'=>$protein, 'fat_goal'=>$lipid, 'carbohydrate_goal'=>$carbohydrate, 'calories_goal'=>$calories, 'weight_goal'=>$w_ideal]);
        }

        return Redirect::to('todolist')->with('success', 'berat badan berhasil ditentukan');;
    }

    public function updateExercise(){
        date_default_timezone_set('Asia/Jakarta');
        $current = Carbon::now()->format('y-m-d H:i:s');
        User::where('id', Auth::user()->id)
        ->update(['last_login'=>$current]);
        $listId = Input::get('listId');
        $calId = Input::get('calExId');
        $unitId = DB::table('satuan')
                  ->select('id')
                  ->where('satuan', 'Jam')
                  ->first();
        $unitId = $unitId->id;
        for($i=0;$i<count($calId);$i++){
            $data = explode(":", $calId[$i]);
            DB::table('to_do_list_dtl')
            ->insert(['list_id'=>$listId, 'cal_id'=>$data[0], 'cal_title'=>$data[1], 'protein'=>0, 'fat'=>0, 
                'carbohydrate'=>0, 'calories'=>$data[2], 'portion'=>$data[3], 'unit_id'=>$unitId]);
        }
        return Redirect::to('todolist')->with('success', 'agenda berhasil ditambahkan');;
    }

    public function updateActivityOthers(){
        date_default_timezone_set('Asia/Jakarta');
        $current = Carbon::now()->format('y-m-d H:i:s');
        User::where('id', Auth::user()->id)
        ->update(['last_login'=>$current]);
        
        $kategori = "drink";
        $data = array(
            'catId' => Input::get('catId'),
            'listId' => Input::get('listId'),
            'cat' => $kategori,
            'portion' => Input::get('portion')
        );

        $unitId = DB::table('satuan')
                  ->select('id')
                  ->where('category', $data['cat'])
                  ->first();
        $unitId = $unitId->id;

        $category = DB::table('calories_list_dtl')
                    ->select('id')
                    ->where('calorie_cat', $data['cat'])
                    ->first();
        $category = $category->id;

        $exist = DB::table('to_do_list')
                 ->join('to_do_list_dtl', 'to_do_list.id', 'to_do_list_dtl.list_id')
                 ->where('to_do_list.id', $data['listId'])
                 ->where('to_do_list.category_id', $data['catId'])
                 ->exists();

        if (! $exist){
            DB::table('to_do_list_dtl')
            ->insert(['list_id'=>$data['listId'], 'cal_id'=>$category, 'cal_title'=>$data['cat'], 'protein'=>0, 'fat'=>0, 'carbohydrate'=>0, 'calories'=>0, 'portion'=>$data['portion'], 'unit_id'=>$unitId]);
        }
        else{
            $idDtl = DB::table('to_do_list')
                     ->join('to_do_list_dtl', 'to_do_list.id', 'to_do_list_dtl.list_id')
                     ->select('to_do_list_dtl.id')
                     ->where('to_do_list.id', $data['listId'])
                     ->where('to_do_list.category_id', $data['catId'])
                     ->first();
            $idDtl = $idDtl->id;

            DB::table('to_do_list_dtl')
            ->where('id', $idDtl)
            ->update(['portion'=>$data['portion']]);
        }
        return Redirect::to('todolist')->with('success', 'agenda berhasil diubah');;
    }

    public function updateActivitySleep(){
        date_default_timezone_set('Asia/Jakarta');
        $current = Carbon::now()->format('y-m-d H:i:s');
        $userId = Auth::user()->id;

        User::where('id', $userId)
        ->update(['last_login'=>$current]);
        $msg = "";
        $date = date_format(date_create(Input::get('hour')), "Y-m-d H:i:s");
        $data = array(
            'kategori'=>Input::get('category'),
            'date'=> Input::get('date'),
            'hour'=> $date,
            'listId'=>Input::get('listId'),
            'catId' => Input::get('catId')
        );
        $kategori = Input::get('category');

        DB::table('to_do_list')
        ->where('id', $data['listId'])
        ->update(['sleep_wakeup_time'=>$data['hour']]);

        if ($data['kategori'] == "Tidur"){
            DB::table('history')
            ->where('user_id', Auth::user()->id)
            ->where('date', $data['date'])
            ->update(['sleep_time'=>$data['hour']]);
            $msg = "Jam Tidur Telah Ditentukan";
        }
        else{
            DB::table('history')
            ->where('user_id', Auth::user()->id)
            ->where('date', $data['date'])
            ->update(['wakeup_time'=>$data['hour']]);

            $unitId = DB::table('satuan')
                  ->select('id')
                  ->where('category', 'sleep')
                  ->first();
            $unitId = $unitId->id;

            $category = DB::table('calories_list_dtl')
                        ->select('id')
                        ->where('calorie_cat', 'sleep')
                        ->first();
            $category = $category->id;

            $exist = DB::table('to_do_list')
                     ->join('to_do_list_dtl', 'to_do_list.id', 'to_do_list_dtl.list_id')
                     ->where('to_do_list.id', $data['listId'])
                     ->where('to_do_list.category_id', $data['catId'])
                     ->exists();

            if (! $exist){
                DB::table('to_do_list_dtl')
                ->insert(['list_id'=>$data['listId'], 'cal_id'=>$category, 'cal_title'=>'sleep', 'protein'=>0, 'fat'=>0, 'carbohydrate'=>0, 'calories'=>0, 'portion'=>0, 'unit_id'=>$unitId]);
            }

            $hour = DB::table('history')
                    ->select('wakeup_time', 'sleep_time')
                    ->where('user_id', $userId)
                    ->where('date', $data['date'])
                    ->first();
            $wakeup = date_create($hour->wakeup_time);
            $sleep = date_create($hour->sleep_time);
            $selisih = date_diff($wakeup, $sleep);
            $selisih = $selisih->h + number_format($selisih->i / 60, 1, '.', '');

            DB::table('history')
            ->where('user_id', Auth::user()->id)
            ->where('date', $data['date'])
            ->update(['sleep'=>$selisih]);


            //cek yang belum completed
            $existNonCompleted = DB::table('to_do_list')
                                 ->select('id', 'date', 'category_id')
                                 ->where('completed', '0')
                                 ->where('date', '<=', $data['date'])
                                 ->where('category_id', '<>', 7)
                                 ->where('user_id', $userId)
                                 ->orderby('date')
                                 ->get();
            if (count($existNonCompleted) > 0){
                $lastDate = "";
                for($i=0;$i<count($existNonCompleted);$i++){
                    if ($lastDate == "")
                        $total = array(0, 0, 0, 0, 0, 0, 0);
                    else if ($lastDate != $existNonCompleted[$i]->date){                            
                        $ttlCal = $total[0] + $total[1] + $total[2];
                        DB::table('history') //untuk update history
                        ->where('date', $existNonCompleted[$i-1]->date)
                        ->where('user_id', $userId)
                        ->update(['protein'=>$total[0], 'carbohydrate'=>$total[1], 'fat'=>$total[2], 'calories'=>$ttlCal, 'exercise'=>$total[3], 'drink'=>$total[4], 'sleep'=>$total[5]]);
                        $total = array(0, 0, 0, 0, 0, 0, 0);
                    }
                    $sukses = 0;
                    $eat = DB::table('to_do_list_dtl')
                           ->select(\DB::raw("sum(protein) as pro, sum(carbohydrate) as carb, sum(fat) as fat, sum(calories) as cal, sum(portion) as portion"))
                           ->where('list_id', $existNonCompleted[$i]->id)
                           ->first();

                    $goal = DB::table('history')
                               ->select('protein_goal', 'fat_goal', 'carbohydrate_goal', 'calories_goal')
                               ->where('date', $existNonCompleted[$i]->date)
                               ->where('user_id', Auth::user()->id)
                               ->first();

                    if ($i < 3){
                        if (! is_null($goal)){
                            if ((round($goal->protein_goal)/3 - $eat->pro >= -100) && (round($goal->protein_goal)/3 - $eat->pro <= 100)){
                                if (($eat->fat >= 100) && ($eat->fat - round($goal->fat_goal)/3 >= -100)){ 
                                    if ((round($goal->carbohydrate_goal)/3 - $eat->carb >= -100) && (round($goal->carbohydrate_goal)/3 - $eat->carb <= 200)){
                                        $sukses = 1;
                                    }
                                }
                            }
                            $total[0] += $eat->pro;
                            $total[1] += $eat->carb;
                            $total[2] += $eat->fat;
                        }
                    }
                    else if ($i == 3){
                        if ($eat->portion >= 0.5)
                            $sukses = 1;
                        $total[6] += $eat->cal;
                        $total[3] += $eat->portion;
                    }
                    else if ($i == 4){
                        if ($eat->portion >= 2)
                            $sukses = 1;
                        $total[4] += $eat->portion;
                    }
                    else if ($i == 5){
                        if ($selisih >= 6 && $selisih <= 9)
                            $sukses = 1;
                        $total[5] += $selisih;
                    }

                    $streak = DB::table('streak')
                                ->select('user_id', 'best_streak', 'now_streak')
                                ->where('user_id', $userId)
                                ->where('cat_id', $i + 1)
                                ->first();
                    if (! $streak){
                        $best = 0;
                        $now = 0;
                    }
                    else{
                        $best = $streak->best_streak;
                        $now = $streak->now_streak;
                    }

                    if($sukses == 1){  //untuk update streak
                        if ($best == $now)
                            DB::table('streak')
                            ->where('user_id', $userId)
                            ->where('cat_id', $i + 1)
                            ->update(['best_streak'=>($best + 1), 'now_streak'=>($best + 1)]);
                        else
                            DB::table('streak')
                            ->where('user_id', $userId)
                            ->where('cat_id', $i + 1)
                            ->update(['now_streak'=>($now + 1)]);
                    }
                    else{
                        DB::table('streak')
                        ->where('user_id', $userId)
                        ->where('cat_id', $i + 1)
                        ->update(['now_streak'=>0]);
                    }

                    DB::table('to_do_list') //untuk complete
                    ->where('id', $existNonCompleted[$i]->id)
                    ->update(['completed'=>1]);

                    if ($i == count($existNonCompleted) - 1){
                        $ttlCal = $total[0] + $total[1] + $total[2];
                        DB::table('history') //untuk update history
                        ->where('date', $existNonCompleted[$i]->date)
                        ->where('user_id', $userId)
                        ->update(['protein'=>$total[0], 'carbohydrate'=>$total[1], 'fat'=>$total[2], 'calories'=>$ttlCal, 'exercise'=>$total[3], 'drink'=>$total[4], 'sleep'=>$total[5], 'exercise_cal'=>$total[6]]);
                    }

                    $lastDate = $existNonCompleted[$i]->date;
                }
            }
            $msg = "Agenda Telah Selesai";
        }
        return Redirect::to('todolist')->with('success', $msg);;
    }

    public function setReminder(){
        date_default_timezone_set('Asia/Jakarta');
        $current = Carbon::now()->format('y-m-d H:i:s');
        User::where('id', Auth::user()->id)
        ->update(['last_login'=>$current]);
        $data = array(
            'catId' => Input::get('catId'),
            'date' => Input::get('date'),
            'time' => Input::get('reminder'),
            'note' => Input::get('note'),
            'remind' => Input::get('remind')
        );
        DB::table('to_do_list')
        ->where('id', $data['catId'])
        ->update(['remind'=>$data['remind'], 'note_reminder'=>$data['note'], 'time'=>$data['time']]);
        return Redirect::to('todolist')->with('success', 'pengingat berhasil diubah');;
    }

    public function viewCalories($jenis){
        date_default_timezone_set('Asia/Jakarta');
        $current = Carbon::now()->format('y-m-d H:i:s');
        User::where('id', Auth::user()->id)
        ->update(['last_login'=>$current]);
        if ($jenis == 'food'){
            $data = DB::table('calories_list')
                    ->select('id', 'category', 'category_list', 'information', 'img_location')
                    ->where('category', 'makanan')
                    ->get();
            $subcategory = DB::table('calories_list')
                           ->select('category_list')
                           ->where('category', 'makanan')
                           ->orderby('category_list')
                           ->get();
        }
        else if ($jenis == 'exercise'){
            $data = DB::table('calories_list')
                    ->select('id', 'category', 'category_list', 'information', 'img_location')
                    ->where('category', 'latihan')
                    ->get();
            $subcategory = DB::table('calories_list')
                           ->select('category_list')
                           ->where('category', 'latihan')
                           ->orderby('category_list')
                           ->get();
        }
        return View('calories')->with(['data'=>$data, 'jenis'=>$jenis, 'subCat'=>$subcategory]);
    }

    public function viewSubCalories($jenis, $title, $id){
        date_default_timezone_set('Asia/Jakarta');
        $current = Carbon::now()->format('y-m-d H:i:s');
        User::where('id', Auth::user()->id)
        ->update(['last_login'=>$current]);
        $data = DB::table('calories_list_dtl')
                ->select('id', 'cal_id', 'calorie_cat', 'title', 'information', 'img_location1', 'protein', 'fat', 
                    'carbohydrate', 'bdd')
                ->where('cal_id', $id)
                ->get();
        return View('sub_calories')->with(['data'=>$data, 'title'=>$title, 'jenis'=>$jenis, 'id'=>$id]);
    }

    public function addSatuanById($jenis, $title, $id){
        date_default_timezone_set('Asia/Jakarta');
        $current = Carbon::now()->format('y-m-d H:i:s');
        User::where('id', Auth::user()->id)
        ->update(['last_login'=>$current]);
        $data = array(
            'idCal'=>Input::get('idJudul'),
            'idUnit'=>Input::get('satuan'),
            'gram'=>(is_null(Input::get('gram')) ? 0 : Input::get('gram')),
            'portion'=>Input::get('portion')
        );
        $exist = DB::table('satuan_dtl')
                 ->where('unit_id', $data['idUnit'])
                 ->where('cal_id', $data['idCal'])
                 ->exists();
        if (! $exist){
            $titleCal = DB::table('calories_list_dtl')
                     ->select('title')
                     ->where('id', $data['idCal'])
                     ->first();
            $insert = DB::table('satuan_dtl')
                      ->insert(['unit_id'=>$data['idUnit'], 'cal_id'=>$data['idCal'], 'cal_name'=>$titleCal->title, 'gram'=>$data['gram'], 'portion'=>$data['portion']]);
            if ($insert)
                return Redirect::to(route('calories', ['jenis'=>$jenis,'title'=>$title, 'categoryId'=>$id]))->with('success', 'berhasil menambah satuan');
            else
                return Redirect::to(route('calories', ['jenis'=>$jenis,'title'=>$title, 'categoryId'=>$id]))->with('failed', 'gagal menambah satuan');
        }
        else
            return Redirect::to(route('calories', ['jenis'=>$jenis,'title'=>$title, 'categoryId'=>$id]))->with('failed', 'satuan sudah pernah ada');
    }

    public function addCalories($jenis){
        date_default_timezone_set('Asia/Jakarta');
        $current = Carbon::now()->format('y-m-d H:i:s');
        User::where('id', Auth::user()->id)
        ->update(['last_login'=>$current]);
        if ($jenis == 'food')
            $data = array(
                'title'=>Input::get('title'),
                'category'=>Input::get('category'),
                'titledescription'=>Input::get('titledescription'),
                'protein'=>Input::get('protein'),
                'lipid'=>Input::get('lipid'),
                'carbohydrate'=>Input::get('carbohydrate'),
                'bdd'=>Input::get('bdd')
            );
        else
            $data = array(
                'title'=>Input::get('title'),
                'category'=>Input::get('category'),
                'titledescription'=>Input::get('titledescription'),
                'protein'=>0,
                'lipid'=>0,
                'carbohydrate'=>Input::get('carbohydrate'),
                'bdd'=>0
            );
        $id = DB::table('calories_list')
              ->select('id')
              ->where('category_list', $data['category'])
              ->first();
        $id = $id->id;

        $dtl = DB::table('calories_list_dtl')
               ->insert(['cal_id'=>$id, 'calorie_cat'=>$data['category'], 'title'=>$data['title'], 
                        'information'=>$data['titledescription'], 'protein'=>$data['protein'], 'fat'=>$data['lipid'], 
                        'carbohydrate'=>$data['carbohydrate'], 'BDD'=>$data['bdd']]);
        if ($dtl){
            return Redirect::to('calories/'.$jenis)->with('success', 'Berhasil Ditambah');
        }
        else
            return Redirect::to('calories/'.$jenis)->with('failed', 'Gagal Ditambah');
    }

    public function addSatuan(){
        date_default_timezone_set('Asia/Jakarta');
        $current = Carbon::now()->format('y-m-d H:i:s');
        User::where('id', Auth::user()->id)
        ->update(['last_login'=>$current]);
        $data = array(
            'jenis'=>Input::get('jenis'),
            'category'=>Input::get('categoryList'),
            'satuan'=>Input::get('satuan')
        );
        $exist = DB::table('satuan')
                 ->where('satuan', $data['satuan'])
                 ->exists();
        if ($exist){
            return Redirect::to('calories/'.$data['jenis'])->with('failed', 'Gagal Ditambah, Satuan Sudah Ada !');
        }
        else{
            DB::table('satuan')
            ->insert(['satuan'=>$data['satuan'], 'category'=>$data['category']]);
            return Redirect::to('calories/'.$data['jenis'])->with('success', 'Berhasil Ditambah');
        }
    }

    public function addCategoryCalories(){
        date_default_timezone_set('Asia/Jakarta');
        $current = Carbon::now()->format('y-m-d H:i:s');
        User::where('id', Auth::user()->id)
        ->update(['last_login'=>$current]);
        $data = array(
            'jenis'=>Input::get('jenis'),
            'category'=>Input::get('category1'),
            'description'=>Input::get('description')
        );
        if ($data['jenis'] == 'Makanan')
            $jenis = 'food';
        else 
            $jenis = 'exercise';
        $hdr = DB::table('calories_list')
               ->insert(['category'=>$data['jenis'], 'category_list'=>$data['category'], 'information'=>$data['description']]);
        if ($hdr)
            return Redirect::to('calories/'.$jenis)->with('success', 'Berhasil Ditambah');
        else
            return Redirect::to('calories/'.$jenis)->with('failed', 'Gagal Ditambah');
    }

    public function viewScoreboard(){
        date_default_timezone_set('Asia/Jakarta');
        $current = Carbon::now()->format('y-m-d H:i:s');
        User::where('id', Auth::user()->id)
        ->update(['last_login'=>$current]);
        $bulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        $year = Input::get('year');
        $month = Input::get('month');
        $category = Input::get('category');
        $mode = Input::get('mode');

        $nonCat = Category::select('id')
                  ->where('category', 'wakeup')
                  ->first();
        $nonCat = $nonCat->id;

        if ($mode > 1){
            if (is_null($year) && is_null($month)){
                $month = date("m");
                $year = date("Y");
            }

            $user = User::select('id', 'first_name', 'last_name')
                    ->where('access_id', 2)
                    ->orderby('id')
                    ->get();

            for ($i=0;$i<count($user);$i++){
                $userDtl[$i] = DB::table('to_do_list')
                        ->select('user_id', 'streak', DB::raw("day(date) as date"))
                        ->where('category', $category)
                        ->where('user_id', $user[$i]->id)
                        ->whereMonth('date', $month)
                        ->whereYear('date', $year)
                        ->orderby('date')
                        ->get(); 
            }

            $data = DB::table('streak')
                    ->select('user_id', 'user_fullname', 'cat_id', 'category', 'best_streak', 'now_streak')
                    ->where('category', $category)
                    ->where('cat_id', '<>', $nonCat)
                    ->orderby('cat_id')
                    ->orderby('best_streak', 'desc')
                    ->orderby('now_streak', 'desc')
                    ->orderby('user_fullname', 'asc')
                    ->get();

            return View('scoreboard_streak')->with(['user'=>$user, 'userDtl'=>$userDtl, 'category'=>$category, 'countUser'=>count($user), 'data'=>$data]);
        }

        if ($category != ""){
            if ($category == "All")   
                $data = DB::table('streak')
                        ->select('user_id', 'user_fullname', 'cat_id', 'category', 'best_streak', 'now_streak')
                        ->where('cat_id', '<>', $nonCat)
                        ->orderby('cat_id')
                        ->orderby('best_streak', 'desc')
                        ->orderby('now_streak', 'desc')
                        ->orderby('user_fullname', 'asc')
                        ->get();
            else
                $data = DB::table('streak')
                        ->select('user_id', 'user_fullname', 'cat_id', 'category', 'best_streak', 'now_streak')
                        ->where('category', $category)
                        ->where('cat_id', '<>', $nonCat)
                        ->orderby('cat_id')
                        ->orderby('best_streak', 'desc')
                        ->orderby('now_streak', 'desc')
                        ->orderby('user_fullname', 'asc')
                        ->get();
            $all = true;
        }
        else{
            $data = DB::table('streak')
                    ->select('user_id', 'user_fullname', 'cat_id', 'category', 'best_streak', 'now_streak')
                    ->where('cat_id', '<>', $nonCat)
                    ->orderby('cat_id')
                    ->orderby('best_streak', 'desc')
                    ->orderby('now_streak', 'desc')
                    ->orderby('user_fullname', 'asc')
                    ->get();
            $all = false;
        }
        return View('scoreboard')->with(['data'=>$data, 'all'=>$all]);
    }

    public function editMenu($menuId, $menuName){
        date_default_timezone_set('Asia/Jakarta');
        $current = Carbon::now()->format('y-m-d H:i:s');
        User::where('id', Auth::user()->id)
        ->update(['last_login'=>$current]);
        // $menuSel = Input::get('calId');
        $share = (is_null(Input::get('share'))) ? 0 : 1;
        $menu = DB::table('menu')
                ->where('id', $menuId)
                ->update(['title'=>$menuName, 'share'=>$share]);

        //         DB::table('menu_dtl')
        //         ->where('menu_id', $menuId)
        //         ->update(['menu_name'=>$menuName]);

        // $ssql = DB::table('menu_dtl')
        //         ->where('menu_id', $menuId)
        //         ->whereNotIn('list_id', $menuSel)
        //         ->orderByRaw(\DB::raw("FIELD(list_id, ".implode(",",$menuSel).")"))
        //         ->delete();
                // ->tosql();
        // dd($menuSel);
        if ($menu)
            return Redirect::to('menu/food/owner')->with('success', "Menu " . $menuName . " berhasil diedit");
        else
            return Redirect::to('menu/food/owner')->with('fail', "Gagal mengedit menu");
                // ->toSql();
        // dd($ssql);
    }

    public function addListMenu($menuId, $menuName){
        date_default_timezone_set('Asia/Jakarta');
        $current = Carbon::now()->format('y-m-d H:i:s');
        User::where('id', Auth::user()->id)
        ->update(['last_login'=>$current]);
        $menuSel = Input::get('calId');
        $menu = DB::table('menu')
                ->select('title')
                ->where('id', $menuId)
                ->first();
        for($i=0;$i<count($menuSel);$i++){
            $check = explode(":", $menuSel[$i]);

            $unitId = DB::table('satuan_dtl')
                      ->select('unit_id')
                      ->where('id', $check[1])
                      ->first();

            $ssql = DB::table('menu_dtl')
                    ->insert(['menu_id'=>$menuId, 'menu_name'=>$menuName, 'list_id'=>$check[0], 'unit_id'=>$unitId->unit_id,
                    'food_name'=>$check[2], 'carbohydrate'=>$check[3], 'protein'=>$check[4], 'fat'=>$check[5], 'calories'=>$check[6], 'portion'=>$check[7], 'gram'=>$check[8]]);
        }
        return Redirect::to('menu/food/owner')->with('success', "Menu " . $menu->title . " berhasil menambahkan daftar");
    }

    public function newMenu($jenis, $menuName){
        date_default_timezone_set('Asia/Jakarta');
        $current = Carbon::now()->format('y-m-d H:i:s');
        User::where('id', Auth::user()->id)
        ->update(['last_login'=>$current]);
        $id = DB::table('menu')
              ->select('id')
              ->orderby('id', 'desc')
              ->first();
        if (is_null($id))
            $id = 1;
        else
            $id = ($id->id) + 1;
        $calId = array(
            'menuId' => $id,
            'menuName' => $menuName,
            'userId' => Auth::user()->id,
            'userFullname' => Auth::user()->first_name . " " . Auth::user()->last_name,
            'description' => Input::get('description'),
            'shared' => is_null(Input::get('shared')) ? '0' : '1',
            'calId' => Input::get('calId')
        );
        $insert = DB::table('menu')
                  ->insert(['id'=>$calId['menuId'], 'user_id'=>$calId['userId'], 'user_fullname'=>$calId['userFullname'], 
                    'title'=>$calId['menuName'], 'description'=>$calId['description'], 'share'=>$calId['shared']]);
        if ($insert){
            for($i=0;$i<count($calId['calId']);$i++){
                $check = explode(":", $calId['calId'][$i]);

                $unitId = DB::table('satuan_dtl')
                          ->select('unit_id')
                          ->where('id', $check[1])
                          ->first();

                DB::table('menu_dtl')
                ->insert(['menu_id'=>$id, 'menu_name'=>$calId['menuName'], 'list_id'=>$check[0], 'unit_id'=>$unitId->unit_id, 
                    'food_name'=>$check[2], 'carbohydrate'=>$check[3], 'protein'=>$check[4], 'fat'=>$check[5], 'calories'=>$check[6], 'portion'=>$check[7], 'gram'=>$check[8]]);
            }
            return Redirect::to('/menu/food/'.$jenis)->with('success', "Menu " . $calId['menuName'] . " berhasil ditambahkan");
        }
        else{
            return Redirect::to('menu/food/'.$jenis)->with('fail', "ERROR gagal tambahkan menu");
        }
    }

    public function deleteMenu($jenis, $menuId){
        date_default_timezone_set('Asia/Jakarta');
        $current = Carbon::now()->format('y-m-d H:i:s');
        User::where('id', Auth::user()->id)
        ->update(['last_login'=>$current]);
        $delete = DB::table('menu_dtl')
                  ->where('menu_id', $menuId)
                  ->delete();
        if ($delete){
            $delete = DB::table('menu')
                      ->where('id', $menuId)
                      ->delete();
            return Redirect::to('menu/food/'.$jenis)->with('success', "Menu berhasil dihapus");
        }
        else
            return Redirect::to('menu/food/'.$jenis)->with('fail', "Gagal hapus menu !");
    }

    public function viewMenu($jenis){
        date_default_timezone_set('Asia/Jakarta');
        $current = Carbon::now()->format('y-m-d H:i:s');
        User::where('id', Auth::user()->id)
        ->update(['last_login'=>$current]);
        $menu = array();
        if ($jenis == 'shared'){
            $menu = DB::table('menu')
                    ->select('id', 'user_fullname', 'title', 'description', 'share')
                    ->where('user_id', "<>", Auth::user()->id)
                    ->where('share', 1)
                    ->get();
        }
        else if ($jenis == 'owner'){
             $menu = DB::table('menu')
                    ->select('id', 'title', 'description', 'share')
                    ->where('user_id', Auth::user()->id)
                    ->get();
        }

        $menuDtl = array();
        foreach($menu as $menus){
            $menuDtl[] = DB::table('menu_dtl')
                        ->join('menu', 'menu.id', 'menu_dtl.menu_id')
                        ->join('satuan', 'satuan.id', 'menu_dtl.unit_id')
                       ->where('menu_dtl.menu_id', $menus->id)
                       ->select('menu_dtl.menu_id', 'menu_dtl.list_id', 'menu_dtl.food_name', 'menu_dtl.protein', 'menu_dtl.fat', 'menu_dtl.carbohydrate', 'menu.description', 'menu_dtl.portion', 'menu_dtl.gram', 'satuan.satuan', 'menu_dtl.calories')
                       ->get();
        }
        if ($jenis == 'shared')
            return View('menu_shared')->with(['menu'=>$menu, 'menuDtl'=>$menuDtl, 'jenis'=>$jenis]);
        else if ($jenis == 'owner')
            return View('menu_owner')->with(['menu'=>$menu, 'menuDtl'=>$menuDtl, 'jenis'=>$jenis]);
    }

    public function insertToDoList(){
        date_default_timezone_set('Asia/Jakarta');
        $current = Carbon::now()->format('y-m-d H:i:s');
        User::where('id', Auth::user()->id)
        ->update(['last_login'=>$current]);
        $date = date_format(date_create(Input::get('date')), "y-m-d");
        $data = array(
            'userId' => Auth::user()->id,
            'userName' => Auth::user()->first_name . " " . Auth::user()->last_name,
            'menuId' => Input::get('menuId'),
            'catId' => Input::get('catId'),
            'date' => $date
        );

        $listId = DB::table('to_do_list')
                  ->select('id')
                  ->where('user_id', $data['userId'])
                  ->where('category_id', $data['catId'])
                  ->where('date', $data['date'])
                  ->first();

        $listId = $listId->id;

        $calDtl = DB::table('menu as a')
                 ->select('b.list_id', 'b.food_name', 'b.protein', 'b.carbohydrate', 'b.fat', 'b.calories', 'b.portion', 'b.gram', 'b.unit_id')
                 ->join('menu_dtl as b', 'a.id', 'b.menu_id')
                 ->where('a.id', $data['menuId'])
                 ->get();

        for($i=0;$i<count($calDtl);$i++){
            $insert = DB::table('to_do_list_dtl')
                      ->insert(['list_id'=>$listId, 'cal_id'=>$calDtl[$i]->list_id, 'cal_title'=>$calDtl[$i]->food_name, 'protein'=>$calDtl[$i]->protein, 'fat'=>$calDtl[$i]->fat, 'carbohydrate'=>$calDtl[$i]->carbohydrate, 'calories'=>$calDtl[$i]->calories, 'portion'=>$calDtl[$i]->portion, 'gram'=>$calDtl[$i]->gram, 'unit_id'=>$calDtl[$i]->unit_id]);
            
        }
        return Redirect::to('menu/food/shared')->with('success', "Menu berhasil ditambahkan");
    }

    public function viewGoals(){
        date_default_timezone_set('Asia/Jakarta');
        $current = Carbon::now()->format('y-m-d H:i:s');
        User::where('id', Auth::user()->id)
        ->update(['last_login'=>$current]);

        $bulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

        $year = Input::get('year');
        $month = Input::get('month');

        if (is_null($year) && is_null($month)){
            $month = date("m");
            $year = date("Y");
        }

        $bb = User::select('bb_ideal', 'weight')
                   ->where('id', Auth::user()->id)
                   ->first();

        $data = DB::table('history')
                ->select('weight', 'weight_goal', 'protein', 'protein_goal', 'fat', 'fat_goal', 'carbohydrate', 'carbohydrate_goal', 'calories', 'calories_goal', 'exercise', 'exercise_cal', 'drink', 'sleep', DB::raw("day(date) as date"))
                ->where('user_id', Auth::user()->id)
                ->whereMonth('date', $month)
                ->whereYear('date', $year)
                ->orderby('date')
                ->get();
        // dd($data);
        return View('goals')->with(['data'=>$data, 'bulan'=>$bulan[$month-1], 'bb'=>$bb]);
    }

    public function viewSteps(){
        date_default_timezone_set('Asia/Jakarta');
        $current = Carbon::now()->format('y-m-d H:i:s');
        User::where('id', Auth::user()->id)
        ->update(['last_login'=>$current]);

        $bulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

        $year = Input::get('year');
        $month = Input::get('month');
        $today = getdate();

        if (is_null($year) && is_null($month)){
            $month = date("m");
            $year = date("Y");
        }

        $data = DB::table('user')
                ->join('steps', 'user.id', 'steps.user_id')
                ->select('user.id', 'user.first_name', 'user.last_name', 'steps.distance', 'steps.goal', 'steps.start', 'steps.end', 'steps.calories', 'steps.date')
                ->whereMonth('steps.date', $month)
                ->whereYear('steps.date', $year)
                ->orderby('date', 'desc')
                ->orderby('distance', 'desc')
                ->get();

        $date = DB::table('steps')
                ->select('date')
                ->whereMonth('date', $month)
                ->whereYear('date', $year)
                ->groupby('date')
                ->orderby('date', 'desc')
                ->get();

        $i = 0;
        if (count($date) > 0){
            foreach($date as $value){
                $result = DB::table('user')
                          ->join('steps', 'user.id', 'steps.user_id')
                          ->select('steps.distance', 'steps.goal', 'steps.start', 'steps.end', 'steps.calories', 'steps.date')
                          ->where('user.id', Auth::user()->id)
                          ->where('steps.date', $value->date)
                          ->first();
                if ($result){
                    $userDtl[$i] = $result;
                }
                else{
                    $userDtl[$i] = (object)[
                        'distance'=> 0, 
                        'goal' => 0, 
                        'start' => '00:00:00', 
                        'end' => '00:00:00', 
                        'calories' => 0, 
                        'date' => $value->date
                    ];
                }
                $i++;
            }
        }
        else{
            $userDtl[0] = (object)[
                'distance'=> 0, 
                'goal' => 0, 
                'start' => '00:00:00', 
                'end' => '00:00:00', 
                'calories' => 0, 
                'date' => $today['mday'] . '-' . $month . '-' . $year
            ];
            $date[0] = (object)[
                'date' => $today['mday'] . '-' . $month . '-' . $year
            ];
        }
        return View('steps')->with(['data'=>$data, 'userDtl'=>$userDtl, 'date'=>$date]);
    }

    public function stepMore($date){
        date_default_timezone_set('Asia/Jakarta');
        $current = Carbon::now()->format('y-m-d H:i:s');
        User::where('id', Auth::user()->id)
        ->update(['last_login'=>$current]);
        $data = DB::table('user')
                ->join('steps', 'user.id', 'steps.user_id')
                ->select('user.id', 'user.first_name', 'user.last_name', 'steps.distance', 'steps.goal', 'steps.start', 'steps.end', 'steps.calories', 'steps.date')
                ->where('steps.date', $date)
                ->orderby('date', 'desc')
                ->orderby('distance', 'desc')
                ->get();
        return View('step-more')->with(['data'=>$data]);
    }

    public function viewProfile(){
        date_default_timezone_set('Asia/Jakarta');
        $current = Carbon::now()->format('y-m-d H:i:s');
        User::where('id', Auth::user()->id)
        ->update(['last_login'=>$current]);
        $user = User::where('id', Auth::user()->id)->first();
        return View('profile')->with('user', $user);
    }

    public function editProfile($jenis){
        date_default_timezone_set('Asia/Jakarta');
        $current = Carbon::now()->format('y-m-d H:i:s');
        $day = Carbon::now()->format('D');
        User::where('id', Auth::user()->id)
        ->update(['last_login'=>$current]);

        if ($jenis == 'edit'){
            $data = array(
                'username' => Input::get('username'),
                'first_name' => Input::get('firstname'),
                'last_name' => Input::get('lastname'), 
                'email' => Input::get('email'),
                'gender' => Input::get('gender'),
                'height' => Input::get('height'),
                'weight' => Input::get('weight'),
                'birthday' => Input::get('bday'),
                'physic_activity' => Input::get('activity')
            );

            $bmr = $data['weight'] * 24;
            $current = date_create($current);
            $birthday = date_create($data['birthday']);
            $age = date_diff($current, $birthday);
            $age = $age->y;
            $w_ideal = ($data['height'] - 100) * 0.9;
            $imt = $data['weight']/($data['height'] * $data['height'] / 10000);
            $aktivitas = 0;
            $calories = 0;

            if ($data['physic_activity'] == 'Rest')
                $aktivitas = 1.2;
            else if ($data['physic_activity'] == 'Light')
                $aktivitas = 1.375;
            else if ($data['physic_activity'] == 'Normal')
                $aktivitas = 1.55;
            else if ($data['physic_activity'] == 'Heavy')
                $aktivitas = 1.725;
            else if ($data['physic_activity'] == 'Very Heavy')
                $aktivitas = 1.9;

            if ($data['gender'] == "Male")
                $calories = 66 + (13.7 * $data['weight']) + (5 * $data['height']) - (6.8 * $age);
            else
                $calories = 655 + (9.6 * $data['weight']) + (1.8 * $data['height']) - (4.7 * $age);

            $calories *= $aktivitas;

            if ($data['weight'] < $w_ideal)
                $calories += 500;
            else if ($data['weight'] > $w_ideal)
                $calories -= 500;

            $calories = round($calories);
            $protein = round($calories * 0.15);
            $lipid = round($calories * 0.25);
            $carbohydrate = $calories - $protein - $lipid;

            $existUs = User::where('username', $data['username'])
                       ->where('id', '<>', Auth::user()->id)->exists();
            $existEmail = User::where('email', $data['email'])
                          ->where('id', '<>', Auth::user()->id)->exists();
            // dd($data);
            if (! $existUs && ! $existEmail){
                DB::table('notification')
                ->insert(['user_id'=>Auth::user()->id, 'information'=>'Mengedit profil pada hari ' . $day, 'time'=>$current]);
                User::where('id', Auth::user()->id)
                ->update(['first_name'=>$data['first_name'], 'last_name'=>$data['last_name'], 'username'=>$data['username'], 'email'=>$data['email'], 'gender'=>$data['gender'], 'height'=>$data['height'], 'weight'=>$data['weight'], 'birthday'=>$data['birthday'], 'bb_ideal'=>$w_ideal, 'physic_activity'=>$data['physic_activity'], 'imt'=>$imt, 'protein'=>$protein, 'fat'=>$lipid, 'carbohydrate'=>$carbohydrate, 'calories'=>$calories]);
                return Redirect::to('profile')->with('update', 'Edit Profile Berhasil');
            }
            else
                return Redirect::to('profile')->with('failed', 'Email atau Username sudah ada !');
        }
        else if ($jenis == 'password'){
            $current_password = Auth::User()->password;           
            if(Hash::check(Input::get('oldpassword'), $current_password)){      
                DB::table('notification')
                ->insert(['user_id'=>Auth::user()->id, 'information'=>'Mengganti password pada hari ' . $day, 'time'=>$current]);
                User::where('id', Auth::user()->id)
                ->update(['password'=>bcrypt(Input::get('password'))]);
                return Redirect::to('profile')->with('update', 'Password Berhasil Diubah');
            }     
            else 
                return Redirect::to('profile')->with('failed', 'Password Lama Tidak Tepat');
        }
    }

    public function viewOnline(){
        $data = User::select('first_name', 'last_name', 'last_login')
                ->where('id', '<>', Auth::user()->id)
                ->orderby('first_name')
                ->get();
        return View('online')->with('online', $data);
    }

    public function notification(){
        $data = DB::table('notification')
                ->join('user', 'notification.user_id', 'user.id')
                ->select('user.first_name', 'user.last_name', 'notification.information', 'notification.time')
                ->where('user.id', '<>', Auth::user()->id)
                ->orderby('notification.time', 'desc')
                ->get();
        return View('notification')->with('notif', $data);
    }

    public function destroy($id){
        date_default_timezone_set('Asia/Jakarta');
        $current = Carbon::now()->format('y-m-d H:i:s');
        User::where('id', Auth::user()->id)
        ->update(['last_login'=>$current]);
        ToDoList::find($id)->delete();
        return response()->json(['done']);
    }

    public function store(Request $request){
        date_default_timezone_set('Asia/Jakarta');
        $current = Carbon::now()->format('y-m-d H:i:s');
        User::where('id', Auth::user()->id)
        ->update(['last_login'=>$current]);
        $create = Item::create($request->all());
        return response()->json($create);
    }

    public function update(Request $request, $id){
        date_default_timezone_set('Asia/Jakarta');
        $current = Carbon::now()->format('y-m-d H:i:s');
        User::where('id', Auth::user()->id)
        ->update(['last_login'=>$current]);
        $edit = Item::find($id)->update($request->all());
        return response()->json($edit);
    }
}
