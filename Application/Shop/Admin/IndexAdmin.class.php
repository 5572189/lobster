<?php
namespace Shop\Admin;
use Admin\Controller\AdminController;
use Common\Builder\FormBuilder;
use Common\Builder\ListBuilder;
use Common\Util\Think\Page;

/**
 * 后台餐厅控制器
 *
 */
class IndexAdmin extends AdminController
{
    /**
     * 餐厅列表
     *
     */
    public function index()
    {
        // 获取所有餐厅
        $map['status'] = array('egt', '0'); // 禁用和正常状态
        $data_list = M('restaurant')->where($map)->select();


        // 使用Builder快速建立列表页面。
        $builder = new ListBuilder();
        $builder->setMetaTitle('用户列表') // 设置页面标题
        ->addTopButton('addnew') // 添加新增按钮
//         ->addTopButton('resume') // 添加启用按钮
//         ->addTopButton('forbid') // 添加禁用按钮
//         ->addTopButton('delete') // 添加删除按钮
            ->addTableColumn('id', 'ID')            
            ->addTableColumn('title', '餐厅名称')
            ->addTableColumn('city', '所在城市')
            ->addTableColumn('telephone', '电话')
            ->addTableColumn('create_time', '上线时间')
            ->addTableColumn('status', '状态', 'status')
            ->addTableColumn('right_button', '操作', 'btn')
            ->setTableDataList($data_list) // 数据列表
            ->addRightButton('edit') // 添加编辑按钮
//             ->addRightButton('self' , array('title' => '支付宝配置' , 'class' => 'label label-primary' , 'href' => U('ali_config' , ['id' => '__data_id__'])))
//             ->addRightButton('self' , array('title' => '汉堡牛排配置' , 'class' => 'label label-primary' , 'href' => U('activity_food' , ['id' => '__data_id__'])))
            ->addRightButton('forbid', ['model' => 'shop']) // 添加禁用/启用按钮
            ->display();
    }

    public function ali_config(){
        $model_object = M('shop_ali_config');
        if (IS_POST) {
            $data        = $model_object->create();
            $data['update_time'] = time();
            $shop_id = I('post.shop_id');
            $cfg = $model_object->where(['shop_id'=>$shop_id])->find();
            if ($data) {
                if (empty($cfg) && $model_object->add($data) || $model_object->where(['shop_id'=>$shop_id])->save($data)) {
                    $this->success('修改成功', U('index'));
                }
                else {
                    $this->error('修改失败', U('index'));
                }
            } else {
                $this->error($model_object->getError());
            }
        }
        else {

            $restaurant = M('restaurant')->find(I('get.id'));
            // 使用FormBuilder快速建立表单页面
            $builder = new FormBuilder();
            $builder->setMetaTitle('编辑') // 设置页面标题
            ->setPostUrl(U('')) // 设置表单提交地址
            ->addFormItem('app_id', 'text', 'APPID', '')
                ->addFormItem('merchant_private_key', 'textarea', '商户私钥', '')
                ->addFormItem('alipay_public_key', 'textarea', '支付宝公钥', '')
                ->addFormItem('shop_id', 'hidden', '', '')
                ->setFormData(array_merge(['shop_id' => $restaurant['ns_shop_id']],(array)$model_object->where(['shop_id'=>$restaurant['ns_shop_id']])->find()))
                ->display();
        }
    }
    /**
     * 新增餐厅
     *
     */
    public function add()
    {
        $model_object = M('restaurant');
        if (IS_POST) {
            $data        = $model_object->create();
            $data['create_time'] = datetime();
            if ($data) {
                if ($model_object->add($data)) {
                    $this->success('添加成功', U('index'));
                } else {
                    $this->error('添加失败', U('index'));
                }
            } else {
                $this->error($model_object->getError());
            }
        }
        else {


            // 使用FormBuilder快速建立表单页面
            $builder = new FormBuilder();
            $builder->setMetaTitle('新增') // 设置页面标题
                ->setPostUrl(U('')) // 设置表单提交地址
                ->addFormItem('title', 'text', '餐厅名称', '请输入餐厅名称')
                ->addFormItem('title_en', 'text', '餐厅名称(英文)', '请输入餐厅名称(英文)')
                ->addFormItem('city', 'text', '餐厅所在城市', '例如：上海')
                ->addFormItem('city_en', 'text', '餐厅所在城市(英文缩写)', '例如：SH')
//                 ->addFormItem('ns_shop_id', 'text', 'NS对应的shopid', '')
                ->addFormItem('content', 'kindeditor', '餐厅介绍详情', '请填写餐厅介绍详情')
                ->addFormItem('content_en', 'kindeditor', '餐厅介绍详情（英文）', '请填写餐厅介绍详情')
                ->addFormItem('open_hours', 'text', '营业时间', '请填写营业时间')                
                ->addFormItem('address', 'text', '详情地址', '请填写详细地址')
                ->addFormItem('address_en', 'text', '详情地址（英文）', '请填写详细地址')
                ->addFormItem('telephone', 'text', '联系电话', '请填写联系电话')                
                ->addFormItem('index_pic', 'picture', '首页封面图', '请上传封面，最佳尺寸 750x428')                
//                 ->addFormItem('list_pic', 'picture', '环境列表页封面图', '请上传封面，最佳尺寸 750x428')
//                 ->addFormItem('picture', 'pictures', '餐厅详情页主图', '请上传封面，最佳尺寸 750x428')                
                ->addFormItem('pics', 'pictures', '环境详情页图片', '请上传组图 最佳尺寸 750x423')
                ->addFormItem('status', 'radio', '状态', '', ['1' => '启用', '0' => '禁用'])
                ->setFormData(['status' => 1])
                ->display();
        }

    }

