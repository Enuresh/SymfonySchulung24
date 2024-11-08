<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241105105127 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Make project_id in event and volunteer nullable.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event CHANGE project_id project_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE volunteer CHANGE project_id project_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event CHANGE project_id project_id INT NOT NULL');
        $this->addSql('ALTER TABLE volunteer CHANGE project_id project_id INT NOT NULL');
    }
}
