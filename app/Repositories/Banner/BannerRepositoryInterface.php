<?php

namespace App\Repositories\Banner;

use App\Core\BaseRepositoryInterface;

interface BannerRepositoryInterface extends BaseRepositoryInterface{
    public function getBanner($where = array(), $params = array());
    public function getcout($slug);
    // public function getUniqueSlug($slug);
}
