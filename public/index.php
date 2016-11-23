<?php

use Http\Adapter\Guzzle6\Client;
use Spot\Config;
use Spot\Locator;

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server') {
    $path = realpath(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    if (__FILE__ !== $path && is_file($path)) {
        return false;
    }
    unset($path);
}

require_once(__DIR__ . '/../vendor/autoload.php');
Dotenv::load(__DIR__.'/../');

session_start();

$app = new \Slim\Slim([
    'templates.path' => __DIR__.'/../views',
    'debug'          => false
]);

$loader = new Twig_Loader_Filesystem(__DIR__ . '/../views');
$twig = new Twig_Environment($loader);


$cfg = new Config();
// MySQL
$cfg->addConnection('mysql', 'mysql://' . $_ENV['DATABASE_USER'] . ':' . $_ENV['DATABASE_PASSWORD'] . '@127.0.0.1/helpmeresume');
$spot = new Locator($cfg);

/** @var Greydnls\Entity\Mapper\Volunteer $volunteerMapper */
$volunteerMapper = $spot->mapper('Greydnls\Entity\Volunteer');

/** @var Greydnls\Entity\Mapper\Resume $resumeMapper */
$resumeMapper = $spot->mapper('Greydnls\Entity\Resume');

$app->notFound(function () use ($app) {
    $app->redirect('/error');
});

$app->get('/', function () use ($twig, $volunteerMapper) {
    $volunteers = $volunteerMapper->getForHomePage();

    echo $twig->render('index.php', ['volunteers' => $volunteers]);
});

$app->get('/volunteer', function () use ($twig) {
    echo $twig->render('volunteer.php');
});

$app->post('/submitVolunteer', function () use ($twig, $volunteerMapper) {
    $field_errors = $volunteerMapper->verifyFields();

    if (empty($field_errors)) {
        if ($volunteerMapper->findByEmail($_POST['email']) == 0) {
            try {
                $entity = $volunteerMapper->build([
                    'fullname'         => $_POST['name'],
                    'twitter_username' => $_POST['twitter'],
                    'github_username'  => $_POST['github'],
                    'email'            => $_POST['email'],
                ]);

                $volunteerMapper->save($entity);
                echo $twig->render('volunteer_thankyou.php');

            } catch (\Exception $e) {
                $error = "uh oh, something went wrong";

                echo $twig->render('volunteer.php', ['error' => $error]);
            }
        } else {
            if (empty($field_errors)) {
                echo $twig->render('volunteer.php', ['error' => "You're already signed up!"]);
            }
        }
    } else {
        $error = (!empty($field_error)) ? $field_error : "uh oh, something went wrong";

        echo $twig->render('volunteer.php', ['error' => $error]);
    }

});


$app->post('/submitResume', function () use ($twig, $resumeMapper, $volunteerMapper) {

    $field_errors = $resumeMapper->verifyFields();

    if (count($field_errors) == 0) {
        try {
            $resume = $resumeMapper->build([
                'fullname'  => $_POST['name'],
                'email'     => $_POST['email'],
                'link'      => $_POST['link'],
                'posting'   => $_POST['posting'],
            ]);
            $resumeMapper->save($resume);

            $recipients = $volunteerMapper->getAsCSV();
            $body = $resume->getHTML();

            $client = new Client();
            $mailgun = new \Mailgun\Mailgun($_ENV['MAILGUN_KEY'], $client);

            $message = [
                'html'    => $body,
                'subject' => 'Resume Submitted For Review by ' . $resume->fullname,
                'from'    => 'Help Me Resume <resume@helpmeresume.com>',
                'to'      => "resume@helpmeresume.com",
                'bcc' => $recipients
            ];

            $result = $mailgun->sendMessage("helpmeresume.com", $message);

        } catch (\Exception $e) {
            $error = (!empty($field_error)) ? $field_error : "uh oh, something went wrong";

            echo $twig->render('index.php', ['error' => $error]);
        }

        echo $twig->render('resume_thankyou.php');
    } else {
        $error = $field_errors['error'];

        echo $twig->render('resume_error.php', ['error' => $error]);
    }


});


$app->get('/error', function () {

});

$app->run();
