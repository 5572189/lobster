<?php
    // +----------------------------------------------------------------------
    // | Copyright (c) 2016 http://www.noble-spirits.com All rights reserved.
    // +----------------------------------------------------------------------
    namespace User\Admin;

    use Admin\Controller\AdminController;
   //迁哥哥创建的 2018年5月9日 14:41:34
    class ConsumeAdmin extends AdminController {


        public function index () {
            $where = [] ;

            $list = M('admin_user')->where ( $where )->limit ( ( I ( 'get.p' , 1 ) - 1 ) * C ( "ADMIN_PAGE_ROWS" ) , C ( "ADMIN_PAGE_ROWS" ) )->order ( 'id desc' )->select ();

            $rest = new \Shop\Controller\IndexController() ;

            $map ['ns_uid'] = json_encode(array_column($list,'ns_uid'));

            $data = $rest->getShopConsumeAll( $map ) ;
            foreach($data['data']['result']['data'] as $uid=>$d){

            }
            $this->assign('list' , $list ) ;
            $this->assign('data' , $data['data']['result']['data'] ) ;

            $pages = new \Common\Util\Think\Page (M('admin_user')->where ( $where )->count('id') , C ( "ADMIN_PAGE_ROWS" )) ;

            $this->assign('pages' , $pages->show()) ;
            $this->assign('get' ,I ( 'get.') ) ;
            $this->display() ;
        }

        public function export () {
            $where = [] ;
            $where [ 'user_type' ] = [ 'eq' , 0 ] ;
            $where [ 'ns_uid' ] = [ 'neq' , 0 ] ;
            $dates = I ( 'get.dates' , '' , 'trim' );
            if ( ! empty ( $dates ) ) {
                $where ['create_time'] = [ [ 'egt' , strtotime ( substr ( $dates , 0 , 10 ) . ' 00:00:00' ) ] , [ 'lt' , strtotime ( substr ( $dates , 11 , 10 ) . ' 23:59:59' ) ] ];
            }
            $mobile = I ( 'get.mobile' , '' , 'trim' );
            if ( $mobile ) {
                $where ['mobile'] = [ 'eq' , $mobile ] ;
            }
            $nickname = I ( 'get.nickname' , '' , 'trim' );
            if ( $nickname ) {
                $where ['nickname'] = [ 'eq' , $nickname ] ;
            }
            $cnname = I ( 'get.cnname' , '' , 'trim' );
            if ( $cnname ) {
                $where ['cnname'] = [ 'eq' , $cnname ] ;
            }
            $list = M('admin_user')->where ( $where )->order ( 'id desc' )->select ();
            $xlsName = "用户列表";
            $xlsCell = array(
                array('id' , 'ID') ,
                array('nickname' , '微信昵称') ,
                array('username' , '姓名') ,
                array('mobile' , '手机号码') ,
                array('create_time' , '注册时间') ,
                array('reg_ip_address' , '注册地址')
            );
            if ( $list ) {
                foreach ($list as $key => &$record) {
                    $xlsData [$key]['id'] = $record['id'] ;
                    $xlsData [$key]['nickname'] = $record['nickname'] ;
                    $xlsData [$key]['username'] = $record['username'] ;
                    $xlsData [$key]['mobile'] = $record['mobile'] ;
                    $xlsData [$key]['create_time'] = time_format($record['create_time']) ;
                    $xlsData [$key]['reg_ip_address'] = $record['reg_ip_address'] ;
                }
            }
            exportExcel($xlsName , $xlsCell , $xlsData);
        }
    }