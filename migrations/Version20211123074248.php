<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211123074248 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE characters ADD gls_kind VARCHAR(16) NOT NULL, ADD gls_name VARCHAR(16) NOT NULL, ADD gls_caste VARCHAR(16) DEFAULT NULL, ADD gls_knowledge VARCHAR(16) DEFAULT NULL, ADD gls_intelligence INT DEFAULT NULL, ADD gls_life INT DEFAULT NULL, DROP kind, DROP name, DROP caste, DROP knowledge, DROP intelligence, DROP life, CHANGE surname gls_surname VARCHAR(64) NOT NULL, CHANGE image gls_image VARCHAR(128) DEFAULT NULL, CHANGE creation gls_creation DATETIME NOT NULL, CHANGE identifier gls_identifier VARCHAR(40) NOT NULL, CHANGE modification gls_modification DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE players CHANGE firstname gls_firstname VARCHAR(64) NOT NULL, CHANGE lastname gls_lastname VARCHAR(64) DEFAULT NULL, CHANGE email gls_email VARCHAR(128) DEFAULT NULL, CHANGE mirian gls_mirian INT DEFAULT NULL, CHANGE creation gls_creation DATETIME NOT NULL, CHANGE identifier gls_identifier VARCHAR(40) NOT NULL, CHANGE modification gls_modification DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE characters ADD kind VARCHAR(16) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD name VARCHAR(16) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD caste VARCHAR(16) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD knowledge VARCHAR(16) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD intelligence INT DEFAULT NULL, ADD life INT DEFAULT NULL, DROP gls_kind, DROP gls_name, DROP gls_caste, DROP gls_knowledge, DROP gls_intelligence, DROP gls_life, CHANGE gls_surname surname VARCHAR(64) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE gls_image image VARCHAR(128) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE gls_creation creation DATETIME NOT NULL, CHANGE gls_identifier identifier VARCHAR(40) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE gls_modification modification DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE players CHANGE gls_firstname firstname VARCHAR(64) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE gls_lastname lastname VARCHAR(64) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE gls_email email VARCHAR(128) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE gls_mirian mirian INT DEFAULT NULL, CHANGE gls_creation creation DATETIME NOT NULL, CHANGE gls_identifier identifier VARCHAR(40) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE gls_modification modification DATETIME DEFAULT NULL');
    }
}
