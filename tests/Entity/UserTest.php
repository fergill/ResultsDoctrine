<?php

/**
 * PHP version 7.4
 * tests/Entity/UserTest.php
 *
 * @category EntityTests
 * @package  MiW\Results\Tests
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://www.etsisi.upm.es/ ETS de Ingeniería de Sistemas Informáticos
 */

namespace MiW\Results\Tests\Entity;

use MiW\Results\Entity\User;
use PHPUnit\Framework\TestCase;

/**
 * Class UserTest
 *
 * @package MiW\Results\Tests\Entity
 * @group   users
 */
class UserTest extends TestCase
{
    /**
     * @var User $user
     */
    private $user;

    /**
     * Sets up the fixture.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->user = new User(
            'luis',
            'luis@aol.com',
            '123',
            1,
            1);
    }

    /**
     * @covers \MiW\Results\Entity\User::__construct()
     * @covers |MiW\Results\Entity\User::getUsername()
     * @covers |MiW\Results\Entity\User::getEmail()
     * @covers |MiW\Results\Entity\User::isEnabled()
     * @covers |MiW\Results\Entity\User::isAdmin()
     */
    public function testConstructor(): void
    {
        self::assertEquals('luis', $this->user->getUsername());
        self::assertNotEquals('luis@gmail.com', $this->user->getEmail());
        self::assertTrue($this->user->isEnabled());
        self::assertTrue($this->user->isAdmin());
    }

    /**
     * @covers \MiW\Results\Entity\User::getId()
     */
    public function testGetId(): void
    {
        self::assertEquals(0, $this->user->getId());
    }

    /**
     * @covers \MiW\Results\Entity\User::setUsername()
     * @covers \MiW\Results\Entity\User::getUsername()
     */
    public function testGetSetUsername(): void
    {
        $this->user->setUsername("carlos");
        self::assertEquals("carlos", $this->user->getUsername());
    }

    /**
     * @covers \MiW\Results\Entity\User::getEmail()
     * @covers \MiW\Results\Entity\User::setEmail()
     */
    public function testGetSetEmail(): void
    {
        $this->user->setEmail("carlos@yopmail.com");
        self::assertEquals("carlos@yopmail.com", $this->user->getEmail());
    }

    /**
     * @covers \MiW\Results\Entity\User::setEnabled()
     * @covers \MiW\Results\Entity\User::isEnabled()
     */
    public function testIsSetEnabled(): void
    {
        $this->user->setEnabled(false);
        self::assertFalse($this->user->isEnabled());
    }

    /**
     * @covers \MiW\Results\Entity\User::setIsAdmin()
     * @covers \MiW\Results\Entity\User::isAdmin
     */
    public function testIsSetAdmin(): void
    {
        $this->user->setIsAdmin(true);
        self::assertTrue($this->user->isAdmin());
    }

    /**
     * @covers \MiW\Results\Entity\User::setPassword()
     * @covers \MiW\Results\Entity\User::validatePassword()
     */
    public function testSetValidatePassword(): void
    {
        self::assertTrue($this->user->validatePassword("123"));
    }

    /**
     * @covers \MiW\Results\Entity\User::__toString()
     */
    public function testToString(): void
    {
        $toString = sprintf(
            '%3d - %20s - %30s - %1d - %1d',
            $this->user->getId(),
            $this->user->getUsername(),
            $this->user->getEmail(),
            $this->user->isEnabled(),
            $this->user->isAdmin()
        );
        self::assertEquals($toString, $this->user, "los strings son iguales");
    }

    /**
     * @covers \MiW\Results\Entity\User::jsonSerialize()
     */
    public function testJsonSerialize(): void
    {
        $array = array(
            'id'            => $this->user->getId(),
            'username'      => $this->user->getUsername(),
            'email'         => $this->user->getEmail(),
            'enabled'       => $this->user->isEnabled(),
            'admin'         => $this->user->isAdmin()
        );
        self::assertEquals(json_encode($array), json_encode($this->user), "los objetos son iguales");
    }
}
