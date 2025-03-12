<?php

namespace App\DataFixtures;

use App\Entity\Animal;
use App\Entity\Race;
use App\Entity\TypeAnimal;
use App\Entity\Photo;
use App\Entity\UtilisateurAdmin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;
    
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    
    public function load(ObjectManager $manager): void
    {
        // Créer des types d'animaux
        $typeBovin = new TypeAnimal();
        $typeBovin->setNom('Bovin');
        $typeBovin->setDescription('Bovins domestiques');
        $manager->persist($typeBovin);
        
        $typeOvin = new TypeAnimal();
        $typeOvin->setNom('Ovin');
        $typeOvin->setDescription('Ovins domestiques');
        $manager->persist($typeOvin);
        
        // Créer des races
        $raceAngus = new Race();
        $raceAngus->setNom('Angus');
        $raceAngus->setDescription('Race à viande écossaise');
        $raceAngus->setTypeAnimal($typeBovin);
        $manager->persist($raceAngus);
        
        $raceTexel = new Race();
        $raceTexel->setNom('Texel');
        $raceTexel->setDescription('Race ovine néerlandaise');
        $raceTexel->setTypeAnimal($typeOvin);
        $manager->persist($raceTexel);
        
        // Créer des animaux
        $animal1 = new Animal();
        $animal1->setReference('BOV-001');
        $animal1->setAge(3);
        $animal1->setDescription('Taureau Angus de 3 ans');
        $animal1->setPrixHt(1500);
        $animal1->setEstAVendre(true);
        $animal1->setDateAchat(new \DateTime('2023-01-15'));
        $animal1->setDateMiseEnVente(new \DateTime('2023-05-20'));
        $animal1->setRace($raceAngus);
        $manager->persist($animal1);
        
        // Créer des photos
        $photo1 = new Photo();
        $photo1->setChemin('/uploads/angus1.jpg');
        $photo1->setAlt('Taureau Angus vue de face');
        $photo1->setEstPrincipale(true);
        $photo1->setAnimal($animal1);
        $manager->persist($photo1);
        
        // Créer un utilisateur admin
        $admin = new UtilisateurAdmin();
        $admin->setEmail('jones@example.com');
        $admin->setNom('Jones');
        $admin->setPrenom('Michael');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'password123'));
        $manager->persist($admin);
        
        $manager->flush();
    }
}