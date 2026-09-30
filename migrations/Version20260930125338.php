<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260930125338 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE competence_traduction (libelle VARCHAR(100) NOT NULL, id_competence INT NOT NULL, code_langue VARCHAR(5) NOT NULL, PRIMARY KEY (id_competence, code_langue))');
        $this->addSql('CREATE INDEX IDX_E10CBB5F315EE8A8 ON competence_traduction (id_competence)');
        $this->addSql('CREATE INDEX IDX_E10CBB5FECD12D2C ON competence_traduction (code_langue)');
        $this->addSql('CREATE TABLE langue (code_langue VARCHAR(5) NOT NULL, nom_langue VARCHAR(50) NOT NULL, PRIMARY KEY (code_langue))');
        $this->addSql('ALTER TABLE competence_traduction ADD CONSTRAINT FK_E10CBB5F315EE8A8 FOREIGN KEY (id_competence) REFERENCES competence (id_competence) ON DELETE CASCADE NOT DEFERRABLE');
        $this->addSql('ALTER TABLE competence_traduction ADD CONSTRAINT FK_E10CBB5FECD12D2C FOREIGN KEY (code_langue) REFERENCES langue (code_langue) ON DELETE CASCADE NOT DEFERRABLE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE competence_traduction DROP CONSTRAINT FK_E10CBB5F315EE8A8');
        $this->addSql('ALTER TABLE competence_traduction DROP CONSTRAINT FK_E10CBB5FECD12D2C');
        $this->addSql('DROP TABLE competence_traduction');
        $this->addSql('DROP TABLE langue');
    }
}
