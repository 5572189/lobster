<?php
namespace Admin\Model;

use Think\Model;
class CityModel extends Model{
    protected $tableName = 'city';
    
    /**
     * @title : 列表数据
     * @time  : 2018年6月13日
     */
    public function getList () { 
        $result = M('city')->where(['status' => 1])->order('sort asc')->select();        
        return $result;
    }
}