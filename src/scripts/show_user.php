<?php

/**
 * PHP version 7.4
 * src/scripts/list_users.php
 *
 * @category Scripts
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://www.etsisi.upm.es/ ETS de Ingeniería de Sistemas Informáticos
 */

require dirname(__DIR__, 2) . '/vendor/autoload.php';

use MiW\Results\Entity\User;
use MiW\Results\Utility\Utils;

$entityManager = Utils::getEntityManager();

// Carga las variables de entorno
Utils::loadEnv(dirname(__DIR__, 2));

$username = $_POST['name'];
$userRepository = $entityManager->getRepository(User::class);
$user = $userRepository->findOneBy(['username' => $username]);


if ($argc <= 1) {
    echo "error en los parámetros";
    exit(0);
}



if (in_array('--json', $argv, true)) {
    echo json_encode($user, JSON_PRETTY_PRINT);
} else {
    echo PHP_EOL . sprintf(
            '  %2s: %20s %30s %7s' . PHP_EOL,
            $user->getId(),
            $user->getUsername(),
            $user->getEmail(),
            ($user->isEnabled()) ? 'true' : 'false'
        ),
        PHP_EOL;
}
