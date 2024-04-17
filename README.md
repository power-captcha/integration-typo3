# POWER CAPTCHA Integration for TYPO3

[POWER CAPTCHA](https://power-captcha.com/en/) protects your TYPO3 forms against bots and unauthorized persons. GDPR compliant!

This TYPO3 extension integrates [POWER CAPTCHA](https://power-captcha.com/en/) to EXT:form and EXT:powermail.


## Compability
Compatible TYPO3 versions:
- 11.5 LTS
- 12.4 LTS 

Compatible extensions:
- EXT:form
- EXT:powermail

## Installation via Composer
```console
composer require power-captcha/integration-typo3
```
## Configuration
- Get your API Key by selecting a plan under [POWER CAPTCHA](https://power-captcha.com/en/) and adding your domain in the [API Key Management](https://power-captcha.com/en/my-account/api-keys/)
- Setup your API Key and Secret Key to your TYPO3 Backend (`Site Management -> Sites -> Site Configuration -> POWER CAPTCHA`)
- Add a POWER CAPTCHA field to the TYPO3 form you want to protect.

## Credits
Inspired by the great TYPO3 extensions of [Studio Mitte](https://studiomitte.com). Find more extensions of Studio Mitte on their  [Website](https://www.studiomitte.com/loesungen/typo3) and [GitHub reposiotries](https://github.com/studiomitte).