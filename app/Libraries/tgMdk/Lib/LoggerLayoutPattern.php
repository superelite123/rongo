<?php

Namespace App\Libraries\tgMdk\Lib;

/**
 * Licensed to the Apache Software Foundation (ASF) under one or more
 * contributor license agreements.  See the NOTICE file distributed with
 * this work for additional information regarding copyright ownership.
 * The ASF licenses this file to You under the Apache License, Version 2.0
 * (the "License"); you may not use this file except in compliance with
 * the License.  You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @package log4php
 */

/**
 * A flexible layout configurable with a pattern string.
 * 
 * Configurable parameters:
 * 
 * * converionPattern - A string which controls the formatting of logging 
 *   events. See docs for full specification.
 * 
 * @package log4php
 * @subpackage layouts
 * @version $Revision: 1395470 $
 */
class LoggerLayoutPattern extends LoggerLayout {
	
	/** Default conversion pattern */
	const DEFAULT_CONVERSION_PATTERN = '%date %-5level %logger %message%newline';

	/** Default conversion TTCC Pattern */
	const TTCC_CONVERSION_PATTERN = '%d [%t] %p %c %x - %m%n';

	/** The conversion pattern. */ 
	protected $pattern = self::DEFAULT_CONVERSION_PATTERN;
	
	/** Maps conversion keywords to the relevant converter (default implementation). */
	protected static $defaultConverterMap = array(
		'c' => 'App\Libraries\tgMdk\Lib\LoggerPatternConverterLogger',
		'lo' => 'App\Libraries\tgMdk\Lib\LoggerPatternConverterLogger',
		'logger' => 'App\Libraries\tgMdk\Lib\LoggerPatternConverterLogger',
		
		'C' => 'App\Libraries\tgMdk\Lib\LoggerPatternConverterClass',
		'class' => 'App\Libraries\tgMdk\Lib\LoggerPatternConverterClass',
		
		'cookie' => 'App\Libraries\tgMdk\Lib\LoggerPatternConverterCookie',
		
		'd' => 'App\Libraries\tgMdk\Lib\LoggerPatternConverterDate',
		'date' => 'App\Libraries\tgMdk\Lib\LoggerPatternConverterDate',
		
		'e' => 'App\Libraries\tgMdk\Lib\LoggerPatternConverterEnvironment',
		'env' => 'App\Libraries\tgMdk\Lib\LoggerPatternConverterEnvironment',
		
		'ex' => 'App\Libraries\tgMdk\Lib\LoggerPatternConverterThrowable',
		'exception' => 'App\Libraries\tgMdk\Lib\LoggerPatternConverterThrowable',
		'throwable' => 'App\Libraries\tgMdk\Lib\LoggerPatternConverterThrowable',
		
		'F' => 'App\Libraries\tgMdk\Lib\LoggerPatternConverterFile',
		'file' => 'App\Libraries\tgMdk\Lib\LoggerPatternConverterFile',
			
		'l' => 'App\Libraries\tgMdk\Lib\LoggerPatternConverterLocation',
		'location' => 'App\Libraries\tgMdk\Lib\LoggerPatternConverterLocation',
		
		'L' => 'App\Libraries\tgMdk\Lib\LoggerPatternConverterLine',
		'line' => 'App\Libraries\tgMdk\Lib\LoggerPatternConverterLine',
		
		'm' => 'App\Libraries\tgMdk\Lib\LoggerPatternConverterMessage',
		'msg' => 'App\Libraries\tgMdk\Lib\LoggerPatternConverterMessage',
		'message' => 'App\Libraries\tgMdk\Lib\LoggerPatternConverterMessage',
		
		'M' => 'App\Libraries\tgMdk\Lib\LoggerPatternConverterMethod',
		'method' => 'App\Libraries\tgMdk\Lib\LoggerPatternConverterMethod',
		
		'n' => 'App\Libraries\tgMdk\Lib\LoggerPatternConverterNewLine',
		'newline' => 'App\Libraries\tgMdk\Lib\LoggerPatternConverterNewLine',
		
		'p' => 'App\Libraries\tgMdk\Lib\LoggerPatternConverterLevel',
		'le' => 'App\Libraries\tgMdk\Lib\LoggerPatternConverterLevel',
		'level' => 'App\Libraries\tgMdk\Lib\LoggerPatternConverterLevel',
	
		'r' => 'App\Libraries\tgMdk\Lib\LoggerPatternConverterRelative',
		'relative' => 'App\Libraries\tgMdk\Lib\LoggerPatternConverterRelative',
		
		'req' => 'App\Libraries\tgMdk\Lib\LoggerPatternConverterRequest',
		'request' => 'App\Libraries\tgMdk\Lib\LoggerPatternConverterRequest',
		
		's' => 'App\Libraries\tgMdk\Lib\LoggerPatternConverterServer',
		'server' => 'App\Libraries\tgMdk\Lib\LoggerPatternConverterServer',
		
		'ses' => 'App\Libraries\tgMdk\Lib\LoggerPatternConverterSession',
		'session' => 'App\Libraries\tgMdk\Lib\LoggerPatternConverterSession',
		
		'sid' => 'App\Libraries\tgMdk\Lib\LoggerPatternConverterSessionID',
		'sessionid' => 'App\Libraries\tgMdk\Lib\LoggerPatternConverterSessionID',
	
		't' => 'App\Libraries\tgMdk\Lib\LoggerPatternConverterProcess',
		'pid' => 'App\Libraries\tgMdk\Lib\LoggerPatternConverterProcess',
		'process' => 'App\Libraries\tgMdk\Lib\LoggerPatternConverterProcess',
		
		'x' => 'App\Libraries\tgMdk\Lib\LoggerPatternConverterNDC',
		'ndc' => 'App\Libraries\tgMdk\Lib\LoggerPatternConverterNDC',
			
		'X' => 'App\Libraries\tgMdk\Lib\LoggerPatternConverterMDC',
		'mdc' => 'App\Libraries\tgMdk\Lib\LoggerPatternConverterMDC',
	);

	/** Maps conversion keywords to the relevant converter. */
	protected $converterMap = array();
	
	/** 
	 * Head of a chain of Converters.
	 * @var LoggerPatternConverter 
	 */
	private $head;

	/** Returns the default converter map. */
	public static function getDefaultConverterMap() {
		return self::$defaultConverterMap;
	}
	
	/** Constructor. Initializes the converter map. */
	public function __construct() {
		$this->converterMap = self::$defaultConverterMap;
	}
	
	/**
	 * Sets the conversionPattern option. This is the string which
	 * controls formatting and consists of a mix of literal content and
	 * conversion specifiers.
	 * @param array $conversionPattern
	 */
	public function setConversionPattern($conversionPattern) {
		$this->pattern = $conversionPattern;
	}
	
	/**
	 * Processes the conversion pattern and creates a corresponding chain of 
	 * pattern converters which will be used to format logging events. 
	 */
	public function activateOptions() {
		if (!isset($this->pattern)) {
			throw new LoggerException("Mandatory parameter 'conversionPattern' is not set.");
		}
		
		$parser = new LoggerPatternParser($this->pattern, $this->converterMap);
		$this->head = $parser->parse();
	}
	
	/**
	 * Produces a formatted string as specified by the conversion pattern.
	 *
	 * @param LoggerLoggingEvent $event
	 * @return string
	 */
	public function format(LoggerLoggingEvent $event) {
		$sbuf = '';
		$converter = $this->head;
		while ($converter !== null) {
			$converter->format($sbuf, $event);
			$converter = $converter->next;
		}
		return $sbuf;
	}
}