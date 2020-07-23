<?php

namespace Test\Hcode\Model;

use Exception;
use Hcode\DB\Sql;
use Hcode\Model\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    protected static $database;

    ### Test Environment ###
    public static function setUpBeforeClass(): void
    {
        self::$database = new Sql("test");
        // self::$database->query("CREATE DATABASE IF NOT EXISTS `db_ecommerce_test`");
        self::$database->query(
            "CREATE TABLE IF NOT EXISTS `tb_persons` (
                `idperson` int(11) NOT NULL AUTO_INCREMENT,
                `desperson` varchar(64) NOT NULL,
                `desemail` varchar(128) DEFAULT NULL,
                `nrphone` bigint(20) DEFAULT NULL,
                `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`idperson`)
              ) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;"
        );
        self::$database->query(
            "INSERT INTO `tb_persons` VALUES
            (1,'Cadu','cadu@mail.com',27981000090,'2020-07-23 03:00:00'),
            (7,'Suporte','suporte@mail.com',27981000090,'2020-07-23 16:10:27');"
        );
        self::$database->query(
            "CREATE TABLE IF NOT EXISTS`tb_users` (
                `iduser` int(11) NOT NULL AUTO_INCREMENT,
                `idperson` int(11) NOT NULL,
                `deslogin` varchar(64) NOT NULL,
                `despassword` varchar(256) NOT NULL,
                `inadmin` tinyint(4) NOT NULL DEFAULT '0',
                `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`iduser`),
                KEY `FK_users_persons_idx` (`idperson`),
                CONSTRAINT `fk_users_persons` FOREIGN KEY (`idperson`) REFERENCES `tb_persons` (`idperson`) ON DELETE NO ACTION ON UPDATE NO ACTION
            ) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;"
        );
        self::$database->query(
            "INSERT INTO `tb_users` VALUES
            (1,1,'admin','$2y$12\$YlooCyNvyTji8bPRcrfNfOKnVMmZA9ViM2A3IpFjmrpIbp5ovNmga',1,'2017-03-13 03:00:00'),
            (7,7,'suporte','$2y$12\$HFjgUm/mk1RzTy4ZkJaZBe0Mc/BA2hQyoUckvm.lFa6TesjtNpiMe',1,'2017-03-15 16:10:27');"
        );
    }

    public static function tearDownAfterClass(): void
    {
        self::$database = new Sql("test");
        self::$database->query(
            "DROP TABLE `tb_persons`, `tb_users`;"
        );
    }

    ### Tests Methods ###

    public function testUserLoginHasValidCredentials()
    {
        /* given */
        $userCredentials = [
            "login" => "admin",
            "password" => "admin",
        ];

        /* when */
        User::login($userCredentials['login'], $userCredentials['password']);

        /* then */
        $expected = [
            'iduser' => '1',
            'idperson' => '1',
            'deslogin' => 'admin',
            'despassword' => '$2y$12$YlooCyNvyTji8bPRcrfNfOKnVMmZA9ViM2A3IpFjmrpIbp5ovNmga',
            'inadmin' => '1',
            'dtregister' => '2017-03-13 03:00:00',
        ];

        self::assertEquals($expected, $_SESSION['User']);
    }

    public function testUserLoginHasNoValidCredentials()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Usuário inexistente ou senha inválida');

        $credentialHasNoLogin = [
            "login" => "",
            "password" => "admin",
        ];

        $credentialHasNoPassword = [
            "login" => "admin",
            "password" => "",
        ];

        $credentialHasNoData = [
            "login" => "",
            "password" => "",
        ];

        User::login($credentialHasNoLogin['login'], $credentialHasNoLogin['password']);
        User::login($credentialHasNoPassword['login'], $credentialHasNoPassword['password']);
        User::login($credentialHasNoData['login'], $credentialHasNoData['password']);
    }

    // public function testShouldVerifyIfThereIsSessionAvailable()
    // {
    //     /* given */
    //     $_SESSION['User']['inadmin'] = false;
    //     $_SESSION['User']['iduser'] = 0;

    //     /* when */
    //     $result = User::verifyLogin($_SESSION['User']);

    //     /* then */
    //     $expected = header('Location: /admin/login');
    //     self::assertEquals($expected, $result);
    // }

    public function testShouldReturnAllUsersFromDatabase()
    {
        /* given */
        $sql = new Sql("test");

        /* when */
        $result = $sql->select(
            "SELECT * FROM tb_users a INNER JOIN tb_persons b USING(idperson) ORDER BY b.desperson"
        );

        /* then */
        self::assertIsArray($result);
        self::assertCount(2, $result);
    }

    public function testShouldCreateANewAdminUser()
    {
        /* given */
        $emili = [
            "desperson" => "Emili",
            "deslogin" => "emili",
            "despassword" => "1234",
            "desemail" => "emili@mail.com",
            "nrphone" => 27996964890,
            "inadmin" => 1,
        ];
        $emili['despassword'] = password_hash($emili['despassword'], PASSWORD_BCRYPT);
        $user = new User();
        $sql = new Sql("test");

        /* when */
        $user->setData($emili);
        $user->save();

        /* then */
        $userCreated = $sql->select("SELECT * FROM tb_persons WHERE nrphone = {$emili['nrphone']}");

        self::assertEquals($emili["nrphone"], $userCreated['nrphone']);
    }
}
