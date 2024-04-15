<?php 

declare(strict_types=1);

namespace PowerCaptcha\Typo3\FormValidator;

use PowerCaptcha\Typo3\Service\TokenVerification;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

class FormValidator extends AbstractValidator {
    protected function isValid($value) : void {
        $tokenVerificationService = GeneralUtility::makeInstance(TokenVerification::class);
        $verificationResult = $tokenVerificationService->verify();
        
        if($verificationResult->isSuccess() === false) {
            $this->addError($this->translateErrorMessage('message.blocked', 'power_captcha'), 1713193899);
            
            if(!is_null($verificationResult->getErrorCode())) {
                $errorCodeMsgKey = $verificationResult->getErrorCode()->value;
                $this->addError($this->translateErrorMessage($errorCodeMsgKey, 'power_captcha'), 1713194073);
            }
        }
    }
}