<?php

namespace App\Tests;

use App\Entity\Category;
use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Service\Page\Navigation;
use PHPUnit\Framework\TestCase;

class NavigationTest extends TestCase
{
    public function testGetMenu()
    {
        $repo = $this->createMock(CategoryRepository::class);
        $repo->expects($this->any())
            ->method('findBy')
            ->willReturn([
                new Category()
            ]);
        $navigation = new Navigation($repo);

        $this->assertTrue(is_array($navigation->getMenu()));
        foreach ($navigation->getMenu() as $entity) {
            $this->assertInstanceOf(Product::class, $entity);
        }
    }
}
