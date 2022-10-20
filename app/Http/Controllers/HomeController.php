<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Mail;
use App\Slider;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    public function __construct()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    public function error_page()
    {
        return view('errors.404');
    }
    public function send_mail()
    {
        //send mail
        $to_name = "Cao Hải";
        $to_email = "caohaixxx123@gmail.com"; //send to this email


        $data = array("name" => "Mail từ tài khoản Khách hàng", "body" => 'Mail gửi về vấn về hàng hóa'); //body of mail.blade.php

        Mail::send('pages.send_mail', $data, function ($message) use ($to_name, $to_email) {

            $message->to($to_email)->subject('xxx'); //send this mail with subject
            $message->from($to_email, $to_name); //send from this mail
        });
        // return redirect('/')->with('message','');
        //--send mail
    }

    public function index(Request $request)
    {
        //slide
        $slider = Slider::orderBy('slider_id', 'DESC')->where('slider_status', '1')->take(4)->get();
        //seo 
        $meta_desc = "Trang sức phụ kiện cao cấp";
        $meta_keywords = "trang suc";
        $meta_title = "Trang sức phụ kiện cao cấp";
        $url_canonical = $request->url();
        //--seo
        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();
        $all_product = DB::table('tbl_product')
            ->leftJoin('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
            ->leftJoin('tbl_brand', 'tbl_brand.brand_id', '=', 'tbl_product.brand_id')
            ->where('product_status', '0');
        parse_str(parse_url($request->fullUrl(), PHP_URL_QUERY), $urlQuery);
        $searchList = [];
        if ($urlQuery) {
            if (array_key_exists('danh_muc', $urlQuery)) {
                $all_product->where('tbl_product.category_id', $urlQuery['danh_muc']);
                $cate = DB::table('tbl_category_product')->where('category_status', '0')->where('category_id', $urlQuery['danh_muc'])->first();
                if ($cate) {
                    $searchList[] = ["type" => 'danh_muc', "name" => $cate->category_name, "id" => $cate->category_id];
                }
            }

            if (array_key_exists('thuong_hieu', $urlQuery)) {
                $all_product->where('tbl_product.brand_id',  $urlQuery['thuong_hieu']);
                $brand = DB::table('tbl_brand')->where('brand_status', '0')->where('brand_id', $urlQuery['thuong_hieu'])->first();
                if ($brand)
                $searchList[] = ["type" => 'thuong_hieu', "name" => $brand->brand_name, "id" => $brand->brand_id];
            }

            if (array_key_exists('keys', $urlQuery)) {
                $all_product->where('tbl_product.product_name', "like", '%' . $urlQuery['keys'] . '%');
                $searchList[] = ["type" => 'keys', "name" => $urlQuery['keys'], "id" => 1];
            }
        }

        return view('pages.home')->with('category', $cate_product)
            ->with('brand', $brand_product)->with('all_product', $all_product->paginate(6))
            ->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)
            ->with('meta_title', $meta_title)->with('url_canonical', $url_canonical)
            ->with('slider', $slider) //1
            ->with('searchList', $searchList);

    }
    public function search(Request $request)
    {
        //slide
        $slider = Slider::orderBy('slider_id', 'DESC')->where('slider_status', '1')->take(4)->get();

        //seo 
        $meta_desc = "Tìm kiếm sản phẩm";
        $meta_keywords = "Tìm kiếm sản phẩm";
        $meta_title = "Tìm kiếm sản phẩm";
        $url_canonical = $request->url();
        //--seo
        $keywords = $request->keywords_submit;

        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();

        $search_product = DB::table('tbl_product')->where('product_name', 'like', '%' . $keywords . '%')->get();


        return view('pages.sanpham.search')->with('category', $cate_product)->with('brand', $brand_product)->with('search_product', $search_product)->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)->with('url_canonical', $url_canonical)->with('slider', $slider);
    }
}
