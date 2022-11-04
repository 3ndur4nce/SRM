$logfile = "C:\Windows\SRM\SRM.log"
$BaseURL = Get-ItemPropertyValue -Path HKLM:\SOFTWARE\SRM -Name MasterURL
$Secret = Get-ItemPropertyValue -Path HKLM:\SOFTWARE\SRM -Name AssetToken
$Hostname = hostname

$fullurl = "$BaseURL/inform/poll/?hostname=$Hostname"
$webClient = New-Object System.Net.WebClient
$webClient.Headers.add('Authorization',$Secret)
$pollanswer = $webClient.DownloadString($fullurl)

if($pollanswer -eq 0){
    $now = (get-date).tostring("yyyy-MM-dd HH:mm:ss")
    Add-Content $logfile "$now - Master has no tasks"
}else{
    $fullurl = "$BaseURL/inform/run/?hostname=$Hostname&schedid=$pollanswer"
    $webClient = New-Object System.Net.WebClient
    $webClient.Headers.add('Authorization',$Secret)
    $rawscript = $webClient.DownloadString($fullurl)

    $shell = ($rawscript -split '\:' ,2)[0]
    $script = ($rawscript -split '\:' ,2)[1]

    if($shell -eq "cmd"){
        set-content -Path C:\Windows\SRM\run.cmd -Value $script
        $output = & C:\Windows\SRM\run.cmd
    }elseif($shell -eq "powershell"){
        set-content -Path C:\Windows\SRM\run.ps1 -Value $script
        $output = & C:\Windows\SRM\run.ps1
    }else{
        $now = (get-date).tostring("yyyy-MM-dd HH:mm:ss")
        $output = "Cannot run $shell script"
        Add-Content -Path $logfile "$now - $output"
    }
    $URL = "$BaseURL/inform/return/?hostname=$Hostname&schedid=$pollanswer"
	$wc = new-object net.WebClient
	$wc.Headers.Add("Content-Type", "application/x-www-form-urlencoded")
	$wc.Headers.Add("User-Agent", "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; Trident/4.0; SLCC2; .NET CLR 2.0.50727)")
	$wc.Headers.Add("Authorization", $Secret)
    $wc.UseDefaultCredentials = $true

	$NVC = New-Object System.Collections.Specialized.NameValueCollection
	$NVC.Add("__VIEWSTATE", $viewstate);
	$NVC.Add("__EVENTVALIDATION", $eventvalidation);
	$NVC.Add("status", "complete");
	$NVC.Add("output", $output);
	$NVC.Add("ctl00`$MainContent`$Submit", "Submit");
	$wc.QueryString = $NVC
	$Result = $WC.UploadValues($URL,"POST", $NVC)
	$readableoutput = [System.Text.Encoding]::UTF8.GetString($Result)
	$WC.Dispose();
}