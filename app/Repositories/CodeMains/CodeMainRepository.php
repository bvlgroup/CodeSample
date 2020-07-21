<?php
namespace App\Repositories\CodeMains;

use App\Core\BaseRepository;
use App\CodeMain;
use DB;

class CodeMainRepository extends BaseRepository implements CodeMainRepositoryInterface{

    protected $model;

    /**
     * @param CodeMain $model
     */
    public function __construct(CodeMain $model)
    {
        $this->model = $model;
    }
    /**
     * Admin manager - level code data
     * @return mixed
     */
    public function getAdminLevelCodes(){
        return $this->model->where("in_use", 'Y')->where('cd_group', config('constant.code_group.admin_level'))->pluck('cd_main_name', 'cd_main');
    }

    /**
     * Member info - member type data
     * @return mixed
     */
    public function getMemberType(){
        return $this->model->where("in_use", 'Y')->where('cd_group', config('constant.code_group.member_type'))->pluck('cd_main_name', 'cd_main');
    }

    /**
     * Member info - Field of activity
     * @return mixed
     */
    public function getMemberFieldOfActivity(){
        return $this->model->where("in_use", 'Y')->where('cd_group', config('constant.code_group.member_fd_actvty_code'))->pluck('cd_main_name', 'cd_main');
    }
    /**
     * Member info - Mentor's special area
     * @return mixed
     */
    public function getMemberMentorSpecialArea(){
        return $this->model->where("in_use", 'Y')->where('cd_group', config('constant.code_group.member_spc_area_code'))->pluck('cd_main_name', 'cd_main');
    }
    /**
     * Member info - activity Mentor
     * @return mixed
     */
    public function getMemberMentorActivity(){
        return $this->model->where("in_use", 'Y')->where('cd_group', config('constant.code_group.member_fd_actvty_code'))->get();
    }
    /**
     * trip_qna - cate_code_3
     * @return mixed
     */
    public function getTripQnaInterest(){
        return $this->model->where("in_use", 'Y')->where('cd_group', config('constant.code_group.trip_qna_cate_code_3'))->pluck('cd_main_name', 'cd_main');
    }
    /**
     * trip_qna - cate_code_3
     * @return mixed
     */
    public function getCodeGroup(){
        return $this->model->select("cd_main","cd_main_name")->groupBy("cd_group")->get();
    }
}
