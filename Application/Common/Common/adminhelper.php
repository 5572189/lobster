<?php
use Common\Util\Think\Page;
use Common\Builder\ListBuilder;
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.noble-spirits.com All rights reserved.
// +----------------------------------------------------------------------
// 开发者二次开发后台公共函数统一写入此文件，不要修改function.php以便于系统升级。
function generate_export_btn($url) {
	$exportBtn['title'] = '导出数据';
	$exportBtn['class'] = 'btn btn-primary export';
	$exportBtn['href'] = U ($url, I ('get.'), false);
	
	return $exportBtn;
}
function generate_excel_name($name) {
	return iconv ('utf-8', 'gb2312', $name . '-' . date ("YmdHis", time ()));
}
function combine_data_with_key($dataTo, $dataFrom, $keyName, $columns, $order_asc = true) {
	$foundRec = false;
	
	foreach ( $dataFrom as $k => $v ) {
		$foundRec = false;
		
		for($i = 0; $i < sizeof ($dataTo); $i++) {
			if ($dataTo[$i][$keyName] == $v[$keyName]) {
				foreach ( $columns as $fieldName ) {
					$dataTo[$i][$fieldName] = $v[$fieldName];
				}
				$foundRec = true;
				break;
			}
		}
		
		if (!$foundRec) {
			$newRec = [];
			$newRec[$keyName] = $v[$keyName];
			foreach ( $columns as $fieldName ) {
				$newRec[$fieldName] = $v[$fieldName];
			}
			$dataTo[] = $newRec;
		}
	}
	return $dataTo;
}
function sort_datas($data, $keyName) {
	$orderKeys = array();
	foreach ( $data as $k => $v ) {
		if (!in_array ($v[$keyName], $orderKeys)) {
			$orderKeys[] = $v[$keyName];
		}
	}
	sort ($orderKeys);
	$sortedDatas = [];
	for($i = 0; $i < sizeof ($orderKeys); $i++) {
		foreach ( $data as $k => $v ) {
			if ($orderKeys[$i] == $v[$keyName]) {
				$sortedDatas[] = $data[$k];
				break;
			}
		}
	}
	return $sortedDatas;
}

/**
 * 获取后台用户数据
 */
function lists($tableName, $map = '1', $order = 'id DESC', $p = false, $pageLimit = 0) {
	$model_object = D ($tableName);
	if ($p === false) {
		$data_list = $model_object->where ($map)
			->order ($order)
			->select ();
		writeLog ($model_object->getLastSql (), 'list');
		return [$data_list, $model_object];
	} else {
		if ($pageLimit == 0) {
			$pageLimit = C ("ADMIN_PAGE_ROWS");
		}
		$data_list = $model_object->page ($p, $pageLimit)
			->where ($map)
			->order ($order)
			->select ();
		$page = new Page ($model_object->where ($map)
			->count (), $pageLimit);
		return [$data_list, $page, $model_object];
	}
}
function extendTime(&$map, $field = 'update_time') {
	$dates = I ('dates', '', 'trim');
	if ($dates) {
		$start_date = strtotime (substr ($dates, 0, 10));
		$end_date = strtotime (substr ($dates, 11, 10));
		$map[$field] = [['egt', $start_date], ['lt', $end_date]]
		// ['exp', 'IS NOT NUll'],
		;
	}
	// else {
	// $start_date = datetime("-365 days", 'Y-m-d');
	// $end_date = datetime('now', 'Y-m-d');
	// }
}
function extendDates(&$map, $field = 'update_time') {
	$dates = I ('dates', '', 'trim');
	if (preg_match ("/([\x81-\xfe][\x40-\xfe])/", $dates, $match)) {
		$start_date = datetime ("-365 days", 'Y-m-d');
		$end_date = datetime ('now', 'Y-m-d');
		$map[$field] = [['egt', $start_date . ' 00:00:00'], ['lt', $end_date . ' 23:59:59']]
		// ['exp', 'IS NOT NUll'],
		;
	} else {
		if ($dates) {
			$start_date = substr ($dates, 0, 10);
			$end_date = substr ($dates, 11, 10);
			$map[$field] = [['egt', $start_date . ' 00:00:00'], ['elt', $end_date . ' 23:59:59']]
			// ['exp', 'IS NOT NUll'],
			;
		}
		// else {
		// $start_date = datetime("-365 days", 'Y-m-d');
		// $end_date = datetime('now', 'Y-m-d');
		// }
	}
}
// 扩展日期搜索map
function extendDatesToTime(&$map, $field = 'time_end') {
	$dates = I ('dates', '', 'trim');
	if (preg_match ("/([\x81-\xfe][\x40-\xfe])/", $dates, $match)) {
		$start_date = datetime ("-365 days", 'Y-m-d');
		$end_date = datetime ('now', 'Y-m-d');
		$map[$field] = [['egt', strtotime ($start_date . ' 00:00:00')], ['lt', strtotime ($end_date . ' 23:59:59')]];
	} else {
		if ($dates) {
			$start_date = substr ($dates, 0, 10);
			$end_date = substr ($dates, 11, 10);
			$map[$field] = [['egt', strtotime ($start_date . ' 00:00:00')], ['lt', strtotime ($end_date . ' 23:59:59')]];
		}
	}
}
function common_search($table, $joinTables, $fields, $map, $order, $metatitle, $columns, $topButtons, $searchFields, $listButtons = null) {
	$p = !empty ($_GET["p"]) ? $_GET['p'] : 1;
	$model = M ($table);
	foreach ( $joinTables as $val ) {
		$model->join ($val);
	}
	if ($order == null)
		$order = 'id asc';
	
	$data_list = $model->field ($fields)
		->where ($map)
		->page ($p, C ('ADMIN_PAGE_ROWS'))
		->order ($order)
		->select ();
	// var_dump($data_list);die();
	
	$pageModel = M ($table);
	foreach ( $joinTables as $val ) {
		$pageModel->join ($val);
	}
	$page = new Page ($pageModel->where ($map)
		->count (), C ('ADMIN_PAGE_ROWS'));
	
	$builder = new ListBuilder ();
	$builder->setMetaTitle ($metatitle);
	foreach ( $topButtons as $arr ) {
		$builder->addTopButton ($arr[0], $arr[1]);
	}
	foreach ( $searchFields as $arr ) {
		if ($arr[1] == 'dateranger' && count ($arr) > 4)
			$builder->addSearchItem ($arr[0], $arr[1], $arr[2], $arr[3], $arr[4]);
		else
			$builder->addSearchItem ($arr[0], $arr[1], $arr[2], $arr[3]);
	}
	foreach ( $columns as $arr ) {
		if (count ($arr) > 2)
			$builder->addTableColumn ($arr[0], $arr[1], $arr[2]);
		else
			$builder->addTableColumn ($arr[0], $arr[1]);
	}
	if ($listButtons != null) {
		$builder->addTableColumn ("right_button", "操作管理", "btn");
		
		foreach ( $listButtons as $arr ) {
			$builder->addRightButton ($arr[0], $arr[1]);
		}
	}
	
	return $builder->setTableDataList ($data_list)
		->setTableDataPage ($page->show ());
}
function common_export($table, $joinTables, $fields, $map, $order, $columns) {
	$model = M ($table);
	foreach ( $joinTables as $val ) {
		$model->join ($val);
	}
	
	if ($order == null)
		$order = 'id asc';
	
	$data_list = $model->field ($fields)
		->where ($map)
		->order ($order)
		->select ();
	
	return $data_list;
}