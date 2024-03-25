<?php

declare(strict_types=1);

namespace Core\Utils;

class Upload
{
    /**
     * @param string $storeTo cesta kam bude obrázek uložen
     * @param string $inputName jméno file inputu ve formuláři
     * @return string|null cesta k uloženému souboru nebo null pokud uložení selže
     */
    public static function image(
        string $storeTo = 'Resources/Images/',
        string $inputName = 'image'
    ): string|null {
        if (isset($_FILES[$inputName])) {
            $storeFileName = $storeTo . $_FILES[$inputName]['name'];
            if (move_uploaded_file($_FILES[$inputName]['tmp_name'], __APP_ROOT__ . $storeFileName)) {
                return $storeFileName;
            }
        }

        return null;
    }
}