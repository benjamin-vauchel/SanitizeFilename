<?php
/**
 * SanitizeFilename sanitizefilename plugin
 *
 * Copyright 2011 Benjamin Vauchel <contact@omycode.fr>
 *
 * @author Benjamin Vauchel <contact@omycode.fr>
 * @version Version 1.0.0-beta1
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
 * MODx SanitizeFilename sanitizefilename plugin
 *
 * Description: Remove quotes, accents … from uploaded filenames and append an unique id.
 * Example : a file with the following name "Exemple d'un nom de fichier accentué.jpg" will be "exemple-d-un-nom-de-fichier-accentue-4ed0e2f3a0d33.jpg"
 *
 * Events: OnFileManagerUpload
 *
 * @package sanitizefilename
 *
 */

// Clean function
// code derived from http://php.vrana.cz/vytvoreni-pratelskeho-url.php
function slugify($text)
{
  // replace non letter or digits by -
  $text = preg_replace('#[^\\pL\d]+#u', '-', $text);
 
  // trim
  $text = trim($text, '-');
 
  // transliterate
  if (function_exists('iconv'))
  {
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
  }
 
  // lowercase
  $text = strtolower($text);
 
  // remove unwanted characters
  $text = preg_replace('#[^-\w]+#', '', $text);
 
  if (empty($text))
  {
    return 'n-a';
  }
 
  return $text;
}

// We call the file handler service of MODx
$modx->getService('fileHandler','modFileHandler');

// We rename each of uploaded files
foreach($files as $file)
{
  if($file['error'] == 0)
  {
    $mod_file = $modx->fileHandler->make($directory->getPath().'/'.$file['name']);
    if (is_object($mod_file) && ($mod_file instanceof modFile))
    {
      $path_info = pathinfo($file['name']);
      $newPath = $directory->getPath().'/'.slugify($path_info['filename']).'-'.uniqid().'.'.$path_info['extension'];
      $mod_file->rename($newPath);
    }
  }
}