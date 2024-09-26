@echo off
setlocal enabledelayedexpansion

:: Nom du fichier de sortie
set output_file=extracted_text.txt

:: Extensions à traiter
set "extensions=php css js html"

:: Vider le fichier de sortie s'il existe déjà
echo. > %output_file%

:: Parcourir les fichiers ayant les extensions spécifiées
for %%e in (%extensions%) do (
    for /r %%f in (*%%e) do (
        echo Processing %%f >> %output_file%
        echo ====================== >> %output_file%
        type "%%f" >> %output_file%
        echo. >> %output_file%
        echo. >> %output_file%
    )
)

echo Extraction terminée. Texte extrait dans %output_file%.
pause
