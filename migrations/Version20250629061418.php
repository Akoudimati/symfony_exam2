<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20250629061418 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        
        $this->addSql(<<<'SQL'
            ALTER TABLE purchase ADD first_name VARCHAR(255) NOT NULL, ADD last_name VARCHAR(255) NOT NULL, ADD email VARCHAR(255) NOT NULL, ADD phone_number VARCHAR(20) NOT NULL, ADD postal_code VARCHAR(10) NOT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
       
        $this->addSql(<<<'SQL'
            ALTER TABLE purchase DROP first_name, DROP last_name, DROP email, DROP phone_number, DROP postal_code
        SQL);
    }
}
