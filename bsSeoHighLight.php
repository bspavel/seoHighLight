<?php
    $bs_referer = $_SERVER['HTTP_REFERER'];
    $bs_url = parse_url($bs_referer, PHP_URL_QUERY);
    parse_str($bs_url, $bs_param);
    if ( (strpos($bs_referer, 'google')) || (strpos($bs_referer, 'bing')) ):
        $phrase = $bs_param['q'];
    elseif( strpos($bs_referer, 'yandex') ):
        $phrase = $bs_param['text'];
    endif;
if( !empty($phrase) ):
    $phraseList=explode(' ',$phrase);
    foreach($phraseList as $val)
    {
        if ( (!empty($val)) && (strlen($val)>=3) )
        {
            $arr_new[]=$val;
        }
    }
    unset($phraseList);
    $phraseList=$arr_new;
    unset($arr_new);

    for
    (
	$sphln='',
	$phLen=sizeof($phraseList)-1,
	$i=0;
	$i<sizeof($phraseList);
	$i++
    )
    {
	$bs_end=($i<$phLen)?',':'';
	$sphln.="'".$phraseList[$i]."'"
	.$bs_end;
    }
endif;
if( (!empty($phraseList)) && (is_array($phraseList)) ):
?>
	<script>
	jQuery(document).ready(function ()
	{
		var phArr =[<?php echo $sphln; ?>];

		jQuery.each(phArr, function(index, phrase)
		{
		    //console.info(phrase);
		    jQuery(":contains("+phrase+")").not(":has(:contains("+phrase+"))").each(function (){var that = jQuery(this);var html = that.html();
		    html = html.replace(new RegExp(phrase, 'ig'),'<span style="background: yellow;">'+phrase+'</span>');that.html(html);});
		});

	});
	</script>
<?php
endif;
?>
