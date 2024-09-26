@echo off
setlocal enabledelayedexpansion

:: Nom du fichier de sortie
set output_file=extracted_textv2.txt

:: Extensions à traiter
set "extensions=php css js html"

:: Dossier à ignorer
set ignore_folder=phpmailer

:: Vider le fichier de sortie s'il existe déjà
echo. > %output_file%

:: Parcourir les fichiers ayant les extensions spécifiées
for %%e in (%extensions%) do (
    for /r %%f in (*%%e) do (
        :: Vérifier si le fichier se trouve dans le dossier à ignorer
        echo %%f | findstr /i "%ignore_folder%" >nul
        if errorlevel 1 (
            echo Processing %%f >> %output_file%
            echo ====================== >> %output_file%
            type "%%f" >> %output_file%
            echo. >> %output_file%
            echo. >> %output_file%
        ) else (
            echo Ignoring %%f
        )
    )
)

echo Extraction terminée. Texte extrait dans %output_file%.
pause
