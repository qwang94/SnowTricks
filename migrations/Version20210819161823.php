<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210819161823 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, figure_id INTEGER DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , content CLOB NOT NULL)');
        $this->addSql('CREATE INDEX IDX_9474526CA76ED395 ON comment (user_id)');
        $this->addSql('CREATE INDEX IDX_9474526C5C011B5 ON comment (figure_id)');
        $this->addSql('DROP INDEX IDX_2F57B37AA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__figure AS SELECT id, user_id, name, description, created_at, slug, file FROM figure');
        $this->addSql('DROP TABLE figure');
        $this->addSql('CREATE TABLE figure (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, description CLOB NOT NULL COLLATE BINARY, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , slug VARCHAR(255) NOT NULL COLLATE BINARY, file VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_2F57B37AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO figure (id, user_id, name, description, created_at, slug, file) SELECT id, user_id, name, description, created_at, slug, file FROM __temp__figure');
        $this->addSql('DROP TABLE __temp__figure');
        $this->addSql('CREATE INDEX IDX_2F57B37AA76ED395 ON figure (user_id)');
        $this->addSql('DROP INDEX IDX_7FEDC2FCFE54D947');
        $this->addSql('DROP INDEX IDX_7FEDC2FC5C011B5');
        $this->addSql('CREATE TEMPORARY TABLE __temp__figure_group AS SELECT figure_id, group_id FROM figure_group');
        $this->addSql('DROP TABLE figure_group');
        $this->addSql('CREATE TABLE figure_group (figure_id INTEGER NOT NULL, group_id INTEGER NOT NULL, PRIMARY KEY(figure_id, group_id), CONSTRAINT FK_7FEDC2FC5C011B5 FOREIGN KEY (figure_id) REFERENCES figure (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_7FEDC2FCFE54D947 FOREIGN KEY (group_id) REFERENCES "group" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO figure_group (figure_id, group_id) SELECT figure_id, group_id FROM __temp__figure_group');
        $this->addSql('DROP TABLE __temp__figure_group');
        $this->addSql('CREATE INDEX IDX_7FEDC2FCFE54D947 ON figure_group (group_id)');
        $this->addSql('CREATE INDEX IDX_7FEDC2FC5C011B5 ON figure_group (figure_id)');
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
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP INDEX IDX_2F57B37AA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__figure AS SELECT id, user_id, name, description, created_at, slug, file FROM figure');
        $this->addSql('DROP TABLE figure');
        $this->addSql('CREATE TABLE figure (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, description CLOB NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , slug VARCHAR(255) NOT NULL, file VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO figure (id, user_id, name, description, created_at, slug, file) SELECT id, user_id, name, description, created_at, slug, file FROM __temp__figure');
        $this->addSql('DROP TABLE __temp__figure');
        $this->addSql('CREATE INDEX IDX_2F57B37AA76ED395 ON figure (user_id)');
        $this->addSql('DROP INDEX IDX_7FEDC2FC5C011B5');
        $this->addSql('DROP INDEX IDX_7FEDC2FCFE54D947');
        $this->addSql('CREATE TEMPORARY TABLE __temp__figure_group AS SELECT figure_id, group_id FROM figure_group');
        $this->addSql('DROP TABLE figure_group');
        $this->addSql('CREATE TABLE figure_group (figure_id INTEGER NOT NULL, group_id INTEGER NOT NULL, PRIMARY KEY(figure_id, group_id))');
        $this->addSql('INSERT INTO figure_group (figure_id, group_id) SELECT figure_id, group_id FROM __temp__figure_group');
        $this->addSql('DROP TABLE __temp__figure_group');
        $this->addSql('CREATE INDEX IDX_7FEDC2FC5C011B5 ON figure_group (figure_id)');
        $this->addSql('CREATE INDEX IDX_7FEDC2FCFE54D947 ON figure_group (group_id)');
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
