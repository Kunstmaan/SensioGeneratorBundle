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
use Sensio\Bundle\GeneratorBundle\Tests\Manipulator\Stubs\StubBundle;

class ContainsBundlesKernelStub extends KernelForTest
{
    public function registerBundles(): iterable
    {
        $bundles = array(
            new StubBundle(),
            new StubBundle(),
            new StubBundle(),
        );

        return $bundles;
    }
}
