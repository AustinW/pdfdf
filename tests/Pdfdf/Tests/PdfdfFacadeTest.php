<?php

/**
 * This file is part of the Pdfdf library.
 *
 * (c) Austin White <austingym@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pdfdf\Tests;

/**
 * @author Austin White <austingym@gmail.com>
 */
class PdfdfFacadeTest extends TestCase
{
    public function testPdfdfFacade()
    {
    	$this->assertInstanceOf('Wesnick\\FdfUtility\\PdfForm', \Pdfdf::getUtility());
    }
}