    /**
     * 编辑餐厅
     *
     */
    public function edit($id)
    {
        $model_object = M('restaurant');
        if (IS_POST) {
            $post = I('post.');
            $post['update_time'] = datetime();
            if (!$data = $model_object->create($post)) {
                $this->error($model_object->getError());
            } else {
                if (false !== $model_object->where(['id' => $id])->save($data)) {
                    $this->success('更新成功', U('index'));
                } else {
                    trace($model_object->getError());
                    $this->error('更新失败');
                }
            }
        } else {
            // 使用FormBuilder快速建立表单页面
            $builder = new FormBuilder();
            $builder->setMetaTitle('编辑') // 设置页面标题
                 ->setPostUrl(U('', ['id' => $id])) // 设置表单提交地址
                 ->addFormItem('title', 'text', '餐厅名称', '请输入餐厅名称')
                 ->addFormItem('title_en', 'text', '餐厅名称(英文)', '请输入餐厅名称(英文)')
                 ->addFormItem('city', 'text', '餐厅所在城市', '例如：上海')
                 ->addFormItem('city_en', 'text', '餐厅所在城市(英文缩写)', '例如：SH')                 
//                  ->addFormItem('ns_shop_id', 'text', 'NS对应的shopid', '')
                 ->addFormItem('content', 'kindeditor', '餐厅介绍详情', '请填写餐厅介绍详情')
                ->addFormItem('content_en', 'kindeditor', '餐厅介绍详情（英文）', '请填写餐厅介绍详情')
                ->addFormItem('open_hours', 'text', '营业时间', '请填写营业时间')                
                ->addFormItem('address', 'text', '详情地址', '请填写详细地址')
                ->addFormItem('address_en', 'text', '详情地址（英文）', '请填写详细地址')
                ->addFormItem('telephone', 'text', '联系电话', '请填写联系电话')                
                ->addFormItem('index_pic', 'picture', '首页封面图', '请上传封面，最佳尺寸 750x428')                
//                 ->addFormItem('list_pic', 'picture', '环境列表页封面图', '请上传封面，最佳尺寸 750x428')
//                 ->addFormItem('picture', 'pictures', '餐厅详情页主图', '请上传封面，最佳尺寸 750x428')                
                ->addFormItem('pics', 'pictures', '环境详情页图片', '请上传组图 最佳尺寸 750x423')
                 ->addFormItem('status', 'radio', '状态', '', ['1' => '启用', '0' => '禁用'])
                 ->setFormData(['status' => 1])
                ->setFormData($model_object->find($id))
                ->display();
        }
    }

    /**
     * 设置一条或者多条数据的状态
     *
     */
    public function setStatus($model = CONTROLLER_NAME, $script = false)
    {
        // $ids = I('request.ids');
        // if (is_array($ids)) {
        //     if (in_array('1', $ids)) {
        //         $this->error('超级管理员不允许操作');
        //     }
        // } else {
        //     if ($ids === '1') {
        //         $this->error('超级管理员不允许操作');
        //     }
        // }
        parent::setStatus($model);
    }

    public function set_food_gift () {

        $id = 20;
        $where = [] ;
        $where ['shop_id'] = $id ;
        $res = sendPost('index/food_gift',$where);
        $res = json_decode($res,true);
        $list = $res['data']['list'];
        $shop_info = $res['data']['shop_info'] ;
        $this->assign('list' , $list ) ;
        $this->assign('shop_info' , $shop_info ) ;
        $this->assign( 'meta_title' , '点餐设置赠品') ;
        $this->display();
    }

