<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CodeMains\CodeMainRepositoryInterface;
use App\Repositories\Banner\BannerRepositoryInterface;
use DB;
use App\Http\Requests\BannerRequest;
use Auth;
use Config;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Log;            
use Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
class BannerController extends Controller
{
    protected $bannerRepository;
    protected $codeMainRepository;
    public function __construct(BannerRepositoryInterface $bannerRepository, CodeMainRepositoryInterface $codeMainRepository){
        $this->bannerRepository = $bannerRepository;
        $this->codeMainRepository = $codeMainRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $params = [
            'select'    =>  ["banner.id","banner.cate_code_2","banner.banner_image","banner.banner_thumb","banner.link_url","banner.banner_title","banner.banner_text","banner.banner_start","banner.banner_end","banner.is_visible","banner.link_target",'code_main.cd_main_name','banner.created_at'],
            'paginate'  =>  20
        ];
        $where = [];
        if(!empty($request->title)){
            $params['title'] = $request->title;
        }
        if(!empty($request->start)){
            $params['start'] = $request->start;
        }
        if(!empty($request->end)){
            $params['end'] = $request->end;
        }
        if(!empty($request->category)){
            $where[] = ['code_main.cd_main','=',$request->category];
        }
        $banner = $this->bannerRepository->getBanner($where,$params);
        $codeMains = $this->codeMainRepository->select(["id","cd_group","cd_main","cd_main_name","in_use"])->where(["in_use"=>'Y','cd_group'=>Config::get('constant.code_group.banner_code_2')])->all();
        // $coutCate= $this->bannerRepository->select(['cate_code_2',DB::raw('count(banner.cate_code_2) as count')])->groupBy('cate_code_2')->pluck('count','cate_code_2');

        $coutCate= $this->bannerRepository->select(['cate_code_2',DB::raw('0 as count')])->groupBy('cate_code_2')->pluck('count','cate_code_2');
        // dd($coutCate);
        $data = [
            'banner'  =>  $banner,
            'codeMains' =>  $codeMains,
            'coutCate'=> $coutCate
        ];
        return view('admin.banner.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $codeMains = $this->codeMainRepository->select(["id","cd_group","cd_main","cd_main_name","in_use"])
        ->where(["in_use"=>'Y','cd_group'=>Config::get('constant.code_group.banner_code_2')])->all();
        $coutCate= $this->bannerRepository->select([DB::raw('count(banner.cate_code_2) as count'),'cate_code_2'])->groupBy('cate_code_2')->pluck('count','cate_code_2');
        $cot=0;
        $code= array();
        foreach($codeMains as $cm=>$item){
            if(!empty($coutCate[$item->cd_main]) && $coutCate[$item->cd_main]>=10){
            }
            else
            array_push($code,$codeMains[$cot]);
            $cot++;
        }
        $data = [
            'codeMains' =>  $code
        ];
        return view('admin.banner.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BannerRequest $request)
    {
        try{
            $model = null;
            $check=null;
            \DB::transaction(function() use ($request, &$model,&$check){
                $data = $request->all();
                // print_r($data);
                if ($request->is_visible == 'on') {
                    $data['is_visible'] = 'Y';
                }
                else{
                    $data['is_visible'] = 'N';
                }
                if ($request->target == '1') {
                    $data['link_target']= config('constant.target.1');
                }
                else{
                     $data['link_target']= config('constant.target.2');
                }

                $data['cate_code_1']= '108';
                //prepare data
                //file attach
                $files = [];
                if($request->has('attach_evidence_file')){
                    $files=$request->attach_evidence_file->store('banner', 'public');
                    $data['banner_image']= 'storage/'.$files;
                    $path = 'storage/banner/';
                    $img = Image::make($request->attach_evidence_file->getRealPath())->resize(400,null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save( $path. 'thumb'.$request->attach_evidence_file->hashName());
                    $data['banner_thumb'] = $path. 'thumb'.$request->attach_evidence_file->hashName();
                }
                $coutCate= $this->bannerRepository->select([DB::raw('count(banner.cate_code_2) as count')])->where('cate_code_2',$data['cate_code_2'])->pluck('count');
                // print_r($coutCate);
                if($coutCate[0] >= 10){
                    $check= 0;
                    // dd($check);
                }
                else{
                    $model = $this->bannerRepository->create($data);
                    $check=1;
                }
            });
            
            if($check == 1){
                $messages = 'User ID: '.Auth::user()->id.' - User Display Name: '.Auth::user()->name.' have created banner  successfully.';
                Log::info($messages);
                DB::commit();
                return redirect()->route('banner.index')->with('status',__('You have created successfully'));
            }
            else
            return redirect()->route('banner.create')->with('status',__('category exceeds 10'));
                
        }
        catch(\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());
            return json_encode(['success'=>false,'message'=>__('You can not create   banner'),$e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $banner = $this->bannerRepository->find($id);
        $codeMains = $this->codeMainRepository->select(["id","cd_group","cd_main","cd_main_name","in_use"])->where(["in_use"=>'Y','cd_group'=>Config::get('constant.code_group.banner_code_2')])->all();
        $data = [
            'codeMains' =>  $codeMains,
            'banner'   =>  $banner
        ];
        return view('admin.banner.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BannerRequest $request, $id)
    {
        DB::beginTransaction();
        $data = $request->all();
        $check=null;
        if ($request->is_visible == 'on') {
            $data['is_visible'] = 'Y';
        }
        else{
            $data['is_visible'] = 'N';
        }
        if ($request->target == '1') {
            $data['link_target']= config('constant.target.1');
        }
        else{
                $data['link_target']= config('constant.target.2');
        }
        $data['cate_code_1']= '108';
        $banner = $this->bannerRepository->find($id);
        $files = [];
        if($request->has('attach_evidence_file')){
            File::delete($banner->banner_image);
            File::delete($banner->banner_thumb);
            $files=$request->attach_evidence_file->store('banner', 'public');
            $data['banner_image']= 'storage/'.$files;
            $path = 'storage/banner/';
            $img = Image::make($request->attach_evidence_file->getRealPath())->resize(null, 200, function ($constraint) {
                $constraint->aspectRatio();
            })->save( $path. 'thumb'.$request->attach_evidence_file->hashName());
            $data['banner_thumb'] = $path. 'thumb'.$request->attach_evidence_file->hashName();
        }
        // limit category 
        $coutCate= $this->bannerRepository->getcout($data['cate_code_2']);
        if($coutCate[0] >10 && $banner->cate_code_2 == $data['cate_code_2']){
            $check= 0;
        }
        elseif($coutCate[0] >=10 && $banner->cate_code_2 != $data['cate_code_2']){
            $check= 0;
        }
        else{
            $model = $this->bannerRepository->update($id,$data);
            $check=1;
        }
        if($check == 1){
            $messages = 'User ID: '.Auth::user()->id.' - User Display Name: '.Auth::user()->name.' have updated banner "'.$model->title.'" successfully.';
            Log::info($messages);
            DB::commit();
            return redirect()->route('banner.index')->with('status',__('You have edit successfully'));
        }
        else
        return redirect()->back()->with('error',__('category exceeds 10.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        try{
            DB::beginTransaction();
            $banner = $this->bannerRepository->find($id);
            File::delete($banner->banner_image);
            File::delete($banner->banner_thumb);
            $ban = $this->bannerRepository->destroy($id);
            $messages = 'User ID: '.Auth::user()->id.' - User Display Name: '.Auth::user()->name.' have deleted banner #"'.$id.'" successfully.';
            $message = __('You have deleted successfully.');
            Log::info($messages);
            DB::commit();
            return json_encode(['success'=>true,'message'=>$message]);
        }catch(\Exception $e){
            DB::rollBack();
            Log::error('User ID: '.Auth::user()->id.' - User Display Name: '.Auth::user()->name.' deleted notice with error '.$e->getMessage());
            return redirect()->route('banner.index')->json_encode(['success'=>false,'message'=>__('You can not deleted banner')]);
        }
    }
    public function toggleActive(Request $request)
    {
        try{
            DB::beginTransaction();
            if(empty($request->id)){
                return json_encode(['success'=>false,'message'=>__('banner Not Found')]);
            }
            $banner = $this->bannerRepository->find($request->id);
            if(empty($banner)){
                return json_encode(['success'=>false,'message'=>__('banner Not Found')]);
            }
            $is_visible = $banner->is_visible;
            if($is_visible=='N'){
                $banner->is_visible = 'Y';
                $messages = 'User ID: '.Auth::user()->id.' - User Display Name: '.Auth::user()->name.' have actived banner "'.$banner->banner_title.'" successfully.';
                $message = __('You have actived successfully.');
            }else{
                $banner->is_visible = 'N';
                $messages = 'User ID: '.Auth::user()->id.' - User Display Name: '.Auth::user()->name.' have deactived banner "'.$banner->banner_title.'" successfully.';
                $message = __('You have deactived successfully.');
            }
            $banner->save();
            Log::info($messages);   
            DB::commit();
            return json_encode(['success'=>true,'message'=>$message,'reload'=>false]);
        }catch(\Exception $e){
            DB::rollBack();
            Log::error('User ID: '.Auth::user()->id.' - User Display Name: '.Auth::user()->name.' updated banner with error '.$e->getMessage());
            return json_encode(['success'=>false,'message'=>__('You can not updated banner')]);
        }
    }
    public function deleteMultiple(Request $request)
    {
        try{
            DB::beginTransaction();
            if(empty($request->ids)){
                return json_encode(['success'=>false,'message'=>__('banner Not Found')]);
            }
            $faq = $this->bannerRepository->destroy($request->ids);
            $messages = 'User ID: '.Auth::user()->id.' - User Display Name: '.Auth::user()->name.' have deleted banner "'.implode(", ", $request->ids).'" successfully.';
            $message = __('You have deleted has ticked successfully.');
            Log::info($messages);
            DB::commit();
            return json_encode(['success'=>true,'message'=>$message]);
        }catch(\Exception $e){
            DB::rollBack();
            Log::error('User ID: '.Auth::user()->id.' - User Display Name: '.Auth::user()->name.' deleted banner with error '.$e->getMessage());
            return json_encode(['success'=>false,'message'=>__('You can not deleted banner has ticked')]);
        }
    }
}
