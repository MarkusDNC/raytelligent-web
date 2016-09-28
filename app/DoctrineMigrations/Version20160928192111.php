<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160928192111 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_1483A5E992FC23A8 ON users');
        $this->addSql('DROP INDEX UNIQ_1483A5E9A0D96FBF ON users');
        $this->addSql('DROP INDEX UNIQ_1483A5E9C05FB297 ON users');
        $this->addSql('ALTER TABLE users ADD first_name VARCHAR(50) DEFAULT NULL, ADD last_name VARCHAR(50) DEFAULT NULL, ADD address1 VARCHAR(50) DEFAULT NULL, ADD address2 VARCHAR(50) DEFAULT NULL, ADD city VARCHAR(30) DEFAULT NULL, ADD post_code VARCHAR(10) DEFAULT NULL, ADD country VARCHAR(2) DEFAULT NULL, DROP username, DROP username_canonical, DROP email_canonical, DROP enabled, DROP last_login, DROP locked, DROP expired, DROP expires_at, DROP confirmation_token, DROP password_requested_at, DROP roles, DROP credentials_expired, DROP credentials_expire_at, CHANGE email email VARCHAR(255) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE users ADD username VARCHAR(180) NOT NULL COLLATE utf8_unicode_ci, ADD username_canonical VARCHAR(180) NOT NULL COLLATE utf8_unicode_ci, ADD email_canonical VARCHAR(180) NOT NULL COLLATE utf8_unicode_ci, ADD enabled TINYINT(1) NOT NULL, ADD last_login DATETIME DEFAULT NULL, ADD locked TINYINT(1) NOT NULL, ADD expired TINYINT(1) NOT NULL, ADD expires_at DATETIME DEFAULT NULL, ADD confirmation_token VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD password_requested_at DATETIME DEFAULT NULL, ADD roles LONGTEXT NOT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:array)\', ADD credentials_expired TINYINT(1) NOT NULL, ADD credentials_expire_at DATETIME DEFAULT NULL, DROP first_name, DROP last_name, DROP address1, DROP address2, DROP city, DROP post_code, DROP country, CHANGE email email VARCHAR(180) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E992FC23A8 ON users (username_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9A0D96FBF ON users (email_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9C05FB297 ON users (confirmation_token)');
    }
}
