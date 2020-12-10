<?php

require dirname(__DIR__, 2) . '/vendor/autoload.php';

use MiW\Results\Entity\User;
use MiW\Results\Utils;

require __DIR__ . '/../vendor/autoload.php';

// Carga las variables de entorno
Utils::loadEnv(dirname(__DIR__, 2));

$entityManager = Utils::getEntityManager();

$usersRepository = $entityManager->getRepository(User::class);

if ($argc < 2 || $argc > 3) {
    $fich = basename(__FILE__);
    echo <<< MARCA_FIN
    Usage: $fich <UserName>
MARCA_FIN;

    exit(0);
}

$userName = (string) $argv[1];

try {
    /** @var User $user */
    $user = $entityManager
        ->getRepository(User::class)
        ->findOneBy(['username' => $userName]);
    if (null === $user) {
        echo "Usuario con username $userName no encontrado" . PHP_EOL;
        exit(0);
    }else{
        $entityManager->remove($user);
        $entityManager->flush();
    }
    if (in_array('--json', $argv, true)) {
        echo json_encode($user, JSON_PRETTY_PRINT). PHP_EOL;
    }
    echo 'Delete user with the username ' . $userName . PHP_EOL;
} catch (Exception $exception) {

    echo $exception->getMessage() . PHP_EOL;
}