<table  width="100%" style="border:none !important;">
<tbody>
<?php
if(count($countries)>0){
	$i=1;
 foreach ($countries as $country) {
?>


<tr>
<td>
<a href="javascript:void(0);" id="countrysearch<?=$i;?>" onclick="grabvalues('<?=$country->country_name?>','<?=$country->dial_code?>','<?=$country->country_code?>','<?=$country->id?>','<?=$parentname?>');"><?= $country->country_name?></a>
</td>
</tr>
<?php
$i++;
}
}
else echo "<p>No matched search</p>";
?>
</tbody>
</table>