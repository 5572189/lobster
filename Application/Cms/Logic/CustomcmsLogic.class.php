<?php
// +----------------------------------------------------------------------
// |
// +----------------------------------------------------------------------
namespace Cms\Logic;

/**
 * 幻灯片控制器
 */
class CustomcmsLogic {
	private static $logFile = 'CustomcmsLogic';
	public function aboutUs() {
		$data = M ('cms_aboutus')->order ('id desc')
			->limit (1)
			->field ('pics,title,title_en,content,content_en')
			->find ();
		
		$data['pics'] = getpics ($data['pics']);
		
		return $data;
	}
	public function menuList() {
		$data = M ('cms_menu')->order ('id desc')
			->field ('title,title_en,pic,rate')
			->select ();
		
		foreach ( $data as $k => &$v ) {
			$v['pic'] = getpics ($v['pic']);
		}
		return $data;
	}
	public function videoList() {
		$data = M ('cms_brandvideo')->order ('id desc')
			->field ('title,file,cover')
			->select ();
		
		foreach ( $data as $k => &$v ) {
			$v['file'] = getvideo ($v['file']);
			$v['cover'] = getpics ($v['cover']);
		}
		return $data;
	}
	public function newsList($limit = -1) {
		// writeLog("{$id} : " . var_export($map, true),self::$logFile);
		if ($limit > 0) {
			$data = M ('cms_news')
				->order ('news_date desc')
				->field ('id, title, title_en, cover, news_date')
				->limit ($limit)
				->order ('id desc')
				->select ();
		} else {
			$data = M ('cms_news')->order ('id desc')
				->field ('id, title, title_en, cover, news_date')
				->order ('id desc')
				->select ();
		}
		
		foreach ( $data as $k => &$v ) {
			$v['cover'] = getpics ($v['cover']);
			$v['news_date'] = date ('Y-m-d', $v['news_date']);
		}
		return $data;
	}
	public function getNextNews($currentId, $direction = 0) {
		$map = [];
		if ($direction < 0) {
			$map['id'] = ['lt', $currentId];
			$order = 'id desc';
		} else if ($direction > 0) {
			$map['id'] = ['gt', $currentId];
			$order = 'id asc';
		} else {
			$map['id'] = $currentId;
			$order = 'id';
		}
		$data = M ('cms_news')->where ($map)
			->order ($order)
			->limit (1)
			->find ();
		
		if ($data) {
			$data['cover'] = getpics ($data['cover']);
			$data['news_date'] = date ('Y-m-d', $data['news_date']);
		}
		return $data;
	}
}
