<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sensio\Bundle\GeneratorBundle\Tests\Generator;

use Sensio\Bundle\GeneratorBundle\Generator\DoctrineFormGenerator;

class DoctrineFormGeneratorTest extends GeneratorTest
{
    public function testGenerate()
    {
        $this->generateForm(false);

        $this->assertTrue(file_exists($this->tmpDir.'/Form/PostType.php'));

        $content = file_get_contents($this->tmpDir.'/Form/PostType.php');
        $this->assertStringContainsString('namespace Foo\BarBundle\Form', $content);
        $this->assertStringContainsString('class PostType extends AbstractType', $content);
        $this->assertStringContainsString('->add(\'title\')', $content);
        $this->assertStringContainsString('->add(\'createdAt\')', $content);
        $this->assertStringContainsString('->add(\'publishedAt\')', $content);
        $this->assertStringContainsString('->add(\'updatedAt\')', $content);
        $this->assertStringContainsString('public function configureOptions(OptionsResolver $resolver)', $content);
        $this->assertStringContainsString('\'data_class\' => \'Foo\BarBundle\Entity\Post\'', $content);
    }

    public function testGenerateSubNamespacedEntity()
    {
        $this->generateSubNamespacedEntityForm(false);

        $this->assertTrue(file_exists($this->tmpDir.'/Form/Blog/PostType.php'));

        $content = file_get_contents($this->tmpDir.'/Form/Blog/PostType.php');
        $this->assertStringContainsString('namespace Foo\BarBundle\Form\Blog', $content);
        $this->assertStringContainsString('class PostType extends AbstractType', $content);
        $this->assertStringContainsString('->add(\'title\')', $content);
        $this->assertStringContainsString('->add(\'createdAt\')', $content);
        $this->assertStringContainsString('->add(\'publishedAt\')', $content);
        $this->assertStringContainsString('->add(\'updatedAt\')', $content);
        $this->assertStringContainsString('public function configureOptions(OptionsResolver $resolver)', $content);
        $this->assertStringContainsString('\'data_class\' => \'Foo\BarBundle\Entity\Blog\Post\'', $content);
        $this->assertStringContainsString('public function getBlockPrefix()', $content);
        $this->assertStringContainsString('return \'foo_barbundle_blog_post\';', $content);
        $this->assertStringContainsString('public function getName()', $content);
    }

    public function testNonOverwrittenForm()
    {
        $this->expectExceptionMessageMatches('/Unable to generate the PostType form class as it already exists under the (.+) file/');
        $this->expectException(\RuntimeException::class);

        $this->generateForm(false);
        $this->generateForm(false);
    }

    public function testOverwrittenForm()
    {
        $this->generateForm(false);
        $this->generateForm(true);

        $this->assertTrue(file_exists($this->tmpDir.'/Form/PostType.php'));
    }

    private function generateForm($overwrite)
    {
        $generator = new DoctrineFormGenerator($this->filesystem);
        $generator->setSkeletonDirs(__DIR__.'/../../Resources/skeleton');

        $bundle = $this->getMockBuilder('Symfony\Component\HttpKernel\Bundle\BundleInterface')->getMock();
        $bundle->expects($this->any())->method('getPath')->will($this->returnValue($this->tmpDir));
        $bundle->expects($this->any())->method('getNamespace')->will($this->returnValue('Foo\BarBundle'));

        $metadata = $this->getMockBuilder('Doctrine\ORM\Mapping\ClassMetadataInfo')->disableOriginalConstructor()->getMock();
        $metadata->identifier = array('id');
        $metadata->fieldMappings = array(
            'title' => array('type' => 'string'),
            'createdAt' => array('type' => 'date'),
            'publishedAt' => array('type' => 'time'),
            'updatedAt' => array('type' => 'datetime'),
        );
        $metadata->associationMappings = $metadata->fieldMappings;

        $generator->generate($bundle, 'Post', $metadata, $overwrite);
    }

    private function generateSubNamespacedEntityForm($overwrite)
    {
        $generator = new DoctrineFormGenerator($this->filesystem);
        $generator->setSkeletonDirs(__DIR__.'/../../Resources/skeleton');

        $bundle = $this->getMockBuilder('Symfony\Component\HttpKernel\Bundle\BundleInterface')->getMock();
        $bundle->expects($this->any())->method('getPath')->will($this->returnValue($this->tmpDir));
        $bundle->expects($this->any())->method('getNamespace')->will($this->returnValue('Foo\BarBundle'));

        $metadata = $this->getMockBuilder('Doctrine\ORM\Mapping\ClassMetadataInfo')->disableOriginalConstructor()->getMock();
        $metadata->identifier = array('id');
        $metadata->fieldMappings = array(
            'title' => array('type' => 'string'),
            'createdAt' => array('type' => 'date'),
            'publishedAt' => array('type' => 'time'),
            'updatedAt' => array('type' => 'datetime'),
        );
        $metadata->associationMappings = $metadata->fieldMappings;

        $generator->generate($bundle, 'Blog\Post', $metadata, $overwrite);
    }
}
