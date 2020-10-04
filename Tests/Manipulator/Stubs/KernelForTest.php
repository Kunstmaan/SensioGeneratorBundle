<?php

namespace Manipulator\Stubs;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class KernelForTest extends Kernel
{
    public function registerBundles(): iterable
    {
    }

    public function getBundles(): array
    {
        return [];
    }

    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
    }
}
