<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Student;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    { 
    	for ($i = 10; $i < 26; $i++){
    		$student = new Student();
    		$student->setFirstName('Jean ' . $i);
    		$student->setLastName('François ' . $i);
    		$student->setNumEtud((rand(1000000,9999999)) . $i);
    		$manager->persist($student);
    	}
        $manager->flush();
    }
}
