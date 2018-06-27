Param (
    [Parameter(Mandatory = $True)]
    [String] $Password
)

$RootCrt = Join-Path -Path $PSScriptRoot -ChildPath "root.crt"
$RootCnf = Join-Path -Path $PSScriptRoot -ChildPath "root.cnf"
$RootKey = Join-Path -Path $PSScriptRoot -ChildPath "root.key"
$ServerCrt = Join-Path -Path $PSScriptRoot -ChildPath "server.crt"
$ServerCnf = Join-Path -Path $PSScriptRoot -ChildPath "server.cnf"
$ServerCsr = Join-Path -Path $PSScriptRoot -ChildPath "server.csr"
$ServerKey = Join-Path -Path $PSScriptRoot -ChildPath "server.key"

Write-Host "Creating Root CA certificate & private key..." -ForegroundColor "Cyan"
openssl req -x509 -new -config $RootCnf -passout pass:$Password -out $RootCrt -keyout $RootKey

Write-Host "Creating server certificate & private key..." -ForegroundColor "Cyan"
openssl req -nodes -new -config $ServerCnf -out $ServerCsr -keyout $ServerKey

Write-Host "Signing with Root CA..." -ForegroundColor "Cyan"
openssl x509 -req -in $ServerCsr -CA $RootCrt -CAkey $RootKey -set_serial 123 -out $ServerCrt -extfile $ServerCnf -extensions x509_ext -passin pass:$Password
