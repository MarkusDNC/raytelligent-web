<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161003180812 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE applications DROP FOREIGN KEY FK_F7C966F0A247991F');
        $this->addSql('DROP INDEX UNIQ_F7C966F0A247991F ON applications');
        $this->addSql('ALTER TABLE applications DROP sensor_id');
        $this->addSql('ALTER TABLE sensors ADD application_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sensors ADD CONSTRAINT FK_D0D3FA903E030ACD FOREIGN KEY (application_id) REFERENCES applications (id)');
        $this->addSql('CREATE INDEX IDX_D0D3FA903E030ACD ON sensors (application_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE applications ADD sensor_id VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE applications ADD CONSTRAINT FK_F7C966F0A247991F FOREIGN KEY (sensor_id) REFERENCES sensors (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F7C966F0A247991F ON applications (sensor_id)');
        $this->addSql('ALTER TABLE sensors DROP FOREIGN KEY FK_D0D3FA903E030ACD');
        $this->addSql('DROP INDEX IDX_D0D3FA903E030ACD ON sensors');
        $this->addSql('ALTER TABLE sensors DROP application_id');
    }
}
