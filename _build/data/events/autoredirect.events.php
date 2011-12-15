<?php
/**
 * Array of plugin events for SanitizeFilename package
 *
 * @package sanitizefilename
 * @subpackage build
 */
$events = array();

/* Note: These must not be existing System Events!

 * This example is not used by default in the build.
 * It shows how to add custom System Events
 * for your plugin. See the commented out plugin section
 * of built.transport.php */


$events['OnFileManagerUpload']= $modx->newObject('modPluginEvent');
$events['OnFileManagerUpload']->fromArray(array(
    'event' => 'OnFileManagerUpload',
    'priority' => 0,
    'propertyset' => 0,
),'',true,true);


return $events;