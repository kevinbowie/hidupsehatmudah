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
            'username' => $req['username'],
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
    		'password' => $req['password'],
    		'access_id' => '2',
    		'first_name' => $req['namaDepan'],
    		'last_name' => $req['namaBelakang'], 
    		'email' => $req['email'],
    		'gender' => $req['JK'],
    		'height' => $req['TB'],
    		'weight' => $req['BB'],
    		'birthday' => date_format(date_create($req['tglLahir']), "Y-m-d"),
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

    public function editProfile(Request $req){
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
    		'birthday' => date_format(date_create($req['tglLahir']), "Y-m-d"),
    		'imt' => $imt,
    		'protein' => $protein,
    		'fat' => $lemak,
    		'carbohydrate' => $karbo,
    		'calories' => $kalori,
    		'bb_ideal' => $bbIdeal,
    		'physic_activity' => $aktivitass,
    		'last_login' => $current
    	);
        // $updateUser = DB::table('user')::where('id', $req['id'])->update($userdata); 
        $updateUser = User::where('id', $req['id'])->update($userdata);
        if ($updateUser){
        	$userdata['id'] = $req['id'];
        	return response()->json(['message'=> 'Edit profile berhasil', 'code'=> '200', 'user'=>$userdata]);
        }
        else{
        	return response()->json(['message'=> 'Terjadi kesalahan. Periksa kembali data anda', 'code'=>'401']);
        }
    }

    public function editPassword(Request $req){
        date_default_timezone_set('Asia/Jakarta');
        $current = Carbon::now()->format('y-m-d H:i:s');
        $day = Carbon::now()->format('D');
    	$userdata = array(
    		'password' => bcrypt($req['password']),
    		'last_login' => $current
    	);
        // $updateUser = DB::table('user')::where('id', $req['id'])->update($userdata); 
        $updateUser = User::where('id', $req['id'])->update($userdata);
        if ($updateUser){
        	$userdata['id'] = $req['id'];
        	return response()->json(['message'=> 'Edit password berhasil', 'code'=> '200', 'user'=>$userdata]);
        }
        else{
        	return response()->json(['message'=> 'Terjadi kesalahan. Periksa kembali data anda', 'code'=>'401']);
        }
    }

    public function viewGrafik(Request $req){
        date_default_timezone_set('Asia/Jakarta');
        $current = Carbon::now()->format('y-m-d H:i:s');
        User::where('id', $req['id'])
        ->update(['last_login'=>$current]);

        $year = $req['tahun'];
        $month = $req['bulan'];

        if (is_null($year) && is_null($month)){
            $month = date("m");
            $year = date("Y");
        }

        $data = DB::table('history')
                ->select('weight', 'weight_goal', 'protein', 'protein_goal', 'fat', 'fat_goal', 'carbohydrate', 'carbohydrate_goal', 'calories', 'calories_goal', 'exercise', 'exercise_cal', 'drink', 'sleep', DB::raw("day(date) as date"))
                ->where('user_id', $req['id'])
                ->whereMonth('date', $month)
                ->whereYear('date', $year)
                ->orderby('date')
                ->get();
        // dd($data);
        return response()->json(['code'=> '200', 'data'=>$data]);
    }


    public function viewScoreboard(Request $req){
        date_default_timezone_set('Asia/Jakarta');
        $current = Carbon::now()->format('y-m-d H:i:s');
        User::where('id', $req['id'])->update(['last_login'=>$current]);

        $bulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        $year = $req['tahun'];
        $month = $req['bulan'];
        $category = $req['kategori'];

        $nonCat = Category::select('id')
                  ->where('category', 'wakeup')
                  ->first();

        $nonCat = $nonCat->id;

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

        return response()->json(['code'=> '200', 'data'=>$data]);
    }

    public function viewCalories(Request $req){
        date_default_timezone_set('Asia/Jakarta');
        $current = Carbon::now()->format('y-m-d H:i:s');
        User::where('id', $req['id'])->update(['last_login'=>$current]);

        if ($req['jenis'] == "1")   
            $data = DB::table('calories_list')
                    ->select('id', 'category', 'category_list', 'information')
                    ->where('category', 'makanan')
                    ->get();
        
        else 
            $data = DB::table('calories_list')
                    ->select('id', 'category', 'category_list', 'information')
                    ->where('category', 'latihan')
                    ->get();
         
        if ($data)
            return response()->json(['code'=> '200', 'data'=>$data]);
        else
            return response()->json(['code'=>'404', 'message'=>'maaf terjadi kesalahan silahkan mencoba kembali']);
    }

    public function viewSubCalories(Request $req){
        date_default_timezone_set('Asia/Jakarta');
        $current = Carbon::now()->format('y-m-d H:i:s');
        User::where('id', $req['id'])->update(['last_login'=>$current]);
        $data = DB::table('calories_list_dtl')
                ->select('id', 'cal_id', 'calorie_cat', 'title', 'information', 'img_location1', 'protein', 'fat', 
                    'carbohydrate', 'bdd')
                ->where('cal_id', $req['kategori_id'])
                ->get();

        // $userDtl[0] = (object)[
        //     'distance'=> 0, 
        //     'goal' => 0, 
        //     'start' => '00:00:00', 
        //     'end' => '00:00:00', 
        //     'calories' => 0, 
        //     'date' => $today['mday'] . '-' . $month . '-' . $year
        // ];

        for($i=0;$i<count($data);$i++){
            $satuan[$i] = DB::table('satuan as a')
                          ->join('satuan_dtl as b', 'a.id', 'b.unit_id')
                          ->select('b.portion', 'a.satuan', 'b.gram')
                          ->where('b.cal_id', $data[$i]->id)
                          ->get();

            for($j=0;$j<count($satuan[$i]);$j++){
                $carbCount = round(($data[$i]->bdd / 100) * ($satuan[$i][$j]->gram / 100) * $data[$i]->carbohydrate * 4);
                $proCount = round(($data[$i]->bdd / 100) * ($satuan[$i][$j]->gram / 100) * $data[$i]->protein * 4);
                $fatCount = round(($data[$i]->bdd / 100) * ($satuan[$i][$j]->gram / 100) * $data[$i]->fat * 9);
                $calorie = $carbCount + $proCount + $fatCount;
                // $satuan[$i][$j]->pro = $proCount;
                // $satuan[$i][$j]->carb = $carbCount;
                // $satuan[$i][$j]->fat = $fatCount;
                // $satuan[$i][$j]->calorie = $calorie;
                // $data[$i]->satuan = $satuan[$i];
            }
        }
        // dd($satuan);

        if ($data)
            return response()->json(['code'=>'200', 'data'=>$data, 'satuan'=>$satuan]);
        else
            return response()->json(['code'=>'404', 'message'=>'maaf terjadi kesalahan silahkan mencoba kembali']);
    }

    public function todolist(Request $req){
        date_default_timezone_set('Asia/Jakarta');
        $current = date("Y-m-d H:m:s");
        $userId = $req['id'];
        $userfullname = $req['fname'];
        $date = $req['tanggal'];
        $date = date('Y-m-d', strtotime($date));
        User::where('id', $userId)
        ->update(['last_login'=>$current]);
        $now = Carbon::now()->format('y-m-d');
        /*
        if (Auth::user()->access_id == '2'){ */

            $exist = DB::table('steps')
                     ->where('user_id', $userId)
                     ->where('date', $date)
                     ->exists();
            if (! $exist){
                DB::table('steps')
                ->insert(['user_id'=>$userId, 'user_fullname'=>$userfullname, 'date'=>$date]);
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
                         ->where('date', $date)
                         ->exists();
                if (! $exist){
                    $insert = DB::table('to_do_list')
                            ->insert(['user_id'=>$userId, 'user_fullname'=>$userfullname, 'category_id'=>$categoryId, 
                            'category'=>$categoryName, 'date'=>$date]);
                }

                if(is_null($streak)){ //belum ada data streak, create ulang semua
                    DB::table('streak')
                    ->insert(['user_id'=>$userId, 'user_fullname'=>$userfullname, 'cat_id'=>$categoryId, 
                        'category'=>$categoryName, 'best_streak'=>0, 'now_streak'=>0]);
                }
            }

            $history = DB::table('history')
                       ->select('weight',  'protein_goal as pro', 'carbohydrate_goal as carb', 'fat_goal as fat',
                       'calories_goal as cal', 'weight_goal', 'sleep_time', 'wakeup_time', 'drink')
                       ->where('date', $date)
                       ->where('user_id', $userId)
                       ->first();

            if ($history){
                $listDetail = DB::table('to_do_list as a')
                              ->join('to_do_list_dtl as b', 'a.id', 'b.list_id')
                              ->join('satuan as c', 'b.unit_id', 'c.id')
                              ->select('a.category_id', 'a.sleep_wakeup_time as rest', 'b.id', 'b.list_id', 'b.cal_title', 'b.protein', 'b.fat', 'b.carbohydrate', 'b.calories', 'b.portion', 'c.satuan', 'b.gram')
                              ->where('a.user_id', $userId)
                              ->where('a.date', $date)
                              ->where('a.category_id', '<=', 5)
                              ->orderby('a.category_id')
                              ->orderby('b.cal_title')
                              ->get();
                return response()->json(['code'=>'200', 'data'=>$history, 'dataDtl'=>$listDetail]);
            }
            else
                return response()->json(['code'=>'404', 'message'=>'silahkan update berat badan terlebih dahulu']);
        //}
    }

    public function updateWeight(Request $req){
        date_default_timezone_set('Asia/Jakarta');
        $current = Carbon::now()->format('y-m-d H:i:s');
        $userId = $req['id'];
        $weight = $req['weight'];
        $date = $req['tanggal'];
        $date = date('Y-m-d', strtotime($date));
        User::where('id', $userId)
        ->update(['last_login'=>$current]);

        $user = DB::table('user')
                ->select('gender', 'height', 'birthday', 'physic_activity')
                ->where('id', $userId)
                ->first();

        $sukses = false;
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
        ->where('id', $userId)
        ->update(['weight'=>$weight, 'IMT'=>$imt, 'protein'=>$protein, 'fat'=>$lipid, 'carbohydrate'=>$carbohydrate, 'calories'=>$calories, 'bb_ideal'=>$w_ideal]);

        $history = DB::table('history')
                   ->where('date', $date)
                   ->where('user_id', $userId)
                   ->exists();
        if ($history){
            DB::table('history')
            ->where('date', $date)
            ->where('user_id', $userId)
            ->update(['weight'=>$weight, 'protein_goal'=>$protein, 'fat_goal'=>$lipid, 'carbohydrate_goal'=>$carbohydrate, 'calories_goal'=>$calories, 'weight_goal'=>$w_ideal]);
            $sukses = true;
        }
        else{
            DB::table('history')        
            ->insert(['user_id'=>$userId, 'date'=>$date, 'weight'=>$weight, 'protein_goal'=>$protein, 'fat_goal'=>$lipid, 'carbohydrate_goal'=>$carbohydrate, 'calories_goal'=>$calories, 'weight_goal'=>$w_ideal]);
            $sukses = true;
        }

        $user = User::where('id', $userId)->first();

        if ($sukses)
            return response()->json(['code'=>'200', 'message'=>'berhasil update berat badan', 'user'=>$user]);
        else
            return response()->json(['code'=>'404', 'message'=>'maaf terjadi kesalahan silahkan mencoba kembali']);
    }

    public function resetall(Request $req){
        $date = date('Y-m-d', strtotime($req['tanggal']));
        $listid = DB::table('to_do_list')
                  ->select('id')
                  ->where('date', $date)
                  ->where('user_id', $req['id'])
                  ->get();

        if (count($listid) > 0){
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
        }

        DB::table('history')
        ->where('user_id', $req['id'])
        ->where('date', $date)
        ->delete();

        return response()->json(['code'=>'200', 'message'=>'berhasil reset data']);
    }

    public function addSuggest(Request $req){
        $date = $req['tanggal'];
        $date = date('Y-m-d', strtotime($date));
        $kategori = $req['kategoriId'];
        $userId = $req['id'];

        date_default_timezone_set('Asia/Jakarta');
        $current = Carbon::now()->format('y-m-d H:i:s');
        $now = Carbon::now()->format('y-m-d');
        User::where('id', $userId)
        ->update(['last_login'=>$current]);

        $kaloriUser = User::where('id', $userId)
                      ->select('calories')
                      ->first();

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
                $userCal = round($kaloriUser->calories / 3);
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

        $rekomendasi = DB::table('recommended as a')
                       ->join('to_do_list as b', 'a.list_id', 'b.id')
                       ->join('satuan as c', 'a.unit_id', 'c.id')
                       ->select('a.id', 'a.gram', 'a.carbohydrate', 'a.protein', 'a.fat', 'a.cal_title', 'a.calories', 'a.cal_id', 'a.portion', 'c.satuan')
                       ->where('b.date', $date)
                       ->where('b.category_id', $kategori)
                       ->where('b.user_id', $userId)
                       ->orderby('b.category_id')
                       ->orderby('a.id')
                       ->get();

        if (count($rekomendasi) > 0)
            return response()->json(['code'=>'200', 'data'=>$rekomendasi]);
        else
            return response()->json(['code'=>'404', 'message'=>'gagal mengambil data. silahkan mencoba kembali']);
    }


    public function addToDoListByRecom(Request $req){
        $userId = $req['id'];
        $pilihId = $req['pilihId'];
        $date = $req['tanggal'];
        $date = date('Y-m-d', strtotime($date));
        $kategoriId = $req['kategoriId'];

        date_default_timezone_set('Asia/Jakarta');
        $current = Carbon::now()->format('y-m-d H:i:s');
        User::where('id', $userId)
        ->update(['last_login'=>$current]);

        $listId = DB::table('to_do_list')
                  ->select('id')
                  ->where('user_id', $userId)
                  ->where('date', $date)
                  ->where('category_id', $kategoriId)
                  ->first();
        $listId = $listId->id;

        DB::table('to_do_list_dtl')
        ->where('list_id', $listId)
        ->delete();

        $data = DB::table('recommended')
                ->select('cal_id', 'cal_title', 'protein', 'fat', 'carbohydrate', 'calories', 'gram', 'portion', 'unit_id')
                ->where('id', '>=', $pilihId)
                ->limit(5)
                ->get();

        for ($i=0;$i<count($data);$i++){
            DB::table('to_do_list_dtl')
            ->insert(['list_id'=>$listId, 'cal_id'=>$data[$i]->cal_id, 'cal_title'=>$data[$i]->cal_title, 'protein'=>$data[$i]->protein, 'fat'=>$data[$i]->fat, 'carbohydrate'=>$data[$i]->carbohydrate, 'calories'=>$data[$i]->calories, 'portion'=>$data[$i]->portion, 'unit_id'=>$data[$i]->unit_id, 'gram'=>$data[$i]->gram]);
        }
        return response()->json(['code'=>'200', 'message'=>'berhasil ditambahkan']);
    }


    public function updateDataLain(Request $req){
        $userId = $req['id'];
        $jenis = $req['jenis'];
        $date = $req['tanggal'];
        $fname = $req['fname'];
        $date = date('Y-m-d', strtotime($date));
        $nilai = $req['nilai'];
        $date = date('Y-m-d', strtotime($req['tanggal']));
        $kategori = "";
        date_default_timezone_set('Asia/Jakarta');
        $current = Carbon::now()->format('y-m-d H:i:s');
        User::where('id', $userId)
        ->update(['last_login'=>$current]);

        $listId = DB::table('to_do_list')
                  ->select('id')
                  ->where('user_id', $userId)
                  ->where('date', $date)
                  ->where('category_id', $jenis)
                  ->first();
        $listId = $listId->id;

        if ($jenis != 5){
            $nilai = date('Y-m-d H:i:s', strtotime($nilai));
            $msg = "";
            // $date = date_format(date_create(Input::get('hour')), "Y-m-d H:i:s");
            if ($jenis == 6)
                $kategori = "Tidur";
            else
                $kategori = "Bangun";

            $data = array(
                'kategori' => $kategori,
                'date' => $date,
                'hour' => $nilai,
                'listId' =>$listId,
                'catId' => $jenis
            );

            DB::table('to_do_list')
            ->where('id', $data['listId'])
            ->update(['sleep_wakeup_time'=>$data['hour']]);

            if ($data['kategori'] == "Tidur"){
                DB::table('history')
                ->where('user_id', $userId)
                ->where('date', $data['date'])
                ->update(['sleep_time'=>$data['hour']]);
                $msg = "Jam Tidur Telah Ditentukan";
            }
            else{
                DB::table('history')
                ->where('user_id', $userId)
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
                ->where('user_id', $userId)
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
                                   ->where('user_id', $userId)
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
        }
        else{
            $kategori = "drink";
            $data = array(
                'catId' => $jenis,
                'listId' => $listId,
                'cat' => $kategori,
                'portion' => $nilai
            );

            $unitId = DB::table('satuan')
                      ->select('id')
                      ->where('category', 'drink')
                      ->first();
            $unitId = $unitId->id;

            $category = DB::table('calories_list_dtl')
                        ->select('id')
                        ->where('calorie_cat', 'drink')
                        ->first();
            $category = $category->id;

            $exist = DB::table('to_do_list')
                     ->join('to_do_list_dtl', 'to_do_list.id', 'to_do_list_dtl.list_id')
                     ->where('to_do_list.id', $listId)
                     ->where('to_do_list.category_id', $jenis)
                     ->exists();

            if (! $exist){
                DB::table('to_do_list_dtl')
                ->insert(['list_id'=>$listId, 'cal_id'=>$category, 'cal_title'=>'drink', 'protein'=>0, 'fat'=>0, 'carbohydrate'=>0, 'calories'=>0, 'portion'=>$nilai, 'unit_id'=>$unitId]);
            }
            else{
                $idDtl = DB::table('to_do_list')
                         ->join('to_do_list_dtl', 'to_do_list.id', 'to_do_list_dtl.list_id')
                         ->select('to_do_list_dtl.id')
                         ->where('to_do_list.id', $listId)
                         ->where('to_do_list.category_id', $jenis)
                         ->first();
                $idDtl = $idDtl->id;

                DB::table('to_do_list_dtl')
                ->where('id', $idDtl)
                ->update(['portion'=>$nilai]);
            }

            DB::table('history')
            ->where('user_id', $userId)
            ->where('date', $date)
            ->update(['drink'=>$nilai]);
        }
        return response()->json(['code'=>'200', 'message'=>'berhasil ditambahkan']);
    }

    public function getListCalories(Request $req){
        $kategori = $req['kategori'];
        $jenis = $req['jenis'];

        if (! is_null($jenis)){
            $daftar = DB::table('calories_list as a')
                      ->join('calories_list_dtl as b', 'a.id', 'b.cal_id')
                      ->select('b.id', 'b.title', 'b.protein', 'b.fat', 'b.carbohydrate', 'b.bdd')
                      ->where('a.category', $jenis)
                      ->orderby('b.id')
                      ->get();
        }
        else{
            $daftar = DB::table('calories_list as a')
                      ->join('calories_list_dtl as b', 'a.id', 'b.cal_id')
                      ->select('b.id', 'b.title', 'b.protein', 'b.fat', 'b.carbohydrate', 'b.bdd')
                      ->where('a.category_list', $kategori)
                      ->orderby('b.id')
                      ->get();
        }

        $item_data_decode = json_decode($daftar, true);
        $values = array_column($item_data_decode, 'id');
        // $meta_array = array_combine(array_column($item_data_decode, 'id'), $item_data_decode[1]);

        // for($i=0;$i<count($daftar);$i++){
            $satuan = DB::table('satuan as a')
                      ->join('satuan_dtl as b', 'a.id', 'b.unit_id')
                      ->select('b.id', 'b.cal_id', 'b.unit_id', 'a.satuan', 'b.gram', 'b.portion')
                      ->whereIn('b.cal_id', $values)
                      ->orderby('b.cal_id')
                      ->get();
        // }

        if ($satuan)
            return response()->json(['code'=>'200', 'data'=>$daftar, 'satuan'=>$satuan]);
        else
            return response()->json(['code'=>'404', 'message'=>'gagal ambil data, silahkan mencoba kembali']);
    }

    public function getDataTodolistDetail(Request $req){
        date_default_timezone_set('Asia/Jakarta');
        $current = date("Y-m-d H:m:s");
        $userId = $req['id'];
        $kategori = $req['kategori'];
        $date = date('Y-m-d', strtotime($req['tanggal']));

        User::where('id', $userId)
        ->update(['last_login'=>$current]);
        $now = Carbon::now()->format('y-m-d');

        $listDetail = DB::table('to_do_list as a')
                      ->join('to_do_list_dtl as b', 'a.id', 'b.list_id')
                      ->join('satuan as c', 'b.unit_id', 'c.id')
                      ->select('a.category_id', 'a.sleep_wakeup_time as rest', 'b.id', 'b.list_id', 'b.cal_title', 'b.protein', 'b.fat', 'b.carbohydrate', 'b.calories', 'b.portion', 'c.satuan', 'b.gram', 'a.id as idHdr')
                      ->where('a.user_id', $userId)
                      ->where('a.date', $date)
                      ->where('a.category_id', $kategori)
                      ->orderby('a.category_id')
                      ->orderby('b.cal_title')
                      ->get();

        if (count($listDetail) > 0)
            return response()->json(['code'=>'200', 'data'=>$listDetail]);
        else
            return response()->json(['code'=>'404', 'message'=>'tidak ada data']);
    }

    public function getCaloriesDetail(Request $req){
        $listId = $req['listId'];
        $list = DB::table('to_do_list_dtl')
                ->select('cal_id')
                ->where('id', $listId)
                ->first();

        $kalori = DB::table('calories_list as a')
                  ->join('calories_list_dtl as b', 'a.id', 'b.cal_id')
                  ->select('b.id', 'b.title', 'b.protein', 'b.fat', 'b.carbohydrate', 'b.bdd')
                  ->where('b.id', $list->cal_id)
                  ->first();

        $satuan = DB::table('satuan as a')
                  ->join('satuan_dtl as b', 'a.id', 'b.unit_id')
                  ->select('b.id', 'b.cal_id', 'a.satuan', 'b.gram', 'b.portion', 'b.unit_id')
                  ->where('b.cal_id', $list->cal_id)
                  ->orderby('a.id')
                  ->get();

        return response()->json(['code'=>'200', 'data'=>$kalori, 'dataDtl'=>$satuan]);
    }

    public function updateDataKalori(Request $req){
        $listId = $req['listId'];
        $nilaiSatuan = $req['nilaiSatuan'];
        $protein = $req['protein'];
        $lemak = $req['lemak'];
        $karbo = $req['karbo'];
        $gram = $req['gram'];
        $kalori = $req['kalori'];
        $unitId = $req['unitId'];
        // DB::enableQueryLog();

        if (! is_nan($nilaiSatuan)){
            $update = DB::table('to_do_list_dtl')
                      ->where('id', $listId)
                      ->update(['protein'=>$protein, 'fat'=>$lemak, 'carbohydrate'=>$karbo, 'calories'=>$kalori, 'portion'=>$nilaiSatuan, 'gram'=>$gram, 'unit_id'=>$unitId]);
                      
            // dd(DB::getQueryLog());
            if ($update)
                return response()->json(['code'=>'200', 'message'=>'berhasil update data']);
            else
                return response()->json(['code'=>'404', 'message'=>'gagal update data, periksa kembali data anda']);
        }
        else{
            return response()->json(['code'=>'404', 'message'=>'gagal update data, periksa kembali data anda']);
        }
    }

    public function deleteDataKalori(Request $req){
        $listId = $req['listId'];        
        $delete = DB::table('to_do_list_dtl')
                  ->where('id', $listId)
                  ->delete();
        if($delete)
            return response()->json(['code'=>'200', 'message'=>'berhasil hapus data']);
        else
            return response()->json(['code'=>'404', 'message'=>'gagal hapus data, silahkan mencoba kembali']);
    }

    public function tambahDataKalori(Request $req){
        $userId = $req['userData']['userId'];
        $kategori = $req['userData']['kategori1'];
        $date = $req['userData']['tanggal'];
        $date = date('Y-m-d', strtotime($date));
        $selected = $req['selected'];

        $listId = DB::table('to_do_list')
                  ->select('id')
                  ->where('user_id', $userId)
                  ->where('category_id', $kategori)
                  ->where('date', $date)
                  ->first();
        $listId = $listId->id;

        for($i=0;$i<count($selected);$i++){
            $insert = DB::table('to_do_list_dtl')
                      ->insert(['list_id'=>$listId, 'cal_id'=>$selected[$i]['id'], 'cal_title'=>$selected[$i]['judul'], 'protein'=>$selected[$i]['protein'], 'fat'=>$selected[$i]['lemak'], 'carbohydrate'=>$selected[$i]['karbo'], 'calories'=>$selected[$i]['kalori'], 'portion'=>$selected[$i]['porsi'], 'unit_id'=>$selected[$i]['unitId'], 'gram'=>$selected[$i]['gram']]);
        }
        if ($insert)
            return response()->json(['code'=>'200', 'message'=>'berhasil  menambah data']);
        else
            return response()->json(['code'=>'404', 'message'=>'gagal menambah data']);
    }

    public function viewMenu(Request $req){
        $userId = $req['userId'];
        $jenis = $req['jenis'];
        date_default_timezone_set('Asia/Jakarta');
        $current = Carbon::now()->format('y-m-d H:i:s');
        User::where('id', $userId)
        ->update(['last_login'=>$current]);
        
        if ($jenis == 'shared'){
            $menu = DB::table('menu')
                    ->select('id', 'user_fullname', 'title', 'description', 'share')
                    ->where('user_id', "<>", $userId)
                    ->where('share', 1)
                    ->get();
        }
        else if ($jenis == 'owner'){
             $menu = DB::table('menu')
                    ->select('id', 'title', 'description', 'share')
                    ->where('user_id', $userId)
                    ->get();
        }

        $item_data_decode = json_decode($menu, true);
        $values = array_column($item_data_decode, 'id');

        $menuDtl = DB::table('menu_dtl')
                   ->join('menu', 'menu.id', 'menu_dtl.menu_id')
                   ->join('satuan', 'satuan.id', 'menu_dtl.unit_id')
                   ->whereIn('menu_dtl.menu_id', $values)
                   ->select('menu_dtl.menu_id', 'menu_dtl.list_id', 'menu_dtl.food_name', 'menu_dtl.protein', 'menu_dtl.fat', 'menu_dtl.carbohydrate', 'menu.description', 'menu_dtl.portion', 'menu_dtl.gram', 'satuan.satuan', 'menu_dtl.calories')
                   ->get();

        if ($menuDtl)
            return response()->json(['code'=>'200', 'message'=>'berhasil ambil data', 'data'=>$menu, 'dataDtl'=>$menuDtl]);
        else
            return response()->json(['code'=>'404', 'message'=>'gagal mengambil data']);
    }

    public function deleteMenu(Request $req){
        $menuId = $req['menuId'];
        $delete = DB::table('menu_dtl')
                  ->where('menu_id', $menuId)
                  ->delete();
        if ($delete){
            $delete = DB::table('menu')
                      ->where('id', $menuId)
                      ->delete();
            return response()->json(['code'=>'200', 'message'=>'berhasil hapus menu']);
        }
        else
            return response()->json(['code'=>'404', 'message'=>'gagal hapus menu']);
    }

    public function addMenuFromOther(Request $req){
        $userId = $req['userId'];
        $userfullname = $req['userFName'];
        $menuId = $req['menuId'];

        $menu = DB::table('menu')
                ->where('id', $menuId)
                ->first();

        $id = DB::table('menu')
              ->insertGetId(['user_id'=>$userId, 'user_fullname'=>$userfullname, 'title'=>$menu->title, 'description'=>$menu->description, 'share'=>0]);

        $menuDtl = DB::table('menu_dtl')
                   ->where('menu_id', $menuId)
                   ->get();

        for($i=0;$i<count($menuDtl);$i++){
            DB::table('menu_dtl')
            ->insert(['menu_id'=>$id, 'menu_name'=>$menu->title, 'list_id'=>$menuDtl[$i]->list_id, 'food_name'=>$menuDtl[$i]->food_name, 'protein'=>$menuDtl[$i]->protein, 'fat'=>$menuDtl[$i]->fat,  'carbohydrate'=>$menuDtl[$i]->carbohydrate,  'calories'=>$menuDtl[$i]->calories,  'portion'=>$menuDtl[$i]->portion, 'gram'=>$menuDtl[$i]->gram,  'unit_id'=>$menuDtl[$i]->unit_id]);

            return response()->json(['code'=>'200', 'message'=>'berhasil tambah menu']);
        }
        
        return response()->json(['code'=>'404', 'message'=>'gagal hapus menu']);
    }

    public function viewMenuDetail(Request $req){
        $menuId = $req['menuId'];
        date_default_timezone_set('Asia/Jakarta');
        $current = Carbon::now()->format('y-m-d H:i:s');
        
        $menu = DB::table('menu')
                ->select('id', 'title', 'description', 'share')
                ->where('id', $menuId)
                ->get();

        $menuDtl = DB::table('menu_dtl')
                   ->join('menu', 'menu.id', 'menu_dtl.menu_id')
                   ->join('satuan', 'satuan.id', 'menu_dtl.unit_id')
                   ->where('menu_dtl.menu_id', $menuId)
                   ->select('menu_dtl.id', 'menu_dtl.menu_id', 'menu_dtl.list_id', 'menu_dtl.food_name', 'menu_dtl.protein', 'menu_dtl.fat', 'menu_dtl.carbohydrate', 'menu.description', 'menu_dtl.portion', 'menu_dtl.gram', 'satuan.satuan', 'menu_dtl.calories')
                   ->get();

        if ($menuDtl)
            return response()->json(['code'=>'200', 'message'=>'berhasil ambil data', 'data'=>$menu, 'dataDtl'=>$menuDtl]);
        else
            return response()->json(['code'=>'404', 'message'=>'gagal mengambil data']);
    }

    public function viewMenuDetail1(Request $req){
        $menuId = $req['menuId'];
        $calId = $req['calId'];
        date_default_timezone_set('Asia/Jakarta');
        $current = Carbon::now()->format('y-m-d H:i:s'); 

        $daftar = DB::table('calories_list as a')
                  ->join('calories_list_dtl as b', 'a.id', 'b.cal_id')
                  ->select('b.id', 'b.title', 'b.protein', 'b.fat', 'b.carbohydrate', 'b.bdd')
                  ->where('b.id', $calId)
                  ->orderby('b.id')
                  ->first();

        $menuDtl = DB::table('menu_dtl')
                   ->join('menu', 'menu.id', 'menu_dtl.menu_id')
                   ->join('satuan', 'satuan.id', 'menu_dtl.unit_id')
                   ->where('menu_dtl.id', $menuId)
                   ->select('menu_dtl.id', 'menu_dtl.menu_id', 'menu_dtl.list_id', 'menu_dtl.food_name', 'menu_dtl.protein', 'menu_dtl.fat', 'menu_dtl.carbohydrate', 'menu.description', 'menu_dtl.portion', 'menu_dtl.gram', 'satuan.satuan', 'menu_dtl.calories')
                   ->first();

        $satuan = DB::table('satuan as a')
                  ->join('satuan_dtl as b', 'a.id', 'b.unit_id')
                  ->select('b.id', 'b.cal_id', 'b.unit_id', 'a.satuan', 'b.gram', 'b.portion')
                  ->where('b.cal_id', $calId)
                  ->orderby('b.cal_id')
                  ->get();

        if ($menuDtl)
            return response()->json(['code'=>'200', 'message'=>'berhasil ambil data', 'kalori'=>$daftar, 'data'=>$menuDtl, 'satuan'=>$satuan]);
        else
            return response()->json(['code'=>'404', 'message'=>'gagal mengambil data']);
    }
}
