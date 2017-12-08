<?php
	$target_str = '���� �����z�e��';
	$url = 'https://www.google.co.jp/search?q='.urlencode($target_str);
	mb_language('Japanese');

	$data = mb_convert_encoding(file_get_contents($url), "utf8", "auto");
	$data = str_replace(array("\r\n","\r","\n"), '', $data);	
	$data = explode('<h3 class="r">', $data);

	// �������ʂ̃^�C�g����URL���P�O�����擾����
	foreach ($data as $key => $value) {
		// �L�������̓X�L�b�v
		if (!$key) {
			continue;
		}
		$site_info = str_replace(array('<b>', '</b>'), '', $value);
		preg_match("/<a href=\"(.+?)\">(.+?)<\/a>/", $site_info, $match);
		$title = "<<< {$match[2]} >>>";
		$site_url = between('/url?q=', '&amp;', $match[1]);
		echo "{$title}\n{$site_url}\n\n";
	}

	// ���蕶���̊Ԃɂ��镶������擾����
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