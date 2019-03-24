<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190323213931 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $files = [
            'event_streams' => __DIR__ . '/../../vendor/prooph/pdo-event-store/scripts/mysql/01_event_streams_table.sql',
            'projections' => __DIR__ . '/../../vendor/prooph/pdo-event-store/scripts/mysql/02_projections_table.sql',
        ];

        foreach ($files as $table => $file) {
            if (false === $schema->hasTable($table)) {
                $this->addSql(file_get_contents($file));
            }
        }

    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE IF EXISTS event_streams;');
        $this->addSql('DROP TABLE IF EXISTS projections;');
    }
}
