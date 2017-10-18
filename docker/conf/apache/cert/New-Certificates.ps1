Param (
    [Parameter(Mandatory = $True)]
    [String] $Password
)

Write-Host "Creating Root CA certificate & private key..." -ForegroundColor "Cyan"
openssl req -x509 -new -config $PSScriptRoot\root.cnf -passout pass:$Password -out $PSScriptRoot\root.cer -keyout $PSScriptRoot\root.key

Write-Host "Creating server certificate & private key..." -ForegroundColor "Cyan"
openssl req -nodes -new -config $PSScriptRoot\server.cnf -out $PSScriptRoot\server.csr -keyout $PSScriptRoot\server.key

Write-Host "Signing with Root CA..." -ForegroundColor "Cyan"
openssl x509 -req -in $PSScriptRoot\server.csr -CA $PSScriptRoot\root.cer -CAkey $PSScriptRoot\root.key -set_serial 123 -out $PSScriptRoot\server.cer -extfile $PSScriptRoot\server.cnf -extensions x509_ext -passin pass:$Password
