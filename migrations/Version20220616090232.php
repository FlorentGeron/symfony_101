<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220616090232 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_channel (user_id INT NOT NULL, channel_id INT NOT NULL, PRIMARY KEY(user_id, channel_id))');
        $this->addSql('CREATE INDEX IDX_FAF4904DA76ED395 ON user_channel (user_id)');
        $this->addSql('CREATE INDEX IDX_FAF4904D72F5A1AA ON user_channel (channel_id)');
        $this->addSql('ALTER TABLE user_channel ADD CONSTRAINT FK_FAF4904DA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_channel ADD CONSTRAINT FK_FAF4904D72F5A1AA FOREIGN KEY (channel_id) REFERENCES channel (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE channel_user');
        $this->addSql('ALTER TABLE message DROP CONSTRAINT fk_b6bd307f9d86650f');
        $this->addSql('DROP INDEX idx_b6bd307f9d86650f');
        $this->addSql('ALTER TABLE message RENAME COLUMN user_id_id TO owner_id');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F7E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_B6BD307F7E3C61F9 ON message (owner_id)');
        $this->addSql('ALTER TABLE "user" ADD roles JSON NOT NULL');
        $this->addSql('ALTER TABLE "user" ALTER nickname TYPE VARCHAR(180)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649A188FE64 ON "user" (nickname)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE channel_user (channel_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(channel_id, user_id))');
        $this->addSql('CREATE INDEX idx_11c7753772f5a1aa ON channel_user (channel_id)');
        $this->addSql('CREATE INDEX idx_11c77537a76ed395 ON channel_user (user_id)');
        $this->addSql('ALTER TABLE channel_user ADD CONSTRAINT fk_11c7753772f5a1aa FOREIGN KEY (channel_id) REFERENCES channel (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE channel_user ADD CONSTRAINT fk_11c77537a76ed395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE user_channel');
        $this->addSql('DROP INDEX UNIQ_8D93D649A188FE64');
        $this->addSql('ALTER TABLE "user" DROP roles');
        $this->addSql('ALTER TABLE "user" ALTER nickname TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE message DROP CONSTRAINT FK_B6BD307F7E3C61F9');
        $this->addSql('DROP INDEX IDX_B6BD307F7E3C61F9');
        $this->addSql('ALTER TABLE message RENAME COLUMN owner_id TO user_id_id');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT fk_b6bd307f9d86650f FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_b6bd307f9d86650f ON message (user_id_id)');
    }
}
