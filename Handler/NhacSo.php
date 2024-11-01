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


class NhacSo extends Base{
	public function __construct(){
		parent::__construct('#https?:\/\/(www\.)?nhacso\.net\/(nghe-album|nghe-playlist|nghe-nhac|xem-video)\/([a-zA-Z,\-,\d]+)\.([a-zA-Z,\d,=?]*)\.html#i');
	}
	public function generateEmbedCode($matches, $attr, $url, $rawattr){
		$embed = $url;
		$pattern = '';
		switch ($matches[2]) {
			case 'nghe-playlist':
				$pattern = '<iframe src=\'http://nhacso.net/embed/playlist/%1$s\' width=\'100%\' height=\'195\' frameborder=\'0\'></iframe>';
				break;
			case 'nghe-nhac':
				$pattern = '<iframe src=\'http://nhacso.net/embed/song/%1$s\' width=\'100%\' height=\'110\' frameborder=\'0\'></iframe>';
				break;
			case 'xem-video':
				$pattern = '<iframe src=\'http://nhacso.net/embed/video/%1$s\' width=\'570\' height=\'290\' frameborder=\'0\' allowfullscreen></iframe>';
				break;
			case 'nghe-album':
				$pattern = '<iframe src=\'http://nhacso.net/embed/album/%1$s\' width=\'100%\' height=\'195\' frameborder=\'0\'></iframe>';
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
