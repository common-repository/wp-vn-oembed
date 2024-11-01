<?php
/**
 * This class is the base for all rulers
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


abstract class Base {
	protected $regex;
	protected $id;
	protected $usecache = false;

	public function __construct($regex = ''){
		$this->id = static::class;
		$this->regex = apply_filters('vno_regex_'.$this->id, $regex);
	}

	/**
	 * oEmbed handler callback
	 *
	 * @param $matches
	 * @param $attr
	 * @param $url
	 * @param $rawattr
	 *
	 * @return bool|mixed|void
	 */
	public function callback($matches, $attr, $url, $rawattr){
		$post = get_post();
		$post_ID = ( ! empty( $post->ID ) ) ? $post->ID : null;
		if ( ! empty( $this->post_ID ) ) // Potentially set by WP_Embed::cache_oembed()
			$post_ID = $this->post_ID;

		// Unknown URL format. Let oEmbed have a go.
		if ( $post_ID ) {

			// Check for a cached result (stored in the post meta)
			$key_suffix = md5( $url . serialize( $attr ) );
			$cachekey = '_oembed_' . $key_suffix;
			$cachekey_time = '_oembed_time_' . $key_suffix;

			/**
			 * Filter the oEmbed TTL value (time to live).
			 *
			 * @since 4.0.0
			 *
			 * @param int    $time    Time to live (in seconds).
			 * @param string $url     The attempted embed URL.
			 * @param array  $attr    An array of shortcode attributes.
			 * @param int    $post_ID Post ID.
			 */
			$ttl = apply_filters( 'oembed_ttl', DAY_IN_SECONDS, $url, $attr, $post_ID );

			$cache = get_post_meta( $post_ID, $cachekey, true );
			$cache_time = get_post_meta( $post_ID, $cachekey_time, true );

			if ( ! $cache_time ) {
				$cache_time = 0;
			}

			$cached_recently = ( time() - $cache_time ) < $ttl;

			if ( $this->usecache || $cached_recently ) {
				// Failures are cached. Serve one if we're using the cache.
				if ( '{{unknown}}' === $cache )
					return false;

				if ( ! empty( $cache ) ) {
					/**
					 * Filter the cached oEmbed HTML.
					 *
					 * @since 2.9.0
					 *
					 * @see WP_Embed::shortcode()
					 *
					 * @param mixed  $cache   The cached HTML result, stored in post meta.
					 * @param string $url     The attempted embed URL.
					 * @param array  $attr    An array of shortcode attributes.
					 * @param int    $post_ID Post ID.
					 */
					return apply_filters( 'vn_oembed_html', $cache, $url, $attr, $post_ID );
				}
			}

			$html = $this->generateEmbedCode($matches, $attr, $url, $rawattr);
			$html = apply_filters('vno_embedcode_'.$this->id, $html);

			// Maybe cache the result
			if ( $html ) {
				update_post_meta( $post_ID, $cachekey, $html );
				update_post_meta( $post_ID, $cachekey_time, time() );
			} elseif ( ! $cache ) {
				update_post_meta( $post_ID, $cachekey, '{{unknown}}' );
			}

			// If there was a result, return it
			if ( $html ) {
				/** This filter is documented in wp-includes/class-wp-embed.php */
				return apply_filters( 'vn_oembed_html', $html, $url, $attr, $post_ID );
			}
		}
		return false;
	}
	public function getRegex(){
		return $this->regex;
	}
	abstract public function generateEmbedCode($matches, $attr, $url, $rawattr);
}
