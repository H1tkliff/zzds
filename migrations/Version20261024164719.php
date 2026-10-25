<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261024164719 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add discipline.slug, ranking.discipline; team.name NOT NULL';
    }

    public function up(Schema $schema): void
    {
        // add columns as nullable first, fill them, then set NOT NULL –
        // otherwise the unique index / foreign key fails on existing rows

        // derive discipline.slug from the name ("CS2" → "cs2")
        $this->addSql('ALTER TABLE discipline ADD slug VARCHAR(50) DEFAULT NULL');
        $this->addSql("UPDATE discipline SET slug = LOWER(REPLACE(name, ' ', '-'))");
        $this->addSql('ALTER TABLE discipline CHANGE slug slug VARCHAR(50) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_75BEEE3F989D9B62 ON discipline (slug)');

        // take ranking.discipline from the team
        $this->addSql('ALTER TABLE ranking ADD discipline_id INT DEFAULT NULL');
        $this->addSql('UPDATE ranking r JOIN team t ON t.id = r.team_id SET r.discipline_id = t.discipline_id');
        $this->addSql('ALTER TABLE ranking CHANGE discipline_id discipline_id INT NOT NULL');
        $this->addSql('ALTER TABLE ranking ADD CONSTRAINT FK_80B839D0A5522701 FOREIGN KEY (discipline_id) REFERENCES discipline (id)');
        $this->addSql('CREATE INDEX IDX_80B839D0A5522701 ON ranking (discipline_id)');

        // team.name: fill empty names
        $this->addSql("UPDATE team SET name = CONCAT('team-', id) WHERE name IS NULL");
        $this->addSql('ALTER TABLE team CHANGE name name VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_75BEEE3F989D9B62 ON discipline');
        $this->addSql('ALTER TABLE discipline DROP slug');
        $this->addSql('ALTER TABLE team CHANGE name name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE ranking DROP FOREIGN KEY FK_80B839D0A5522701');
        $this->addSql('DROP INDEX IDX_80B839D0A5522701 ON ranking');
        $this->addSql('ALTER TABLE ranking DROP discipline_id');
    }
}
