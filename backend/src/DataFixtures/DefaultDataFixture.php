<?php

namespace App\DataFixtures;

use App\Security\UserProvider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class DefaultDataFixture extends Fixture
{
    /**
     * @var UserProvider
     */
    private $userProvider;

    /**
     * DefaultDataFixture constructor.
     *
     * @param UserProvider $userProvider
     */
    public function __construct(UserProvider $userProvider)
    {
        $this->userProvider = $userProvider;
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $admin = $this->userProvider->create(
            'admin',
            'administratorovic',
            'admin@dkzp.local',
            'admin'
        );
        $admin->setRoles([0 => 'ROLE_ADMIN']);
        $admin->enable();

        $user = $this->userProvider->create(
            'philip',
            'fry',
            'philip@dkzp.local',
            'password'
        );
        $user->enable();

        $manager->persist($admin);
        $manager->persist($user);
        $manager->flush();
    }
}
