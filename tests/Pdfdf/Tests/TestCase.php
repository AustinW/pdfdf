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
class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders()
    {
        return array(
            'Austinw\Pdfdf\PdfdfServiceProvider',
        );
    }
    protected function getPackageAliases()
    {
        return array(
            'Pdfdf' => 'Austinw\Pdfdf\PdfdfFacade',
        );
    }
}