<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200330164502 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ethnicity (id INT AUTO_INCREMENT NOT NULL, id_faction_id INT NOT NULL, name VARCHAR(20) NOT NULL, image VARCHAR(255) NOT NULL, INDEX IDX_CA7DEB93E1C2780D (id_faction_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE faction (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(20) NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE league (id INT AUTO_INCREMENT NOT NULL, id_parent_id INT DEFAULT NULL, level SMALLINT NOT NULL, pts_to_up SMALLINT DEFAULT NULL, pts_to_down SMALLINT DEFAULT NULL, UNIQUE INDEX UNIQ_3EB4C318F24F7657 (id_parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player (id INT AUTO_INCREMENT NOT NULL, id_ethnicity_id INT NOT NULL, id_team_id INT DEFAULT NULL, firstname VARCHAR(50) NOT NULL, lastname VARCHAR(50) NOT NULL, attack SMALLINT NOT NULL, block SMALLINT NOT NULL, dig SMALLINT NOT NULL, passing SMALLINT NOT NULL, serve SMALLINT NOT NULL, age SMALLINT NOT NULL, training_count SMALLINT NOT NULL, position enum(\'libero\', \'middle_blocker\', \'opposite\', \'outside_hitter\', \'setter\'), image VARCHAR(255) NOT NULL, in_squad TINYINT(1) NOT NULL, is_substitute TINYINT(1) NOT NULL, is_injured TINYINT(1) NOT NULL, is_retired TINYINT(1) NOT NULL, INDEX IDX_98197A6529EB9187 (id_ethnicity_id), INDEX IDX_98197A65F7F171DE (id_team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, id_league_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, image VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_C4E0A61F79F37AE5 (id_user_id), INDEX IDX_C4E0A61FD89A78F9 (id_league_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, nickname INT NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, money INT NOT NULL, first_login TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ethnicity ADD CONSTRAINT FK_CA7DEB93E1C2780D FOREIGN KEY (id_faction_id) REFERENCES faction (id)');
        $this->addSql('ALTER TABLE league ADD CONSTRAINT FK_3EB4C318F24F7657 FOREIGN KEY (id_parent_id) REFERENCES league (id)');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A6529EB9187 FOREIGN KEY (id_ethnicity_id) REFERENCES ethnicity (id)');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A65F7F171DE FOREIGN KEY (id_team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61FD89A78F9 FOREIGN KEY (id_league_id) REFERENCES league (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A6529EB9187');
        $this->addSql('ALTER TABLE ethnicity DROP FOREIGN KEY FK_CA7DEB93E1C2780D');
        $this->addSql('ALTER TABLE league DROP FOREIGN KEY FK_3EB4C318F24F7657');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61FD89A78F9');
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A65F7F171DE');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61F79F37AE5');
        $this->addSql('DROP TABLE ethnicity');
        $this->addSql('DROP TABLE faction');
        $this->addSql('DROP TABLE league');
        $this->addSql('DROP TABLE player');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE user');
    }
}
