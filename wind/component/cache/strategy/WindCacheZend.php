<?php
/**
 * the last known user to change this file in the repository  <$LastChangedBy$>
 * @author Su Qian <weihu@alibaba-inc.com>
 * @version $Id$ 
 * @package 
 * tags
 */
L::import('WIND:component.cache.AbstractWindCache');
L::import('WIND:component.cache.operator.WindUZendCache');
/**
 * the last known user to change this file in the repository  <$LastChangedBy$>
 * @author Su Qian <weihu@alibaba-inc.com>
 * @version $Id$ 
 * @package 
 */
class WindCacheZend extends AbstractWindCache {

	/**
	 * @var WindZendCache
	 */
	protected $zendCache = null;

	public function __construct() {
		$this->zendCache = new WindZendCache();
	}

	/* (non-PHPdoc)
	 * @see AbstractWindCache::set()
	 */
	public function set($key, $value, $expire = null, IWindCacheDependency $denpendency = null) {
		$expire = null === $expire  ? $this->getExpire() : $expire;
		return $this->zendCache->set($this->buildSecurityKey($key), $this->storeData($value, $expire, $denpendency), $expire);
	}

	/* (non-PHPdoc)
	 * @see AbstractWindCache::get()
	 */
	public function get($key) {
		return $this->getDataFromMeta($key, unserialize($this->zendCache->get($this->buildSecurityKey($key))));
	}

	/* (non-PHPdoc)
	 * @see AbstractWindCache::delete()
	 */
	public function delete($key) {
		return $this->zendCache->delete($this->buildSecurityKey($key));
	}

	/**
	 * @see AbstractWindCache::clear()
	 * @return boolean
	 */
	public function clear() {
		return $this->zendCache->flush();
	}
	
}