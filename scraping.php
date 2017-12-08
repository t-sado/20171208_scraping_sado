<?php
	$target_str = '沖縄 高級ホテル';
	$url = 'https://www.google.co.jp/search?q='.urlencode($target_str);
	mb_language('Japanese');

	$data = mb_convert_encoding(file_get_contents($url), "utf8", "auto");
	$data = str_replace(array("\r\n","\r","\n"), '', $data);	
	$data = explode('<h3 class="r">', $data);

	// 検索結果のタイトルとURLを１０件分取得する
	foreach ($data as $key => $value) {
		// 広告部分はスキップ
		if (!$key) {
			continue;
		}
		$site_info = str_replace(array('<b>', '</b>'), '', $value);
		preg_match("/<a href=\"(.+?)\">(.+?)<\/a>/", $site_info, $match);
		$title = "<<< {$match[2]} >>>";
		$site_url = between('/url?q=', '&amp;', $match[1]);
		echo "{$title}\n{$site_url}\n\n";
	}

	// 特定文字の間にある文字列を取得する
	function between($beg, $end, $str) {

	  $result = '';
	  $arr_url = explode($beg,$str);
	  if ($arr_url) {
	  	$pos = strpos($arr_url[1],$end);
	    if( false !== $pos ) {
	      $result = substr($arr_url[1],0,$pos);
	    }
	  }
	  return $result;
	}
?>