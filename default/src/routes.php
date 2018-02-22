<?php

use Slim\Http\Request;
use Slim\Http\Response;
use simplon\entities\Person;
use simplon\dao\DaoPerson;

// Routes

// $app->get('/', function (Request $request, Response $response, array $args) {
//     $dao = new DaoPerson();
//     $pers = $dao->getAll();
    
//     // Render index view
//     return $this->view->render($response, 'index.twig', [
//         'pers' => $pers
//     ]);
// })->setName('index');

$app->map(['GET', 'POST'],'/', function (Request $request, Response $response, array $args) {
    // Sample log message
    // var_dump($request);
    $this->logger->info("Slim-Skeleton '/index' route");
    $parsedBody = $request->getParsedBody();
    $dao = new DaoPerson();

    if (isset($parsedBody['name'])) {
        $user = new Person($parsedBody['name'], new \DateTime($parsedBody['birthdate']), intval($parsedBody['gender']));
        $dao->add($user);
        $parsedBody['user'] = $user;
        $pers = $dao->getAll();
        $parsedBody['pers'] = $pers;
        return $this->view->render($response, 'index.twig', $parsedBody);
    
    } else {
        $pers = $dao->getAll();
        // Render index view
        return $this->view->render($response, 'index.twig', [
            'pers' => $pers
        ]);
    }
    // $parsedBody['isValide'] = ($parsedBody['email'] === "hichem@gmail.com" && $parsedBody['password'] ==="1234");
})->setName('index');

$app->get('/update/{id}', function (Request $request, Response $response, array $args) {
        
    $dao = new DaoPerson();
    // Render index view
    $pers = $dao->getById($args['id']);
    return $this->view->render($response, 'update.twig', [
        'pers' => $pers
    ]);
})->setName('update');

$app->post('/update/{id}', function (Request $request, Response $response, array $args) {
    
    $dao = new DaoPerson();
    $parsedBody = $request->getParsedBody();
    // Render index view
    $pers = $dao->getById($args['id']);
    $pers->setName($parsedBody['name']);
    $pers->setBirthdate(new \DateTime($parsedBody['birthdate']));
    $pers->setGender($parsedBody['gender']);
    
    $dao->update($pers);
    
    $pers = $dao->getAll();
    // Render index view
    return $response->withRedirect('/', 301);    
})->setName('update');

$app->get('/delete/{id}', function (Request $request, Response $response, array $args) {
    
    $dao = new DaoPerson();
    // Render index view
    $pers = $dao->getById($args['id']);
    
    $dao->delete($pers);

    return $response->withRedirect('/', 301);
})->setName('delete');
