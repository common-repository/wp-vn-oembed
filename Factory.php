<?php
namespace VN_OEmbed;
class Factory
{
    protected $rulers;

    public function __construct()
    {
	    $rulers = array(
		    '\VN_OEmbed\Handler\NCT',
		    '\VN_OEmbed\Handler\NhacSo',
		    '\VN_OEmbed\Handler\Zing',
		    '\VN_OEmbed\Handler\TVZing'
	    );
	    $rulers = apply_filters('vno_hander_class_names', $rulers);
		foreach($rulers as $ruler){
			if(is_string($ruler)){
				//If it is string
				$this->rulers[$ruler] = new $ruler();
			}
			else{
				//If it is instance
				$this->rulers[get_class($ruler)] = $ruler;
			}
		}
	    $this->register();
    }

	/**
	 * Get the ruler instance.
	 *
	 * @since  0.9.0
	 *
	 * @param $className
	 * @return mixed|void|\WP_Error
	 * @author nguyenvanduocit
	 */
	public function get($className){

		if(array_key_exists($className, $this->rulers))
		{
			/**
			 * If this array is exist, just return it
			 */
			$object = apply_filters('vno_get_handler_instance', $this->rulers[$className], $className);
		}
		else{
			/**
			 * If not, try to get via filter
			 */
			$object = apply_filters('vno_get_handler_instance', $className);
		}

		if(!is_object($object)){
			/**
			 * If result is not object, that mean error. So return error
			 */
			return new \WP_Error('vno_class_not_exists', 'Class not exists');
		}
		else{
			/**
			 * If is object, woo, return it
			 */
			return $object;
		}
	}

	/**
	 * Add the ruler to list.
	 *
	 * @since  0.9.0
	 *
	 * @param $classInstance
	 *
	 * @return void
	 * @author nguyenvanduocit
	 */
	public function add($classInstance){
		$className = get_class($classInstance);
		$is_need_register = false;
		if(array_key_exists($className, $this->rulers)){
			$is_need_register = true;
		}
		$this->rulers[$className] = $classInstance;
		if($is_need_register)
		{
			wp_embed_register_handler($className, $this->rulers[$className]->getRegex(), array($this->rulers[$className], 'callback'));
		}
	}
	/**
	 * Summary.
	 *
	 * @since  0.9.0
	 * @see
	 * @return void
	 * @author nguyenvanduocit
	 */
	public function register()
    {
        foreach ($this->rulers as $key => $ruler) {
	        /** @var \VN_OEmbed\Handler\Base $ruler */
	        wp_embed_register_handler($key, $ruler->getRegex(), array($ruler, 'callback'));
        }
    }
}
