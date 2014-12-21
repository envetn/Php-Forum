<?php
//fuck this shiot


?>

<script type="text/javascript">

	var image = new array("../userImg/Gallery/1/8870_2013-07-28_00002.png","../userImg/Gallery/1/8980_2014-01-14_00006.png","../userImg/Gallery/1/44350_2014-03-30_00001.png","49520_2014-01-13_00006.png");
	var image_number = 0;
	var image_length = image.length -1;
	
	function change_image(num)
	{
		image_number = image_number + num;
		if(image_number > image_length)
		{
			image_number = 0;
		}
		if(imager_number < 0 )
		{
			image_number = image_length;
		}
		document.slideshow_test.src = image[image_number];
		
		return false;
	}
</script>
<img src='../userImg/Gallery/1/8870_2013-07-28_00002.png' style='width:250px; height:250px;' name='slideshow'/>
	<table>
		<tr>
			<td align="left"> <a href="javascript.html" onclick="change_image(-1s)">previous</a></td>
			<td align="left"> <a href="javascript:change_image(1)">Next </a> </td>
		</tr>
	</table>
	
	
	
	<div id='description'>
		
	</div>