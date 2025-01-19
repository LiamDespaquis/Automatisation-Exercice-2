<?php

namespace App\Console;

use App\Models\Company;
use App\Models\Employee;
use App\Models\Office;
use Illuminate\Support\Facades\Schema;
use Slim\App;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Faker\Factory;

class PopulateDatabaseCommand extends Command
{
    private App $app;

    public function __construct(App $app)
    {
        $this->app = $app;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('db:populate');
        $this->setDescription('Populate database');
    }

    protected function execute(InputInterface $input, OutputInterface $output ): int
    {
        $output->writeln('Populate database...');

        /** @var \Illuminate\Database\Capsule\Manager $db */
        $db = $this->app->getContainer()->get('db');

        $db->getConnection()->statement("SET FOREIGN_KEY_CHECKS=0");
        $db->getConnection()->statement("TRUNCATE `employees`");
        $db->getConnection()->statement("TRUNCATE `offices`");
        $db->getConnection()->statement("TRUNCATE `companies`");
        $db->getConnection()->statement("SET FOREIGN_KEY_CHECKS=1");

        $faker = Factory::create('fr_FR');
        $idEmployee = 1; 
        $idOffice = 1;

        for($i = 1; $i<=2; $i++) {
            $company = new Company();
            $company->id = $i;
            $company->name  = $faker->company();
            $company->phone = $faker->phoneNumber();
            $company->email = $faker->companyEmail();  
            $company->website = $faker->url();
            $company->image = $faker->image() ;
            $company->save();

            for ($j = 1; $j<=4; $j++) {
                $city = $faker->city();
                $office = new Office( );
                $office->id = $idOffice++;
                $office->name  = 'Bureau de '.$city;
                $office->address = $faker->streetAddress();
                $office->city = $city;
                $office->zip_code = $faker->postcode();
                $office->country = $faker->country();
                $office->email = $faker->email();
                $office->phone = $faker->phoneNumber();
               
                $company->offices()->save($office);
                $office->save();

                for ($k = 1; $k<=10;$k++) {
                    $employee = new Employee();
                    $employee->id = $idEmployee++;
                    $employee->first_name  = $faker->firstName();
                    $employee->last_name   = $faker->lastName();
                    $employee->email       = $faker->email();
                    $employee->phone       = $faker->phoneNumber();
                    $employee->job_title   = $faker->jobTitle();
                    $office->employees()->save($employee);
                    $employee->save();
                }
            }
            $company->headOffice()->associate($company->offices()->first());
            $company->save();
        }

        /*$db->getConnection()->statement("INSERT INTO `companies` VALUES
    (1,'Stack Exchange','0601010101','stack@exchange.com','https://stackexchange.com/','https://upload.wikimedia.org/wikipedia/commons/thumb/5/5b/Verisure_information_technology_department_at_Ch%C3%A2tenay-Malabry_-_2019-01-10.jpg/1920px-Verisure_information_technology_department_at_Ch%C3%A2tenay-Malabry_-_2019-01-10.jpg', now(), now(), null),
    (2,'Google','0602020202','contact@google.com','https://www.google.com','https://upload.wikimedia.org/wikipedia/commons/thumb/e/e0/Google_office_%284135991953%29.jpg/800px-Google_office_%284135991953%29.jpg?20190722090506',now(), now(), null)
        ");

        $db->getConnection()->statement("INSERT INTO `offices` VALUES
    (1,'Bureau de Nancy','1 rue Stanistlas','Nancy','54000','France','nancy@stackexchange.com',NULL,1, now(), now()),
    (2,'Burea de Vandoeuvre','46 avenue Jeanne d\'Arc','Vandoeuvre','54500','France',NULL,NULL,1, now(), now()),
    (3,'Siege sociale','2 rue de la primatiale','Paris','75000','France',NULL,NULL,2, now(), now()),
    (4,'Bureau Berlinois','192 avenue central','Berlin','12277','Allemagne',NULL,NULL,2, now(), now())
        ");

        $db->getConnection()->statement("INSERT INTO `employees` VALUES
     (1,'Camille','La Chenille',1,'camille.la@chenille.com',NULL,'Ingénieur', now(), now()),
     (2,'Albert','Mudhat',2,'albert.mudhat@aqume.net',NULL,'Superviseur', now(), now()),
     (3,'Sylvie','Tesse',3,'sylive.tesse@factice.local',NULL,'PDG', now(), now()),
     (4,'John','Doe',4,'john.doe@generique.org',NULL,'Testeur', now(), now()),
     (5,'Jean','Bon',1,'jean@test.com',NULL,'Developpeur', now(), now()),
     (6,'Anais','Dufour',2,'anais@aqume.net',NULL,'DBA', now(), now()),
     (7,'Sylvain','Poirson',3,'sylvain@factice.local',NULL,'Administrateur réseau', now(), now()),
     (8,'Telma','Thiriet',4,'telma@generique.org',NULL,'Juriste', now(), now())
        ");

        $db->getConnection()->statement("update companies set head_office_id = 1 where id = 1;");
        $db->getConnection()->statement("update companies set head_office_id = 3 where id = 2;");
*/
        $output->writeln('Database created successfully!');
        return 0;
    }
}
