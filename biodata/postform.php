<script LANGUAGE="JavaScript">window.opener.location.reload();


</script>
<?

include("config.inc");
$link=mysql_connect($server,$user,$pass);

switch($do)
{
	case "editbiodatadataprofesi"	:
		
		if ($simpan)
		{
			for ($i=1;$i<=$jmlloop;$i++)
			{
				if (strlen(ereg_replace(" ","",$PR_03[$i])) > 0)
				{
					if ($updated[$i]=='1')
						mysql_query("update pupns.MSTPROF1 set PR_03=UCASE('$PR_03[$i]'), PR_04='$PR_04[$i]' where PR_01='$NIP' and PR_02='$PR_02[$i]'") or die (mysql_error());
					else if ($updated[$i]=='0')
						mysql_query("insert into pupns.MSTPROF1 set PR_01='$NIP', PR_03=UCASE('$PR_03[$i]'), PR_04='$PR_04[$i]'") or die (mysql_error());
				}
			}
		};
		break;
}

?>