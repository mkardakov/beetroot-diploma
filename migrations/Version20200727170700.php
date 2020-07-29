<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200727170700 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('INSERT INTO category (id, title, parent_id) VALUES(4, "Кофе", null), (5, "Чай", null)');
        $this->addSql('INSERT INTO category (id, title, parent_id) VALUES(1 ,"Арабика", 4),(2, "Робуста", 4),(3,"Гранулированный кофе", 4)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DELETE FROM category WHERE id IN (1,2,3)');
        $this->addSql('DELETE FROM category WHERE id IN (4,5)');
    }
}
