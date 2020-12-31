<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\DomainRecordNotFoundException;
use Exception;
use PDO;
use phpDocumentor\Reflection\Types\Collection;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use Respect\Validation\Validator;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

abstract class BaseController
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @var array
     */
    protected $args;

    /**
     * @var Twig
     */
    protected $twig;

    /**
     * @var PDO
     */
    protected $db;

    /**
     * @param LoggerInterface $logger
     * @param Twig            $twig
     * @param PDO             $pdo
     */
    public function __construct(LoggerInterface $logger, Twig $twig, PDO $pdo)
    {
        $this->logger = $logger;
        $this->twig   = $twig;
        $this->db     = $pdo;
    }


    /**
     * @param Request  $request
     * @param Response $response
     * @param array    $args
     * @return Response
     * @throws HttpNotFoundException
     * @throws HttpBadRequestException
     */
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $this->request  = $request;
        $this->response = $response;
        $this->args     = $args;

        $this->logger->error($request->getMethod());
        try {
            return $this->action();
        } catch (DomainRecordNotFoundException $e) {
            throw new HttpNotFoundException($this->request, $e->getMessage());
        }
    }

    /**
     * @return Response
     * @throws DomainRecordNotFoundException
     * @throws HttpBadRequestException
     */
    abstract protected function action(): Response;

    /**
     * @return array|object
     * @throws HttpBadRequestException
     */
    protected function getFormData()
    {
        $input = json_decode(file_get_contents('php://input'));

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new HttpBadRequestException($this->request, 'Malformed JSON input.');
        }

        return $input;
    }

    /**
     * @param string $name
     * @return mixed
     * @throws HttpBadRequestException
     */
    protected function resolveArg(string $name)
    {
        if (!isset($this->args[$name])) {
            throw new HttpBadRequestException($this->request, "Could not resolve argument `{$name}`.");
        }

        return $this->args[$name];
    }

    /**
     * @param array|object|null $data
     * @param int               $statusCode
     * @return Response
     */
    protected function successMessage($data = null, int $statusCode = 200): Response
    {
        return $this->respond($data)->withStatus($statusCode);
    }

    /**
     * @param $url
     * @return Response
     */
    protected function redirectTo($url): Response
    {
        $response = $this->response->withHeader('Location', $url);
        return $response->withStatus(301);
    }

    /**
     * @param array|object|null $message
     * @param array             $errors
     * @param int               $statusCode
     * @return Response
     */
    protected function errorMessage($message = null, $errors = [], int $statusCode = 400): Response
    {
        return $this->respond(['message' => $message, 'errors' => $errors])->withStatus($statusCode);
    }

    /**
     * @param  $payload
     * @return Response
     */
    protected function respond($payload): Response
    {
        $json = json_encode($payload, JSON_PRETTY_PRINT);
        $this->response->getBody()->write($json);

        return $this->response
            ->withHeader('Content-Type', 'application/json');
    }

    /**
     * @param string     $view
     * @param array|null $data
     * @return Response
     * @throws Exception
     */
    protected function view(string $view, array $data = null): Response
    {
        try {
            return $this->twig->render($this->response, $view, $data);
        } catch (LoaderError | RuntimeError | SyntaxError $e) {
            throw new Exception($this->request, $e->getMessage());
        }
    }
}