    public function set_food_gift_add () {
        $shop_id = 20;
        if (IS_POST) {

            $data = I('post.');
            if ($data) {
                $res = sendPost('index/food_gift_add',$data);
                $res = json_decode($res,true);
                $id = $res['data']['id'];
                if ($id) {
                    $this->success("新增成功" , U("set_food_gift",array('id'=>$data['shop_id'])));
                } else {
                    $this->error("新增失败");
                }
            } else {
                $this->error("新增失败");
            }
        } else {
            // 使用FormBuilder快速建立表单页面
            $builder = new \Common\Builder\FormBuilder();
            $builder->setMetaTitle("新增点餐赠品")// 设置页面标题
            ->setPostUrl(U(''))// 设置表单提交地址
            ->addFormItem('shop_id' , 'hidden' , '餐厅ID' , '')
                ->addFormItem("name" , "text" , "赠品名称" , "赠品名称")
                ->addFormItem("money" , "text" , "满足金额" , "赠送需要满足的积分")
                ->addFormItem("num" , "text" , "实际数量" , "实际数量:饮料：1杯；披萨：200g")
                ->addFormItem("order" , "num" , "排序" , "排序")
                ->addFormItem('status' , 'radio' , '状态' , '' , ['1' => '启用' , '0' => '禁用'])
                ->setFormData(['status' => 1,'shop_id'=>$shop_id])
                ->display();
        }
    }

    public function set_food_gift_edit () {
        $id = I('id' , 0 );
        if (IS_POST) {
            $data = I('post.');
            unset($data['id']);
            if ($data) {
                $res = sendPost('index/food_gift_edit',['data'=>json_encode($data),'id'=>$id]);
                $res = json_decode($res,true);
                $id = $res['data']['id'];
                if ($id) {
                    $this->success("编辑成功" , U("set_food_gift",array('id'=>$data['shop_id'])));
                } else {
                    $this->error("编辑失败");
                }
            } else {
                $this->error("编辑失败");
            }
        } else {
            $res = sendPost('index/food_gift_detail',['id'=>$id]);
            $res = json_decode($res,true);
            // 使用FormBuilder快速建立表单页面
            $builder = new \Common\Builder\FormBuilder();
            $builder->setMetaTitle("编辑")// 设置页面标题
            ->setPostUrl(U(''))// 设置表单提交地址
            ->addFormItem('id' , 'hidden' , '赠品ID' , '')
                ->addFormItem('shop_id' , 'hidden' , '餐厅ID' , '')
                ->addFormItem("name" , "text" , "赠品名称" , "赠品名称")
                ->addFormItem("money" , "text" , "满足金额" , "赠送需要满足的积分")
                ->addFormItem("num" , "text" , "实际数量" , "实际数量:饮料：1杯；披萨：200g")
                ->addFormItem("order" , "num" , "排序" , "排序")
                ->addFormItem('status' , 'radio' , '状态' , '' , ['1' => '启用' , '0' => '禁用'])
                ->setFormData($res['data']['info'])
                ->display();
        }
    }


    public function activity_food () {
        $id = I('get.id');
        $shop_id = M('restaurant')->where(['id'=>$id])->getField('ns_shop_id');
        $map = ['shop_id'=>$shop_id];
        if(I('get.type_name') != ''){
            $map['type_name'] = I('get.type_name');
        }
        if(I('get.status') !== ''){
            $map['status'] = I('get.status');
        }
        $param = [
            'map'=>json_encode($map),
            'page'=>I('get.p', 1)
        ];
        $res = sendPost('index/activity_food',$param);
        $res = json_decode($res,true);

        $data_list = $res['data']['list'];
        $page = new Page($res['data']['total'],20);

        $this->assign('status',I('get.status',''));
        $this->assign('type_name',I('get.type_name',''));
        $this->assign('id',$id);
        $this->assign('data',$data_list);
        $this->assign('pages',$page->show());
        $this->display();
        // 使用Builder快速建立列表页面。
        /*$builder = new ListBuilder();
        $builder->setMetaTitle("列表")// 设置页面标题
        ->addTopButton('addnew' , ['href' => U('activity_food_add',['id'=>I('get.id')])])
            ->addSearchItem('id' , 'hidden' , '分类' , '' )
            ->addSearchItem('type_name' , 'select' , '分类' , '' , ['汉堡'=>'汉堡','牛排'=>'牛排'])
            ->addTableColumn("id" , "id")
            ->addTableColumn("food_name" , "商品名")
            ->addTableColumn("status" , "状态" , 'status')
            ->addTableColumn("right_button" , "操作管理" , "btn")
            ->setTableDataList($data_list)// 数据列表
            ->setTableDataPage($page->show())// 数据列表分页
            ->addRightButton("edit" , ['href' => U('activity_food_edit' , ['id' => '__data_id__'])])
            //->alterTableData(['key'=>'status','value'=>'0'],['right_button'=>'<a class="label label-success ajax-get confirm" title="启用" href="'.U('activity_food_resume' , ['id' => '__data_id__']).'">启用</a>'])
            ->alterTableData(['key'=>'status','value'=>'1'],['right_button'=>'<a class="label label-warning ajax-get confirm" title="禁用" href="'.U('activity_food_forbid' , ['id' => '__data_id__']).'">禁用</a>'])

            ->display();*/
    }

