<?php

/**
 * This file is part of the Pdfdf library.
 *
 * (c) Austin White <austingym@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Austinw\Pdfdf;

use Illuminate\Support\Facades\Facade;

/**
 * Facade for Pdfdf
 *
 * @author Austin White <austingym@gmail.com>
 */
class PdfdfFacade extends Facade
{
    /**
    * Get the registered name of the component.
    *
    * @return string
    */
    protected static function getFacadeAccessor()
    {
        return 'pdfdf';
    }
}