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
require_once VNO_DIR.'/lib/Psr4ClassLoader.php';
use Symfony\Component\ClassLoader\Psr4ClassLoader;

$loader = new Psr4ClassLoader();
$loader->addPrefix('VN_OEmbed', VNO_DIR);
$loader->register();