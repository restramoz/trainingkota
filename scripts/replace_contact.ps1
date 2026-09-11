Get-ChildItem -Path . -Recurse -Filter *.blade.php | ForEach-Object {
    $content = Get-Content $_.FullName -Raw
    $content = $content -replace 'https://wa.me/6281234567890', 'https://wa.me/{{ config(''contact.whatsapp'') }}'
    $content = $content -replace '\+62 812-3456-7890', '{{ config(''contact.display'') }}'
    $content = $content -replace '\+6281234567890', '+{{ config(''contact.whatsapp'') }}'
    $content = $content -replace '"telephone": "\+6281234567890"', '"telephone": "+{{ config(''contact.whatsapp'') }}"'
    Set-Content $_.FullName -Value $content
}