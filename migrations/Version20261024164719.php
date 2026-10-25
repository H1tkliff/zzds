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
        // Spalten erst nullable anlegen, mit Daten füllen, dann NOT NULL setzen –
        // sonst schlagen Unique-Index/Foreign Key auf bestehenden Zeilen fehl

        // discipline.slug aus dem Namen ableiten ("CS2" → "cs2")
        $this->addSql('ALTER TABLE discipline ADD slug VARCHAR(50) DEFAULT NULL');
        $this->addSql("UPDATE discipline SET slug = LOWER(REPLACE(name, ' ', '-'))");
        $this->addSql('ALTER TABLE discipline CHANGE slug slug VARCHAR(50) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_75BEEE3F989D9B62 ON discipline (slug)');

        // ranking.discipline vom Team übernehmen
        $this->addSql('ALTER TABLE ranking ADD discipline_id INT DEFAULT NULL');
        $this->addSql('UPDATE ranking r JOIN team t ON t.id = r.team_id SET r.discipline_id = t.discipline_id');
        $this->addSql('ALTER TABLE ranking CHANGE discipline_id discipline_id INT NOT NULL');
        $this->addSql('ALTER TABLE ranking ADD CONSTRAINT FK_80B839D0A5522701 FOREIGN KEY (discipline_id) REFERENCES discipline (id)');
        $this->addSql('CREATE INDEX IDX_80B839D0A5522701 ON ranking (discipline_id)');

        // team.name: leere Namen auffüllen
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
