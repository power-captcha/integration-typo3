<?php

declare(strict_types=1);

namespace PowerCaptcha\Typo3\Service;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Log\LoggerInterface;
use PowerCaptcha\Typo3\Configuration;
use TYPO3\CMS\Core\Http\ServerRequest;

class TokenVerification {
    protected RequestFactoryInterface $factory;
    protected ClientInterface $client;
    protected LoggerInterface $logger;
    protected Configuration $configuration;

    public function __construct(
        RequestFactoryInterface $factory,
        ClientInterface $client,
        LoggerInterface $logger
    ) {
        $this->factory = $factory;
        $this->client = $client;
        $this->logger = $logger;
        $this->configuration = new Configuration();
    }

    public function verify(string $token = null, string $username = null) : VerificationResult {
        $result = new VerificationResult();

        if(!$this->configuration->isEnabled()) {
            $this->logger->error('Token verification is skipped due to missing configuration! Please configure EXT:power_captcha or remove the field from this form.');
            $result->setSuccess(true);
            return $result;
        }

        if(is_null($token)) {
            $token = $this->getTokenFromRequest();
            if(empty($token)) {
                $this->logger->error('Request does not contain a token field.');
                $result->setErrorCode(ErrorCode::NO_TOKEN_FIELD);
                return $result;
            }
        } else if(empty($token)) { 
            // token was passed as parameter
            $this->logger->warning('Could not verify token because it was empty.');
            $result->setErrorCode(ErrorCode::MISSING_TOKEN);
            return $result;
        }

        $this->logger->debug('Verifying token: '.$token);

        $requestBody = [
            'secret' => $this->configuration->getSecretKey(),
            'token' => $token,
            'clientUid' => $this->configuration->getClientUid(),
            'name' => $username ?? ''
        ];

        $requestOptions = [
            'headers' => [
                'Content-Type' => 'application/json',
                'Cache-Control' => 'no-cache',
                'X-API-Key' => $this->configuration->getApiKey()
            ],
            'allow_redirects' => true,
            'body' => json_encode($requestBody)
        ];
        
        try {
            $response = $this->client->request(
                'POST', 
                $this->configuration->getTokenVerificationUrl(),
                $requestOptions,
            );

            $responseBody = json_decode($response->getBody()->getContents(), true);
            if(isset($responseBody['success']) && boolval($responseBody['success'])) {
                $result->setSuccess(true);
                $this->logger->debug('Token successfully verified. Token: '.$token);
            } else {
                $result->setErrorCode(ErrorCode::TOKEN_NOT_VERIFIED);
                $this->logger->warning('Token was not verified. Token: '.$token);
            }

            return $result;
        } catch (ClientException $e) {
            $result->setErrorCode(ErrorCode::API_ERROR);
            if($e->getResponse()->getStatusCode() === 400) {
                // analyze error
                $errorBody = json_decode($e->getResponse()->getBody()->getContents(), true);
                if(is_array($errorBody['errors'])) {
                    if(in_array('MISSING_SECRET', $errorBody['errors']) || in_array('INVALID_SECRET', $errorBody['errors'])) {
                        $result->setErrorCode(ErrorCode::INVALID_SECRET);
                    } else {
                        $result->setErrorCode(ErrorCode::INVALID_TOKEN);
                    }
                }
            }
            $this->logger->error(
                'Could not verifiy token. ErrorCode: ' . $result->getErrorCode()->name . '. Exception Message: '. $e->getMessage()
            );
            return $result;
        } catch (GuzzleException $e) {
            $result->setErrorCode(ErrorCode::API_ERROR);
            $this->logger->error($e->getMessage());
            return $result;
        }
    }

    protected function getTokenFromRequest() : string {
        /** @var ServerRequest $request */
        $request = $GLOBALS['TYPO3_REQUEST'] ?? null;
        if (!$request) {
            return '';
        }
        return 
            $request->getParsedBody()[$this->configuration::TOKEN_FIELD_NAME] 
            ?? $request->getQueryParams()[$this->configuration::TOKEN_FIELD_NAME] 
            ?? '';
    }

}

enum ErrorCode : string {
    case NO_TOKEN_FIELD = 'message.error.no_token_field';
    case MISSING_TOKEN = 'message.error.missing_token';
    case TOKEN_NOT_VERIFIED = 'message.error.token_not_verified';
    case INVALID_SECRET = 'message.error.invalid_secret';
    case INVALID_TOKEN = 'message.error.invalid_token';
    case API_ERROR = 'message.error.api_error';
}

class VerificationResult {
    protected bool $success = false;
    protected ?ErrorCode $errorCode = null;

    public function __construct() {}

    public function isSuccess() : bool {
        return $this->success;
    }

    public function setSuccess(bool $success) : void {
        $this->success = $success;
    }

    public function getErrorCode() : ?ErrorCode {
        return $this->errorCode;
    }

    public function setErrorCode(ErrorCode $errorCode) : void {
        $this->errorCode = $errorCode;
    } 
}