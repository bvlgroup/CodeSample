<?php
namespace App\Repositories\Banner;

use App\Core\BaseRepository;
use App\Banner;
use DB;

class BannerRepository extends BaseRepository implements BannerRepositoryInterface{

    protected $model;

    /**
     * @param Product $product
     */
    public function __construct(Banner $banner)
    {
        $this->model = $banner;
    }
    
    public function getBanner($where = array(), $params = array()){
        $datas = banner::where($where);
        if(isset($params['select'])){
            $datas = $datas->select($params['select']);
        }
        $datas = $datas->join("code_main",'code_main.cd_main','=','banner.cate_code_2');
        if(isset($params['title'])){
            $title = $params['title'];
            $datas =  $datas->where(function($query) use ($title){
                        $query->where("banner.banner_title","LIKE","%".$title."%");
            });
        }
        if(isset($params['start'])){
             $datas = $datas->whereDate('banner.created_at','>=',$params['start']);
        }
        if(isset($params['end'])){
             $datas = $datas->whereDate('banner.created_at','<=',$params['end']);
        }
        $datas = $datas->groupBy('banner.id');
        if(isset($params['first']))
            $datas = $datas->first();
        elseif(isset($params['paginate']))
            $datas = $datas->paginate($params['paginate']);
        else
            $datas = $datas->get();
        return $datas;
    }
    public function getcout($cate_code_2){
        $check_slug = Banner::select([DB::raw('count(banner.cate_code_2) as count')])->where('cate_code_2',$cate_code_2)->pluck('count');
        if(!empty($check_slug)){
           $slug = $check_slug;
        }
        else{
            $slug=0;
        }
        return $slug;
    }
    // public function getUniqueSlug($slug){
    //     $check_slug = FaqBoard::where('title_slug','LIKE',$slug.'%')->count();
    //     if(!empty($check_slug)){
    //         $index = $check_slug + 1;
    //         $slug .= '-'.$check_slug;
    //     }
    //     return $slug;
    // }

    public function getBannerHome(){
        $data = Banner::select('banner_thumb')->where('is_visible','=','Y');
        $data = $data->whereDate('banner_start','<',Date('Y-m-d H:i:s'))->whereDate('banner_end','>',Date('Y-m-d H:i:s'))->orderBy('created_at','desc')->take(10);
        return $data->get();
    }
}