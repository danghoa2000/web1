<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Session;
use App\Social;
use Socialite;
use App\Login;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Validator;
use App\Rules\Captcha;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function login_google()
    {
        return Socialite::driver('google')->redirect();
    }
    public function callback_google()
    {
        $users = Socialite::driver('google')->stateless()->user();
        // // return $users->id;
        // return $users->name;
        // return $users->email;
        $authUser = $this->findOrCreateUser($users, 'google');
        $account_name = Login::where('admin_id', $authUser->user)->first();
        Session::put('admin_name', $account_name->admin_name);
        Session::put('admin_id', $account_name->admin_id);
        return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');
    }
    public function findOrCreateUser($users, $provider)
    {
        $authUser = Social::where('provider_user_id', $users->id)->first();
        if ($authUser) {

            return $authUser;
        }

        $hieu = new Social([
            'provider_user_id' => $users->id,
            'provider' => strtoupper($provider)
        ]);

        $orang = Login::where('admin_email', $users->email)->first();

        if (!$orang) {
            $orang = Login::create([
                'admin_name' => $users->name,
                'admin_email' => $users->email,
                'admin_password' => '',
                'admin_phone' => '',
                'admin_status' => 1

            ]);
        }

        $hieu->login()->associate($orang);

        $hieu->save();

        $account_name = Login::where('admin_id', $hieu->user)->first();
        Session::put('admin_name', $account_name->admin_name);
        Session::put('admin_id', $account_name->admin_id);

        return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');
    }

    public function login_facebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback_facebook()
    {
        $provider = Socialite::driver('facebook')->user();
        $account = Social::where('provider', 'facebook')->where('provider_user_id', $provider->getId())->first();
        if ($account) {
            //login in vao trang quan tri  
            $account_name = Login::where('admin_id', $account->user)->first();
            Session::put('admin_name', $account_name->admin_name);
            Session::put('admin_id', $account_name->admin_id);
            return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');
        } else {

            $hieu = new Social([
                'provider_user_id' => $provider->getId(),
                'provider' => 'facebook'
            ]);

            $orang = Login::where('admin_email', $provider->getEmail())->first();

            if (!$orang) {
                $orang = Login::create([
                    'admin_name' => $provider->getName(),
                    'admin_email' => $provider->getEmail(),
                    'admin_password' => '',
                    'admin_phone' => ''

                ]);
            }
            $hieu->login()->associate($orang);
            $hieu->save();

            $account_name = Login::where('admin_id', $account->user)->first();
            Session::put('admin_name', $account_name->admin_name);
            Session::put('admin_id', $account_name->admin_id);
            return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');
        }
    }

    public function AuthLogin()
    {
        $admin_id = Session::get('admin_id');
        if ($admin_id) {
            return Redirect::to('dashboard');
        } else {
            return Redirect::to('admin')->send();
        }
    }

    public function index()
    {
        return view('admin_login');
    }
    public function show_dashboard()
    {
        $this->AuthLogin();
        $topProducts = DB::table('tbl_order')
            ->leftJoin('tbl_order_details', 'tbl_order_details.order_code', '=', 'tbl_order.order_code')
            ->leftJoin('tbl_product', 'tbl_product.product_id', '=', 'tbl_order_details.product_id')
            ->where('tbl_order.order_status', 2)
            ->select(
                'tbl_product.product_id',
                'tbl_product.product_name',
                DB::raw('SUM(tbl_order_details.product_sales_quantity) as total'),
            )
            ->groupBy('product_id')
            ->orderByDesc('total')
            ->take(10)
            ->get();
        return view('admin.dashboard', compact('topProducts'));
    }
    public function dashboard(Request $request)
    {
        //$data = $request->all();
        $data = $request->validate([
            //validation laravel 
            'admin_email' => 'required',
            'admin_password' => 'required',
            'g-recaptcha-response' => new Captcha(),    //dòng kiểm tra Captcha
        ]);

        $admin_email = $data['admin_email'];
        $admin_password = md5($data['admin_password']);
        $login = Login::where('admin_email', $admin_email)->where('admin_password', $admin_password)->first();
        if ($login) {
            $login_count = $login->count();
            if ($login_count > 0) {
                Session::put('admin_name', $login->admin_name);
                Session::put('admin_id', $login->admin_id);
                return Redirect::to('/dashboard');
            }
        } else {
            Session::put('message', 'Mật khẩu hoặc tài khoản bị sai.Vui lòng nhập lại');
            return Redirect::to('/admin');
        }
    }
    public function logout()
    {
        $this->AuthLogin();
        Session::put('admin_name', null);
        Session::put('admin_id', null);
        return Redirect::to('/admin');
    }

    public function salesStatistics(Request $request)
    {
        $startMonth =  (int)Carbon::parse($request->startMonth)->format('m');
        $endMonth =  (int)Carbon::parse($request->endMonth)->format('m');
        $year =  Carbon::parse($request->startMonth)->format('Y');
        $statistic = DB::table('tbl_order')
            ->leftJoin('tbl_order_details', 'tbl_order_details.order_code', '=', 'tbl_order.order_code')
            ->leftJoin('tbl_coupon', 'tbl_coupon.coupon_code', '=', 'tbl_order_details.product_coupon')
            ->where('tbl_order.order_status', 2)
            ->whereMonth('tbl_order.created_at', '>=', $startMonth)
            ->whereMonth('tbl_order.created_at', '<=', $endMonth)
            ->whereYear('tbl_order.created_at', $year)
            ->select(
                'tbl_order.order_code',
                'tbl_order.created_at',
                'tbl_coupon.coupon_condition',
                'tbl_coupon.coupon_number',
                DB::raw('(
                    CASE 
                        WHEN coupon_condition = 1
                        THEN 
                            SUM(tbl_order_details.product_price*tbl_order_details.product_sales_quantity)
                            - 
                            SUM(tbl_order_details.product_price*tbl_order_details.product_sales_quantity)*tbl_coupon.coupon_number/100
                            
                        WHEN coupon_condition = 2
                        THEN
                            SUM(tbl_order_details.product_price*tbl_order_details.product_sales_quantity)
                            - 
                            tbl_coupon.coupon_number
                        ELSE
                        SUM(tbl_order_details.product_price*tbl_order_details.product_sales_quantity)
                    END)
                    AS total'),
            )
            ->groupBy('tbl_order.order_code')
            ->get();
        $data = [];
        // render statistic by 12 month
        for ($i = (int)$startMonth; $i <= (int)$endMonth; $i++) {
            $order = $statistic->filter(function ($item) use ($i) {
                return Carbon::parse($item->created_at)->format('m') == $i;
            })->first();
            $data[] = ['total' => $order ? $order->total : 0, 'month' => $i, 'year' => $year];
        }
        return response()->json($data);
    }
}
