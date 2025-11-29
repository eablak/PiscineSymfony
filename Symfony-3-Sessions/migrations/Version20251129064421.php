<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251129064421 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post ADD last_edited_time DATETIME DEFAULT NULL, ADD last_edited_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D2CDA43A FOREIGN KEY (last_edited_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8D2CDA43A ON post (last_edited_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D2CDA43A');
        $this->addSql('DROP INDEX IDX_5A8A6C8D2CDA43A ON post');
        $this->addSql('ALTER TABLE post DROP last_edited_time, DROP last_edited_user_id');
    }
}
