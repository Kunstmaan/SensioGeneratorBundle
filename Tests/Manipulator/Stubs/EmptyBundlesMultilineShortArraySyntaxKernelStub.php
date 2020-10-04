<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KernelManipulatorTest\Stubs;

use Manipulator\Stubs\KernelForTest;

class EmptyBundlesMultilineShortArraySyntaxKernelStub extends KernelForTest
{
    public function registerBundles(): iterable
    {
        $bundles = [

        ];

        return $bundles;
    }
}
