<?php

/**
 * This file is part of the Pdfdf library.
 *
 * (c) Austin White <austingym@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return array(
    'pdftk' => '/usr/local/bin/pdftk',

    'storage' => array(
    	'tmp' => storage_path() . DIRECTORY_SEPARATOR . 'tmp',
    	'pdf' => storage_path() . DIRECTORY_SEPARATOR . 'pdf'
    ),
    
    // Erase the temporary fdf files generated after they've been used. Turn off for debugging
    'erase_temp_fdf' => false,
);