    public function activity_food_add () {
        if (IS_POST) {
            $data = I('post.');
            if ($data) {
                $param = [
                    'data'=>json_encode($data,JSON_UNESCAPED_UNICODE),
                ];
                $res = sendPost('index/activity_food_add',$param);
                $res = json_decode($res,true);
                if ($res['data']['code']==200) {
                    $this->success("添加成功" , U("activity_food",array('id'=>$data['id'])));
                } else {
                    $this->error("添加失败");
                }
            } else {
                $this->error("添加失败");
            }
        } else {
            $id = I('get.id' , 0 );
            // 使用FormBuilder快速建立表单页面
            $builder = new \Common\Builder\FormBuilder();
            $builder->setMetaTitle("添加")// 设置页面标题
            ->setPostUrl(U(''))// 设置表单提交地址
            ->addFormItem('id' , 'hidden' , '门店ID' , '')
                ->addFormItem('type_name' , 'radio' , '分类' , '' , ['汉堡' => '汉堡' , '牛排' => '牛排'])
                ->addFormItem('shop_ids' , 'checkbox' , '菜品名称' , '门店',M('restaurant')->getField('ns_shop_id,title'))
                ->addFormItem('food_name' , 'text' , '菜品名称' , '菜品名称')
                ->addFormItem('status' , 'radio' , '状态' , '' , [ '0' => '禁用','1' => '启用'])
                ->setFormData(['id'=>$id,'shop_ids'=>$id,'status'=>1])
                ->display();
        }
    }


    public function activity_food_edit () {

        if (IS_POST) {
            $data = I('post.');
            if ($data) {
                $param = [
                    'data'=>json_encode($data,JSON_UNESCAPED_UNICODE),
                ];
                $res = sendPost('index/activity_food_edit',$param);
                $res = json_decode($res,true);
                if ($res['data']['code']==200) {
                    $this->success("修改成功" , U("activity_food",array('id'=>$data['rid'])));
                } else {
                    $this->error("修改失败");
                }
            } else {
                $this->error("添加失败");
            }
        } else {
            $id = I('get.id' , 0 );
            $info = sendPost('index/activity_food_info',['id'=>$id]);
            $info = json_decode($info,true);
            $info['data']['data']['rid'] = M('restaurant')->where(['ns_shop_id'=>$info['data']['data']['shop_id']])->getField('id');
            // 使用FormBuilder快速建立表单页面
            $builder = new \Common\Builder\FormBuilder();
            $builder->setMetaTitle("编辑")// 设置页面标题
            ->setPostUrl(U(''))// 设置表单提交地址
            ->addFormItem('id' , 'hidden' , '赠品ID' , '')
                ->addFormItem('rid' , 'hidden' , '赠品ID' , '')
                ->addFormItem('type_name' , 'radio' , '分类' , '' , ['汉堡' => '汉堡' , '牛排' => '牛排'])
                ->addFormItem('food_name' , 'text' , '菜品名称' , '菜品名称')
                ->addFormItem('status' , 'radio' , '状态' , '' , [ '0' => '禁用','1' => '启用'])
                ->setFormData($info['data']['data'])
                ->display();
        }
    }
    public function activity_food_resume(){
        $data = I('get.');
        if ($data) {
            $data['status'] = 1;
            $param = [
                'data'=>json_encode($data,JSON_UNESCAPED_UNICODE),
            ];
            $res = sendPost('index/activity_food_resume',$param);
            $res = json_decode($res,true);
            if ($res['data']['code']==200) {
                $this->success("修改成功");
            } else {
                $this->error("修改失败");
            }
        } else {
            $this->error("添加失败");
        }
    }
    public function activity_food_forbid(){
        $data = I('get.');
        if ($data) {
            $data['status'] = 0;
            $param = [
                'data'=>json_encode($data,JSON_UNESCAPED_UNICODE),
            ];
            $res = sendPost('index/activity_food_forbid',$param);
            $res = json_decode($res,true);
            if ($res['data']['code']==200) {
                $this->success("修改成功" );
            } else {
                $this->error("修改失败");
            }
        } else {
            $this->error("添加失败");
        }
    }
}
