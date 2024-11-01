<?php
/**
 * Summary
 *
 * Description.
 *
 * @since 0.9.0
 *
 * @package
 * @subpackage 
 *
 * @author nguyenvanduocit
 */

namespace VN_OEmbed\Handler;


class NCT extends Base{
	public function __construct(){
		parent::__construct('#https?:\/\/(www\.)?nhaccuatui\.com\/(bai-hat|video|playlist)\/([a-zA-Z,\-,\d]+)\.(.*)\.html#i');
	}
	public function generateEmbedCode($matches, $attr, $url, $rawattr){
		$embed = $url;
		$pattern = '';
		switch ($matches[2]) {
			case 'bai-hat':
				$pattern = '<iframe src="http://www.nhaccuatui.com/mh/normal/%1$s" width="316" height="382" frameborder="0" allowfullscreen></iframe>';
				break;
			case 'video':
				$pattern = '<iframe src="http://www.nhaccuatui.com/vh/normal/%1$s" width="620" height="350" frameborder="0" allowfullscreen></iframe>';
				break;
			case 'playlist':
				$pattern = '<iframe src="http://www.nhaccuatui.com/lh/normal/%1$s" width="316" height="587" frameborder="0" allowfullscreen></iframe>';
				break;
		}
		if ($pattern) {
			$embed = sprintf(
				$pattern,
				esc_attr($matches[4])
			);
		}
		return $embed;
	}
}
