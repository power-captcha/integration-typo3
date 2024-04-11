# Einrichtung in Typo3 während der Entwicklung 
(solange noch nicht über Composer installierbar)

- Im Typo3 Hauptverzeichnis folgendes Verzeichnis anlegen:
`src/extensions/`

- Den Pfad in der composer.json von Typo3 als Repository hinterlegen
    ```
        "repositories": {
            "0_packages": {
                "type": "path",
                "url": "src/extensions/*"
            }
        }
    ```

- Das Git-Projekt in das angelegte Verzeichnis clonen
src/extensions/integration-typo3

- Die Extension in der composer.json von Typo3 als required hinterlegen
    ```
        "require": {
            [...]
            "power-captcha/integration-typo3": "@dev",
            [...]
        }
    ```
- Composer updaten
    ```
    composer update
    ```

# Quellen / ähnliche Projekte
Einrichtung einer Extension:
https://docs.typo3.org/m/typo3/reference-coreapi/main/en-us/ExtensionArchitecture/Tutorials/Kickstart/Make/Index.html

Form Element zu EXT:form hinzufügen:
https://gist.github.com/manuelselbach/dc63abd313694c594d480b163a5f3053

Form Element generator:
https://labor.99grad.de/typo3-tx_form-eigenes-formularelement-erstellen-custom-form-element/

FriendlyCaptcha:
https://github.com/studiomitte/friendlycaptcha-typo3/

CaptchaEU:
https://github.com/captcha-eu/typo3/
