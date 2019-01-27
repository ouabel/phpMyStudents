<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Student;
use App\Entity\Department;

class AppFixtures extends Fixture
{
	public function load(ObjectManager $manager)
	{
		$departments = [
			[ 'name' => 'Auvergne-Rhône-Alpes', 'capacity' => 500 ],
			[ 'name' => 'Bourgogne-Franche-Comté', 'capacity' => 400 ],
			[ 'name' => 'Bretagne', 'capacity' => 350 ],
			[ 'name' => 'Centre-Val de Loire', 'capacity' => 300 ]
		];

		for ($i = 0; $i < count($departments) ; $i++) {
			$d[$i] = new Department();
			$d[$i]->setName($departments[$i]['name']);
			$d[$i]->setCapacity($departments[$i]['capacity']);
			$manager->persist($d[$i]);
		}

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
