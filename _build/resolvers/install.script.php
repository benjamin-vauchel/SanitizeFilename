<?php

/**
 * SanitizeFilename resolver script - runs on install.
 *
 * Copyright 2011 Benjamin Vauchel <contact@omycode.fr>
 * @author Benjamin Vauchel <contact@omycode.fr>
 * 12/15/11
 *
 * SanitizeFilename is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation; either version 2 of the License, or (at your option) any
 * later version.
 *
 * SanitizeFilename is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * SanitizeFilename; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package sanitizefilename
 */
/**
 * Description: Resolver script for SanitizeFilename package
 * @package sanitizefilename
 * @subpackage build
 */

/* Example Resolver script */

/* The $modx object is not available here. In its place we
 * use $object->xpdo
 */

$modx =& $object->xpdo;

/* Remember that the files in the _build directory are not available
 * here and we don't know the IDs of any objects, so resources,
 * elements, and other objects must be retrieved by name with
 * $modx->getObject().
 */

/* Connecting plugins to the appropriate system events and
 * connecting TVs to their templates is done here.
 *
 * Be sure to set the name of the category in $category.
 *
 * You will have to hand-code the names of the elements and events
 * in the arrays below.
 */

$pluginEvents = array('OnFileManagerUpload');
$plugins = array('SanitizeFilename');
$category = 'SanitizeFilename';



$success = true;

$modx->log(xPDO::LOG_LEVEL_INFO,'Running PHP Resolver.');
switch($options[xPDOTransport::PACKAGE_ACTION]) {
    /* This code will execute during an install */
    case xPDOTransport::ACTION_INSTALL:
        /* Assign plugins to System events */
        foreach($plugins as $k => $plugin) {
            $pluginObj = $modx->getObject('modPlugin',array('name'=>$plugin));
            if (! $pluginObj) $modx->log(xPDO::LOG_LEVEL_INFO,'cannot get object: ' . $plugin);
            if (empty($pluginEvents)) $modx->log(xPDO::LOG_LEVEL_INFO,'Cannot get System Events');
            if (!empty ($pluginEvents) && $pluginObj) {

                $modx->log(xPDO::LOG_LEVEL_INFO,'Assigning Events to Plugin ' . $plugin);

                foreach($pluginEvents as $k => $event) {
                    $intersect = $modx->newObject('modPluginEvent');
                    $intersect->set('event',$event);
                    $intersect->set('pluginid',$pluginObj->get('id'));
                    $intersect->save();
                }
            }
        }

    /* This code will execute during an upgrade */
    case xPDOTransport::ACTION_UPGRADE:

        /* put any upgrade tasks (if any) here such as removing
           obsolete files, settings, elements, resources, etc.
        */

        $success = true;
        break;

    /* This code will execute during an uninstall */
    case xPDOTransport::ACTION_UNINSTALL:
        $modx->log(xPDO::LOG_LEVEL_INFO,'Uninstalling . . .');
        $success = true;
        break;

}
$modx->log(xPDO::LOG_LEVEL_INFO,'Script resolver actions completed');
return $success;