<?php
declare(strict_types=1);

namespace Kocal\BiomeJsBundle\Tests\fixtures;

use Kocal\BiomeJsBundle\KocalBiomeJsBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;

final class BiomeJsTestKernel extends Kernel
{
    use MicroKernelTrait;

    public function __construct()
    {
        parent::__construct('test', true);
    }

    public function registerBundles(): array
    {
        return [
            new FrameworkBundle(),
            new KocalBiomeJsBundle(),
        ];
    }
    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader): void
    {
        $container->setParameter('biomejs.use_tty', false);

        $container->loadFromExtension('framework', [
            'secret' => 'foo',
            'test' => true,
            'http_method_override' => true,
            'handle_all_throwables' => true,
            'php_errors' => [
                'log' => true,
            ],
        ]);
    }

    public function getCacheDir(): string
    {
        return sys_get_temp_dir().'/cache'.spl_object_hash($this);
    }

    public function getLogDir(): string
    {
        return sys_get_temp_dir().'/logs'.spl_object_hash($this);
    }

    public function getProjectDir(): string
    {
        return __DIR__;
    }
}