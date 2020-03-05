<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200226231037 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_groupe (user_id INT NOT NULL, groupe_id INT NOT NULL, INDEX IDX_61EB971CA76ED395 (user_id), INDEX IDX_61EB971C7A45358C (groupe_id), PRIMARY KEY(user_id, groupe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_groupe ADD CONSTRAINT FK_61EB971CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_groupe ADD CONSTRAINT FK_61EB971C7A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_user ADD CONSTRAINT FK_F7129A803AD8644E FOREIGN KEY (user_source) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_user ADD CONSTRAINT FK_F7129A80233D34C1 FOREIGN KEY (user_target) REFERENCES user (id)');
        $this->addSql('ALTER TABLE invite_user ADD CONSTRAINT FK_95A717C3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE invite_groupe ADD CONSTRAINT FK_29B616F27A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user_groupe');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E7A45358C');
        $this->addSql('ALTER TABLE eventuser DROP FOREIGN KEY FK_D1370A60A76ED395');
        $this->addSql('ALTER TABLE eventuser DROP FOREIGN KEY FK_D1370A60753AAE2');
        $this->addSql('ALTER TABLE groupe DROP FOREIGN KEY FK_4B98C21A76ED395');
        $this->addSql('ALTER TABLE invite_groupe DROP FOREIGN KEY FK_29B616F27A45358C');
        $this->addSql('ALTER TABLE invite_user DROP FOREIGN KEY FK_95A717C3A76ED395');
        $this->addSql('ALTER TABLE user_user DROP FOREIGN KEY FK_F7129A803AD8644E');
        $this->addSql('ALTER TABLE user_user DROP FOREIGN KEY FK_F7129A80233D34C1');
    }
}
