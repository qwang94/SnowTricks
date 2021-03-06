<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210827203654 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE video (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, figure_id INTEGER NOT NULL, source VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_7CC7DA2C5C011B5 ON video (figure_id)');
        $this->addSql('DROP INDEX IDX_9474526CA76ED395');
        $this->addSql('DROP INDEX IDX_9474526C5C011B5');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, user_id, figure_id, content, created_at FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, figure_id INTEGER DEFAULT NULL, content CLOB NOT NULL COLLATE BINARY, created_at DATETIME NOT NULL, CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9474526C5C011B5 FOREIGN KEY (figure_id) REFERENCES figure (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO comment (id, user_id, figure_id, content, created_at) SELECT id, user_id, figure_id, content, created_at FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
        $this->addSql('CREATE INDEX IDX_9474526CA76ED395 ON comment (user_id)');
        $this->addSql('CREATE INDEX IDX_9474526C5C011B5 ON comment (figure_id)');
        $this->addSql('DROP INDEX UNIQ_2F57B37A5E237E06');
        $this->addSql('DROP INDEX IDX_2F57B37AA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__figure AS SELECT id, user_id, name, description, slug, created_at, updated_at FROM figure');
        $this->addSql('DROP TABLE figure');
        $this->addSql('CREATE TABLE figure (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, description CLOB NOT NULL COLLATE BINARY, slug VARCHAR(255) NOT NULL COLLATE BINARY, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, CONSTRAINT FK_2F57B37AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO figure (id, user_id, name, description, slug, created_at, updated_at) SELECT id, user_id, name, description, slug, created_at, updated_at FROM __temp__figure');
        $this->addSql('DROP TABLE __temp__figure');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2F57B37A5E237E06 ON figure (name)');
        $this->addSql('CREATE INDEX IDX_2F57B37AA76ED395 ON figure (user_id)');
        $this->addSql('DROP INDEX IDX_5F0A4745C011B5');
        $this->addSql('DROP INDEX IDX_5F0A47412469DE2');
        $this->addSql('CREATE TEMPORARY TABLE __temp__figure_category AS SELECT figure_id, category_id FROM figure_category');
        $this->addSql('DROP TABLE figure_category');
        $this->addSql('CREATE TABLE figure_category (figure_id INTEGER NOT NULL, category_id INTEGER NOT NULL, PRIMARY KEY(figure_id, category_id), CONSTRAINT FK_5F0A4745C011B5 FOREIGN KEY (figure_id) REFERENCES figure (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5F0A47412469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO figure_category (figure_id, category_id) SELECT figure_id, category_id FROM __temp__figure_category');
        $this->addSql('DROP TABLE __temp__figure_category');
        $this->addSql('CREATE INDEX IDX_5F0A4745C011B5 ON figure_category (figure_id)');
        $this->addSql('CREATE INDEX IDX_5F0A47412469DE2 ON figure_category (category_id)');
        $this->addSql('DROP INDEX IDX_6A2CA10C5C011B5');
        $this->addSql('CREATE TEMPORARY TABLE __temp__media AS SELECT id, figure_id, name, type FROM media');
        $this->addSql('DROP TABLE media');
        $this->addSql('CREATE TABLE media (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, figure_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, type VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_6A2CA10C5C011B5 FOREIGN KEY (figure_id) REFERENCES figure (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO media (id, figure_id, name, type) SELECT id, figure_id, name, type FROM __temp__media');
        $this->addSql('DROP TABLE __temp__media');
        $this->addSql('CREATE INDEX IDX_6A2CA10C5C011B5 ON media (figure_id)');
        $this->addSql('DROP INDEX IDX_7CE748AA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__reset_password_request AS SELECT id, user_id, selector, hashed_token, requested_at, expires_at FROM reset_password_request');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('CREATE TABLE reset_password_request (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, selector VARCHAR(20) NOT NULL COLLATE BINARY, hashed_token VARCHAR(100) NOT NULL COLLATE BINARY, requested_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , expires_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO reset_password_request (id, user_id, selector, hashed_token, requested_at, expires_at) SELECT id, user_id, selector, hashed_token, requested_at, expires_at FROM __temp__reset_password_request');
        $this->addSql('DROP TABLE __temp__reset_password_request');
        $this->addSql('CREATE INDEX IDX_7CE748AA76ED395 ON reset_password_request (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE video');
        $this->addSql('DROP INDEX IDX_9474526CA76ED395');
        $this->addSql('DROP INDEX IDX_9474526C5C011B5');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, user_id, figure_id, created_at, content FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, figure_id INTEGER DEFAULT NULL, created_at DATETIME NOT NULL, content CLOB NOT NULL)');
        $this->addSql('INSERT INTO comment (id, user_id, figure_id, created_at, content) SELECT id, user_id, figure_id, created_at, content FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
        $this->addSql('CREATE INDEX IDX_9474526CA76ED395 ON comment (user_id)');
        $this->addSql('CREATE INDEX IDX_9474526C5C011B5 ON comment (figure_id)');
        $this->addSql('DROP INDEX UNIQ_2F57B37A5E237E06');
        $this->addSql('DROP INDEX IDX_2F57B37AA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__figure AS SELECT id, user_id, name, description, created_at, slug, updated_at FROM figure');
        $this->addSql('DROP TABLE figure');
        $this->addSql('CREATE TABLE figure (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, description CLOB NOT NULL, created_at DATETIME NOT NULL, slug VARCHAR(255) NOT NULL, updated_at DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO figure (id, user_id, name, description, created_at, slug, updated_at) SELECT id, user_id, name, description, created_at, slug, updated_at FROM __temp__figure');
        $this->addSql('DROP TABLE __temp__figure');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2F57B37A5E237E06 ON figure (name)');
        $this->addSql('CREATE INDEX IDX_2F57B37AA76ED395 ON figure (user_id)');
        $this->addSql('DROP INDEX IDX_5F0A4745C011B5');
        $this->addSql('DROP INDEX IDX_5F0A47412469DE2');
        $this->addSql('CREATE TEMPORARY TABLE __temp__figure_category AS SELECT figure_id, category_id FROM figure_category');
        $this->addSql('DROP TABLE figure_category');
        $this->addSql('CREATE TABLE figure_category (figure_id INTEGER NOT NULL, category_id INTEGER NOT NULL, PRIMARY KEY(figure_id, category_id))');
        $this->addSql('INSERT INTO figure_category (figure_id, category_id) SELECT figure_id, category_id FROM __temp__figure_category');
        $this->addSql('DROP TABLE __temp__figure_category');
        $this->addSql('CREATE INDEX IDX_5F0A4745C011B5 ON figure_category (figure_id)');
        $this->addSql('CREATE INDEX IDX_5F0A47412469DE2 ON figure_category (category_id)');
        $this->addSql('DROP INDEX IDX_6A2CA10C5C011B5');
        $this->addSql('CREATE TEMPORARY TABLE __temp__media AS SELECT id, figure_id, name, type FROM media');
        $this->addSql('DROP TABLE media');
        $this->addSql('CREATE TABLE media (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, figure_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO media (id, figure_id, name, type) SELECT id, figure_id, name, type FROM __temp__media');
        $this->addSql('DROP TABLE __temp__media');
        $this->addSql('CREATE INDEX IDX_6A2CA10C5C011B5 ON media (figure_id)');
        $this->addSql('DROP INDEX IDX_7CE748AA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__reset_password_request AS SELECT id, user_id, selector, hashed_token, requested_at, expires_at FROM reset_password_request');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('CREATE TABLE reset_password_request (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , expires_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO reset_password_request (id, user_id, selector, hashed_token, requested_at, expires_at) SELECT id, user_id, selector, hashed_token, requested_at, expires_at FROM __temp__reset_password_request');
        $this->addSql('DROP TABLE __temp__reset_password_request');
        $this->addSql('CREATE INDEX IDX_7CE748AA76ED395 ON reset_password_request (user_id)');
    }
}
