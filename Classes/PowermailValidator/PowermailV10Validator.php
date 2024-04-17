<?php

declare(strict_types=1);

namespace PowerCaptcha\Typo3\PowermailValidator;

use PowerCaptcha\Typo3\Service\TokenVerification;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Error\Error;
use TYPO3\CMS\Extbase\Error\Result;

class PowermailV10Validator extends AbstractPowermailValidator
{
    /**
     * @param Mail $mail
     * @return Result
     */
    public function validate($mail) : Result {
        $result = new Result();
        if ($this->skipPowerCaptchaValidation($mail)) {
            return $result;
        }

        $tokenVerificationService = GeneralUtility::makeInstance(TokenVerification::class);
        $verificationResult = $tokenVerificationService->verify();

        if ($verificationResult->isSuccess() === false) {
            $lll = 'LLL:EXT:power_captcha/Resources/Private/Language/locallang.xlf:';

            $result->addError(
                new Error(
                    $this->getLanguageService()->sL($lll.'message.blocked'),
                    1713271307
                )
            );

            if(!is_null($verificationResult->getErrorCode())) {
                $errorCodeMsgKey = $verificationResult->getErrorCode()->value;
                $result->addError(
                    new Error(
                        $this->getLanguageService()->sL($lll.$errorCodeMsgKey),
                        1713271395
                    )
                );
            }
        }

        return $result;
    }

    public function isValid(mixed $mail) : void {
        return;
    }

    private function getLanguageService() : LanguageService {
        return $GLOBALS['LANG'];
    }
}