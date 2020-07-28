<?php

namespace App\Libraries\tgMdk\Lib;

/**
 * Licensed to the Apache Software Foundation (ASF) under one or more
 * contributor license agreements. See the NOTICE file distributed with
 * this work for additional information regarding copyright ownership.
 * The ASF licenses this file to You under the Apache License, Version 2.0
 * (the "License"); you may not use this file except in compliance with
 * the License. You may obtain a copy of the License at
 * 
 *		http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * 
 * @package log4php
 */

if (function_exists('__autoload')) {
	trigger_error("log4php: It looks like your code is using an __autoload() function. log4php uses spl_autoload_register() which will bypass your __autoload() function and may break autoloading.", E_USER_WARNING);
}

spl_autoload_register(array('App\Libraries\tgMdk\Lib\LoggerAutoloader', 'autoload'));

/**
 * Class autoloader.
 * 
 * @package log4php
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version $Revision: 1394956 $
 */
class LoggerAutoloader {
	
	/** Maps classnames to files containing the class. */
	private static $classes = array(
	
		// Base
		'LoggerAppender' => '/LoggerAppender.php',
		'LoggerAppenderPool' => '/LoggerAppenderPool.php',
		'LoggerConfigurable' => '/LoggerConfigurable.php',
		'LoggerConfigurator' => '/LoggerConfigurator.php',
		'LoggerException' => '/LoggerException.php',
		'LoggerFilter' => '/LoggerFilter.php',
		// 'LoggerHierarchy' => '/LoggerHierarchy.php',
		'LoggerLevel' => '/LoggerLevel.php',
		'LoggerLocationInfo' => '/LoggerLocationInfo.php',
		'LoggerLoggingEvent' => '/LoggerLoggingEvent.php',
		'LoggerMDC' => '/LoggerMDC.php',
		'LoggerNDC' => '/LoggerNDC.php',
		'LoggerLayout' => '/LoggerLayout.php',
		'LoggerReflectionUtils' => '/LoggerReflectionUtils.php',
		'LoggerRoot' => '/LoggerRoot.php',
		'LoggerThrowableInformation' => '/LoggerThrowableInformation.php',
		
		// Appenders
		'LoggerAppenderConsole' => '/LoggerAppenderConsole.php',
		'LoggerAppenderDailyFile' => '/LoggerAppenderDailyFile.php',
		'LoggerAppenderEcho' => '/LoggerAppenderEcho.php',
		'LoggerAppenderFile' => '/LoggerAppenderFile.php',
		'LoggerAppenderMail' => '/LoggerAppenderMail.php',
		'LoggerAppenderMailEvent' => '/LoggerAppenderMailEvent.php',
		'LoggerAppenderMongoDB' => '/LoggerAppenderMongoDB.php',
		'LoggerAppenderNull' => '/LoggerAppenderNull.php',
		'LoggerAppenderFirePHP' => '/LoggerAppenderFirePHP.php',
		'LoggerAppenderPDO' => '/LoggerAppenderPDO.php',
		'LoggerAppenderPhp' => '/LoggerAppenderPhp.php',
		'LoggerAppenderRollingFile' => '/LoggerAppenderRollingFile.php',
		'LoggerAppenderSocket' => '/LoggerAppenderSocket.php',
		'LoggerAppenderSyslog' => '/LoggerAppenderSyslog.php',
		
		// Configurators
		'LoggerConfigurationAdapter' => '/LoggerConfigurationAdapter.php',
		'LoggerConfigurationAdapterINI' => '/LoggerConfigurationAdapterINI.php',
		'LoggerConfigurationAdapterPHP' => '/LoggerConfigurationAdapterPHP.php',
		'LoggerConfigurationAdapterXML' => '/LoggerConfigurationAdapterXML.php',
		'LoggerConfiguratorDefault' => '/LoggerConfiguratorDefault.php',

		// Filters
		'LoggerFilterDenyAll' => '/LoggerFilterDenyAll.php',
		'LoggerFilterLevelMatch' => '/LoggerFilterLevelMatch.php',
		'LoggerFilterLevelRange' => '/LoggerFilterLevelRange.php',
		'LoggerFilterStringMatch' => '/LoggerFilterStringMatch.php',

		// Helpers
		'LoggerFormattingInfo' => '/LoggerFormattingInfo.php',
		'LoggerOptionConverter' => '/LoggerOptionConverter.php',
		'LoggerPatternParser' => '/LoggerPatternParser.php',
		'LoggerUtils' => '/LoggerUtils.php',
	
		// Pattern converters
		'LoggerPatternConverter' => '/LoggerPatternConverter.php',
		'LoggerPatternConverterClass' => '/LoggerPatternConverterClass.php',
		'LoggerPatternConverterCookie' => '/LoggerPatternConverterCookie.php',
		'LoggerPatternConverterDate' => '/LoggerPatternConverterDate.php',
		'LoggerPatternConverterEnvironment' => '/LoggerPatternConverterEnvironment.php',
		'LoggerPatternConverterFile' => '/LoggerPatternConverterFile.php',
		'LoggerPatternConverterLevel' => '/LoggerPatternConverterLevel.php',
		'LoggerPatternConverterLine' => '/LoggerPatternConverterLine.php',
		'LoggerPatternConverterLiteral' => '/LoggerPatternConverterLiteral.php',
		'LoggerPatternConverterLocation' => '/LoggerPatternConverterLocation.php',
		'LoggerPatternConverterLogger' => '/LoggerPatternConverterLogger.php',
		'LoggerPatternConverterMDC' => '/LoggerPatternConverterMDC.php',
		'LoggerPatternConverterMessage' => '/LoggerPatternConverterMessage.php',
		'LoggerPatternConverterMethod' => '/LoggerPatternConverterMethod.php',
		'LoggerPatternConverterNDC' => '/LoggerPatternConverterNDC.php',
		'LoggerPatternConverterNewLine' => '/LoggerPatternConverterNewLine.php',
		'LoggerPatternConverterProcess' => '/LoggerPatternConverterProcess.php',
		'LoggerPatternConverterRelative' => '/LoggerPatternConverterRelative.php',
		'LoggerPatternConverterRequest' => '/LoggerPatternConverterRequest.php',
		'LoggerPatternConverterServer' => '/LoggerPatternConverterServer.php',
		'LoggerPatternConverterSession' => '/LoggerPatternConverterSession.php',
		'LoggerPatternConverterSessionID' => '/LoggerPatternConverterSessionID.php',
		'LoggerPatternConverterSuperglobal' => '/LoggerPatternConverterSuperglobal.php',
		'LoggerPatternConverterThrowable' => '/LoggerPatternConverterThrowable.php',
		
		// Layouts
		'LoggerLayoutHtml' => '/LoggerLayoutHtml.php',
		'LoggerLayoutPattern' => '/LoggerLayoutPattern.php',
		'LoggerLayoutSerialized' => '/LoggerLayoutSerialized.php',
		'LoggerLayoutSimple' => '/LoggerLayoutSimple.php',
		'LoggerLayoutTTCC' => '/LoggerLayoutTTCC.php',
		'LoggerLayoutXml' => '/LoggerLayoutXml.php',
		
		// Renderers
		'LoggerRendererDefault' => '/LoggerRendererDefault.php',
		'LoggerRendererException' => '/LoggerRendererException.php',
		'LoggerRendererMap' => '/LoggerRendererMap.php',
		'LoggerRenderer' => '/LoggerRenderer.php',
	);
	
	/**
	 * Loads a class.
	 * @param string $className The name of the class to load.
	 */
	public static function autoload($className) {
		if(isset(self::$classes[$className])) {
			include dirname(__FILE__) . self::$classes[$className];
		}
	}
}
