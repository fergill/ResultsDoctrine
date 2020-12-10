<?php

/**
 * PHP version 7.4
 * ResultsDoctrine - controllers.php
 *
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     http://www.etsisi.upm.es/ ETS de Ingeniería de Sistemas Informáticos
 */

use MiW\Results\Entity\User;
use MiW\Results\Entity\Result;
use MiW\Results\Utility\Utils;

function funcionHomePage()
{
    global $routes;

    $rutaListadoUsuarios = $routes->get('ruta_user_list')->getPath();
    $rutaListadoResultados = $routes->get('ruta_result_list')->getPath();
    echo <<< ____MARCA_FIN
    <ul>
        <li><a href="$rutaListadoUsuarios">Listado Usuarios</a></li>
        <li><a href="$rutaListadoResultados">Listado Resultados</a></li>
    </ul>
    <h4>Mostrar Usuario por Username</h4>
    <form method="post" action="/showuser">
        <input type="text" name="name" required>
    <button type="submit">Buscar</button>
    </form>
    <h4>Mostrar Resultado por ID</h4>
    <form method="post" action="/showresult">
       <input type="text" name="name" required>
    <button type="submit">Buscar</button>
    </form>
    <h4>Borrar Usuario por ID</h4>
    <form method="post" action="/deleteuser">
        <input type="text" name="name" required>
    <button type="submit">Borrar</button>
    </form>
    <h4>Borrar Resultado por ID</h4>
    <form method="post" action="/deleteresult">
        <input type="text" name="name" required>
        <button type="submit">Borrar</button>
    </form>
    <h4>Crear Nuevo Usuario</h4>
    <form method="POST" action="/createuser" enctype=”multipart/form-data”>
           Nombre de usuario: <input type="text" name="username" required><br>
           Email: <input type="email" name="email" required><br>
           Contraseña: <input type="password" name="password" required><br>
        <fieldset id="group1">
           <input type="radio" id="active" name="enabled" value="1">
           <label for="active">Activo</label><br>
           <input type="radio" id="inactive" name="enabled" value="0">
           <label for="inactive">Inactivo</label><br>
        </fieldset>
        <fieldset id="group2">
           <input type="radio" id="admin" name="admin" value="1">
           <label for="admin">Administrador</label><br>
           <input type="radio" id="user" name="admin" value="0">
           <label for="user">Usuario</label><br>
        </fieldset>       
        <button type="submit">Enviar</button> 
    </form>
    <h4>Crear Nuevo Resultado</h4>
    <form method="POST" action="/createresult" enctype=”multipart/form-data”>
         Result: <input type="number" name="result" required><br>
         User ID: <input type="number" name="userId" required><br>   
         <input type="submit" value="Enviar"> 
    </form>
    <h4>Actualizar Usuario</h4>
    <form method="POST" action="/updateuser" enctype=”multipart/form-data”>
           Nombre de usuario: <input type="text" name="username" required><br>
           Email: <input type="email" name="email" required><br>
           Contraseña: <input type="password" name="password" required><br>
        <fieldset id="group1">
           <input type="radio" id="active" name="enabled" value="1">
           <label for="active">Activo</label><br>
           <input type="radio" id="inactive" name="enabled" value="0">
           <label for="inactive">Inactivo</label><br>
        </fieldset>
        <fieldset id="group2">
           <input type="radio" id="admin" name="admin" value="1">
           <label for="admin">Administrador</label><br>
           <input type="radio" id="user" name="admin" value="0">
           <label for="user">Usuario</label><br>
        </fieldset>       
        <button type="submit">Enviar</button> 
    </form>
    <h4>Actualizar Resultado</h4>
    <form method="POST" action="/updateresult" enctype=”multipart/form-data”>
         Result: <input type="number" name="result" required><br>
         User ID: <input type="number" name="userId" required><br>   
         TimeStamp: <input type="date" name="timeStamp" ><br><br>
         <input type="submit" value="Enviar"> 
    </form>

____MARCA_FIN;
}

function funcionListadoUsuarios(): void
{
    $entityManager = Utils::getEntityManager();

    $userRepository = $entityManager->getRepository(User::class);
    $users = $userRepository->findAll();
    echo json_encode($users);
}

function funcionListadoResultados(): void
{
    $entityManager = Utils::getEntityManager();

    $resultRepository = $entityManager->getRepository(Result::class);
    $results = $resultRepository->findAll();
    echo json_encode($results);
}

