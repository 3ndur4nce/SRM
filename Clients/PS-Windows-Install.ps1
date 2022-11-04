#Installation
$InstallationToken = ''
$BaseURL = ''
$Hostname = hostname
if(!(Test-Path HKLM:\SOFTWARE\SRM\)){
    $fullurl = "$BaseURL/inform/register/?hostname=$Hostname&do=newasset"
    $webClient = New-Object System.Net.WebClient
    $webClient.Headers.add('Authorization',$InstallationToken)
    $realtoken = $webClient.DownloadString($fullurl)
}
New-Item -Path HKLM:\SOFTWARE -Name SRM
New-ItemProperty -Path HKLM:\SOFTWARE\SRM -Name AssetToken -Value $realtoken
New-ItemProperty -Path HKLM:\SOFTWARE\SRM -Name MasterURL -Value $BaseURL

New-Item "C:\Windows\SRM" -Type Directory

$clientscript = "
add-content -Path C:\logs.txt -Value test
"

Set-Content -Path C:\Windows\SRM\client.ps1 -Value $clientscript

$account = Get-Credential

$Action = New-ScheduledTaskAction -Execute 'powershell.exe' -Argument '-NonInteractive -NoLogo -NoProfile -File "C:\Windows\SRM\client.ps1"'
$Trigger = New-ScheduledTaskTrigger -Once -At (Get-Date) -RepetitionInterval (New-TimeSpan -Minutes 5)
$Settings = New-ScheduledTaskSettingsSet
$Task = New-ScheduledTask -Action $Action -Trigger $Trigger -Settings $Settings
Register-ScheduledTask -TaskName 'SRM Poller' -InputObject $Task -User (Read-Host Username)

New-ItemProperty -Path HKLM:\SOFTWARE\SRM -Name ClientSetup -Value 1