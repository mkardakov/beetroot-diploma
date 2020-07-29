<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200727173702 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('alter table product AUTO_INCREMENT = 1');
        $this->addSql('INSERT INTO product (title, description, image)
        VALUES 
        ("Кофе Никарагуа Лос Пинос", "Невероятно сладкий и сбалансированный вкус. Очень тельный. Слива, тёмный шоколад, красное яблоко, карамель в букете", "/images/1.gif"),
        ("Кофе Гондурас Сан Исидро", "Молочный шоколад, красное яблоко, миндаль, карамель, мёд", "/images/2.gif"),
        ("Кофе Бразилия Аура Матина", "Чистый, сладкий, сбалансированный вкус с оттенками карамели, персика, ванили и орехового пралине. Кофе имеет гладкую текстуру, приятную структурированную кислотность и долгое сладкое послевкусие.", "/images/3.gif"),
        ("Кофе Колумбия Хосе Лизардо", "Очень сладкий и комплексный вкус. Плотный, тягучий и гладкий эспрессо. Приятная структурированная кислотность. Дюшес, персик, молочный шоколад и карамель в букете", "/images/4.gif"),
        ("Чай Саусеп", "Китайский зеленый чай с кусочками саусепа, лепестками цветов сафлора и василька. Светло-зеленый настой с желто-медовым оттенком имеет слегка терпкий вкус и свежий аромат тропического саусепа.", "/images/5.png")
');
        $this->addSql('INSERT INTO category_product (category_id, product_id) VALUES (4, 1), (4,2), (4,3), (1, 1), (2,2), (5,5)');
        $this->addSql('INSERT INTO price (product_id, value, is_current) VALUES (1 , 209, 1), (2, 200, 1), (3, 189, 1), (4, 160, 1), (5,150, 1)');

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
