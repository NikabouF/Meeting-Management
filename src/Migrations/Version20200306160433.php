<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200306160433 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE meeting (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, beginning TIME NOT NULL, end TIME NOT NULL, room VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, adder_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, firstname VARCHAR(255) DEFAULT NULL, address VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, present TINYINT(1) NOT NULL, admin TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D6499C1BD6FE (adder_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_meeting (user_id INT NOT NULL, meeting_id INT NOT NULL, INDEX IDX_AD18FF33A76ED395 (user_id), INDEX IDX_AD18FF3367433D9C (meeting_id), PRIMARY KEY(user_id, meeting_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6499C1BD6FE FOREIGN KEY (adder_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_meeting ADD CONSTRAINT FK_AD18FF33A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_meeting ADD CONSTRAINT FK_AD18FF3367433D9C FOREIGN KEY (meeting_id) REFERENCES meeting (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_meeting DROP FOREIGN KEY FK_AD18FF3367433D9C');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6499C1BD6FE');
        $this->addSql('ALTER TABLE user_meeting DROP FOREIGN KEY FK_AD18FF33A76ED395');
        $this->addSql('DROP TABLE meeting');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_meeting');
    }
}
