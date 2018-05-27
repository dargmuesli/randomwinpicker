Param (
    [Parameter(Mandatory = $True)]
    [String] $Password
)

$RootCer = Join-Path -Path $PSScriptRoot -ChildPath "root.cer"
$RootCnf = Join-Path -Path $PSScriptRoot -ChildPath "root.cnf"
$RootKey = Join-Path -Path $PSScriptRoot -ChildPath "root.key"
$ServerCer = Join-Path -Path $PSScriptRoot -ChildPath "server.cer"
$ServerCnf = Join-Path -Path $PSScriptRoot -ChildPath "server.cnf"
$ServerCsr = Join-Path -Path $PSScriptRoot -ChildPath "server.csr"
$ServerKey = Join-Path -Path $PSScriptRoot -ChildPath "server.key"

Write-Host "Creating Root CA certificate & private key..." -ForegroundColor "Cyan"
openssl req -x509 -new -config $RootCnf -passout pass:$Password -out $RootCer -keyout $RootKey

Write-Host "Creating server certificate & private key..." -ForegroundColor "Cyan"
openssl req -nodes -new -config $ServerCnf -out $ServerCsr -keyout $ServerKey

Write-Host "Signing with Root CA..." -ForegroundColor "Cyan"
openssl x509 -req -in $ServerCsr -CA $RootCer -CAkey $RootKey -set_serial 123 -out $ServerCer -extfile $ServerCnf -extensions x509_ext -passin pass:$Password