function funcionMostrarUsuario()
{
    $entityManager = Utils::getEntityManager();
    $username = $_POST['name'];
    $userRepository = $entityManager->getRepository(User::class);
    $user = $userRepository->findOneBy(['username' => $username]);
    echo json_encode($user);
}

function funcionMostrarResultado()
{
    $entityManager = Utils::getEntityManager();
    $id = $_POST['name'];
    $resultRepository = $entityManager->getRepository(Result::class);
    $result = $resultRepository->find(['id' => $id]);
    echo json_encode($result);
}

function funcionBorrarUsuario()
{
    $entityManager = Utils::getEntityManager();
    $id = $_POST['name'];
    $userRepository = $entityManager->getRepository(User::class);
    $user = $userRepository->findOneBy(['id' => $id]);
    try {
        $entityManager->remove($user);
        $entityManager->flush();
        echo 'Borrado el usuario con id ' . $id . PHP_EOL;
    } catch (Exception $exception) {
        echo $exception->getMessage();
    }
}

function funcionBorrarResultado()
{
    $entityManager = Utils::getEntityManager();
    $id = $_POST['name'];
    $resultRepository = $entityManager->getRepository(Result::class);
    $result = $resultRepository->findOneBy(['id' => $id]);
    try {
        $entityManager->remove($result);
        $entityManager->flush();
        echo 'Borrado el resultado con id ' . $id . PHP_EOL;
    } catch (Exception $exception) {
        echo $exception->getMessage();
    }
}

function funcionCrearUsuario()
{
    $entityManager = Utils::getEntityManager();
    $username = (string) $_POST['username'];
    $email = (string) $_POST['email'];
    $password = (string) $_POST['password'];
    $enabled = (boolean) $_POST['enabled'];
    $admin = (boolean) $_POST['admin'];

    $userRepository = $entityManager->getRepository(User::class);

    $user = new User();
    $user->setUsername($username);
    $user->setEmail($email);
    $user->setPassword($password);
    $user->setEnabled($enabled);
    $user->setIsAdmin($admin);
    try {
        $entityManager->persist($user);
        $entityManager->flush();
        echo 'Creado el usuario con username ' . $username . PHP_EOL;
    } catch (Exception $exception) {
        echo $exception->getMessage();
    }
}

function funcionCrearResultado()
{
    $entityManager = Utils::getEntityManager();
    $resultado = $_POST['result'];
    $user = $_POST['userId'];
    $timestamp =  new DateTime('now');

    $user = $entityManager
        ->getRepository(User::class)
        ->findOneBy(['id' => $user]);
    if (null === $user) {
        echo "Usuario $user no encontrado" . PHP_EOL;
        exit(0);
    }

    $result = new Result($resultado, $user, $timestamp);

    try{
        $entityManager->persist($result);
        $entityManager->flush();
        echo 'Creado resultado con ID ' . $result->getId()
            . ' para el usuario ' . $user->getUsername() . PHP_EOL;
    } catch (Exception $exception) {
        echo $exception->getMessage();
    }
}

function funcionActualizarUsuario()
{
    $entityManager = Utils::getEntityManager();
    $username = (string) $_POST['username'];
    $email = (string) $_POST['email'];
    $password = (string) $_POST['password'];
    $enabled = (boolean) $_POST['enabled'];
    $admin = (boolean) $_POST['admin'];
    $userRepository = $entityManager->getRepository(User::class);
    $user = $userRepository->findOneBy(['username' => $username]);
    if (null === $user) {
        echo "Usuario con ID ' . $user . ' no encontrado" . PHP_EOL;
        exit(0);
    } else {
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword($password);
        $user->setEnabled($enabled);
        $user->setIsAdmin($admin);
    } try {
        $entityManager->persist($user);
        $entityManager->flush();
        echo "Actualizado el usuario con username $username" . PHP_EOL;
    } catch (Exception $exception) {
        echo $exception->getMessage();
    }
}

function funcionActualizarResultado()
{
    $entityManager = Utils::getEntityManager();

    $resultado = (int) $_POST['result'];
    $user = (int) $_POST['userId'];
    $timestamp = new DateTime($_POST['timeStamp']);

    $resultRepository = $entityManager->getRepository(Result::class);
    $result = $resultRepository->findOneBy(['user' => $user]);

    if (null === $result) {
        echo "Resultado con usuario $user no encontrado" . PHP_EOL;
        exit(0);
    } else {
        $result->setResult($resultado);
        $result->setTime($timestamp);
    } try {
        $entityManager->persist($result);
        $entityManager->flush();
        echo "Resultado con user: $user actualizado!";
    } catch (Exception $exception) {
        echo $exception->getMessage();
    }

}