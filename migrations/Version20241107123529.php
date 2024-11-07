<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241107123529 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event ADD created_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7B03A8386 ON event (created_by_id)');
        $this->addSql('ALTER TABLE project ADD created_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EEB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_2FB3D0EEB03A8386 ON project (created_by_id)');
        $this->addSql('ALTER TABLE volunteer CHANGE for_user_id for_user_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EEB03A8386');
        $this->addSql('DROP INDEX IDX_2FB3D0EEB03A8386 ON project');
        $this->addSql('ALTER TABLE project DROP created_by_id');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7B03A8386');
        $this->addSql('DROP INDEX IDX_3BAE0AA7B03A8386 ON event');
        $this->addSql('ALTER TABLE event DROP created_by_id');
        $this->addSql('ALTER TABLE volunteer CHANGE for_user_id for_user_id INT DEFAULT NULL');
    }
}
