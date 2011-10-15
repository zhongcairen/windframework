<?php
/**
 * 通用工具库
 *
 * @author Qiong Wu <papa0924@gmail.com>
 * @copyright ©2003-2103 phpwind.com
 * @license http://www.windframework.com
 * @version $Id$
 * @package utility
 */
class WindUtility {

	/**
	 * 解析表达式
	 * 
	 * 表达式格式: namespace:arg1.arg2.arg3.arg4.arg5==value
	 * 返回: array($namespace, $param1, $operator, $param1)
	 * 
	 * @param string $expression 待解析的表达式
	 * @return array 返回解析后的表达式,由表达式的各项组成的数组:
	 * <ul>
	 * <li>第一个元素: 命名空间</li>
	 * <li>第二个元素: 表达式的左边操作数</li>
	 * <li>第三个元素: 表达式的操作符</li>
	 * <li>第四个元素： 表达式的右边操作数</li>
	 * </ul>
	 */
	public static function resolveExpression($expression) {
		$operators = array('==', '!=', '<', '>', '<=', '>=');
		$operatorsReplace = array('#==#', '#!=#', '#<#', '#>#', '#<=#', '#>=#');
		list($p, $o, $v2) = explode('#', str_replace($operators, $operatorsReplace, $expression));
		if (strpos($p, ":") !== false)
			list($_namespace, $p) = explode(':', trim($p, ':'));
		else
			$_namespace = '';
		return array($_namespace, $p, $o, $v2);
	}

	/**
	 * 执行简单的条件表达式
	 * 
	 * 只能执行==、！=、<、>、<=、>=简单的比较
	 * 
	 * @param string $v1 左边的操作数
	 * @param string $v2 右边的操作数
	 * @param string $operator 操作符号
	 * @return boolean 
	 */
	public static function evalExpression($v1, $v2, $operator) {
		switch ($operator) {
			case '==':
				return $v1 == $v2;
			case '!=':
				return $v1 != $v2;
			case '<':
				return $v1 < $v2;
			case '>':
				return $v1 > $v2;
			case '<=':
				return $v1 <= $v2;
			case '>=':
				return $v1 >= $v2;
			default:
				return false;
		}
		return false;
	}

	/**
	 * 递归合并两个数组
	 * 
	 * @param array $array1 数组1
	 * @param array $array2  数组2
	 * @return array 合并后的数组
	 */
	public static function mergeArray($array1, $array2) {
		foreach ($array2 as $key => $value) {
			if (!isset($array1[$key]) || !is_array($array1[$key])) {
				$array1[$key] = $value;
				continue;
			}
			$array1[$key] = self::mergeArray($array1[$key], $array2[$key]);
		}
		return $array1;
	}

	/**
	 * 将字符串首字母小写
	 * 
	 * @param string $str 待处理的字符串 
	 * @return string 返回处理后的字符串
	 */
	public static function lcfirst($str) {
		if (function_exists('lcfirst')) return lcfirst($str);
		
		$str[0] = strtolower($str[0]);
		return $str;
	}

	/**
	 * 获得随机数字符串
	 * 
	 * @param int $length 随机数的长度
	 * @return string 随机获得的字串
	 */
	public static function generateRandStr($length) {
		$randstr = "";
		for ($i = 0; $i < (int) $length; $i++) {
			$randnum = mt_rand(0, 61);
			if ($randnum < 10) {
				$randstr .= chr($randnum + 48);
			} else if ($randnum < 36) {
				$randstr .= chr($randnum + 55);
			} else {
				$randstr .= chr($randnum + 61);
			}
		}
		return $randstr;
	}

	/**
	 * 通用组装测试验证规则
	 * 
	 * @param string $field	 验证字段名称
	 * @param string $validator  验证方法
	 * @param array $args        验证方法中传递的其他参数,需在待验证字段值的后面,默认为空数组
	 * @param string $default	 验证失败是设置的默认值,默认为null
	 * @param string $message	 验证失败是返回的错误信息,默认为空字串
	 * @return array 返回验证规则
	 * <ul>
	 * <li>field: 验证字段名称</li>
	 * <li>validator: 验证方法</li>
	 * <li>args: 验证方法中传递的其他参数,需在待验证字段值的后面,缺省为空数组</li>
	 * <li>default: 验证失败是设置的默认值,缺省为null</li>
	 * <li>message: 验证失败是返回的错误信息,默认为'提示：XX验证失败'</li>
	 * </ul>
	 */
	public static function buildValidateRule($field, $validator, $args = array(), $default = null, $message = '') {
		return array(
			'field' => $field, 
			'validator' => $validator, 
			'args' => (array) $args, 
			'default' => $default, 
			'message' => ($message ? $message : '提示：\'' . $field . '\'验证失败'));
	}
}