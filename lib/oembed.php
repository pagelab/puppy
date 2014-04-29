<?php

/**
 * Various Custom oEmbed Codes
 *
*/

wp_embed_register_handler('redtube', '#http://(www\.)?redtube.com/[a-zA-Z0-9]+/?$#i', 'wp_redtube_embed_handler');

function wp_redtube_embed_handler( $matches, $attr, $url, $rawattr ) {
	$video = str_replace('/','',parse_url(esc_attr($matches[0]),PHP_URL_PATH));
	$embed = sprintf('<object height="'. AVO_HEIGHT . '" width="'. AVO_WIDTH . '"><param name="allowfullscreen" value="true"><param name="AllowScriptAccess" value="always"><param name="movie" value="http://embed.redtube.com/player/"><param name="FlashVars" value="id=%1$s&style=redtube&autostart=false"><embed src="http://embed.redtube.com/player/?id=%1$s&style=redtube" allowfullscreen="true" AllowScriptAccess="always" flashvars="autostart=false" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" height="'. AVO_HEIGHT . '" width="'. AVO_WIDTH . '" /></object>',$video);
	$embed = apply_filters( 'oembed_redtube', $embed, $matches, $attr, $url, $rawattr );
	return apply_filters( 'oembed_redtube', $embed, $url, '' );
}

wp_embed_register_handler('pornhub', '#http://(www\.)?pornhub.com/*#i', 'wp_pornhub_embed_handler');

function wp_pornhub_embed_handler( $matches, $attr, $url, $rawattr ) {
    	$video = str_replace('viewkey=','',parse_url($url,PHP_URL_QUERY));
	$embed = sprintf('<iframe src="http://www.pornhub.com/embed/%1$s" frameborder=0 height="'. AVO_HEIGHT . '" width="'. AVO_WIDTH . '" scrolling="no" name="ph_embed_video">',$video);
	$embed = apply_filters( 'oembed_pornhub', $embed, $matches, $attr, $url, $rawattr );
	return apply_filters( 'oembed_pornhub', $embed, $url, '' );
}

wp_embed_register_handler('keezmovies', '#http://(www\.)?keezmovies.com/*#i', 'wp_keezmovies_embed_handler');

function wp_keezmovies_embed_handler( $matches, $attr, $url, $rawattr ) {
	$video = str_replace('/video/','/embed/',$url);
	$embed = sprintf('<iframe src="%1$s" frameborder="0" height="'. AVO_HEIGHT . '" width="'. AVO_WIDTH . '" scrolling="no" name="keezmovies_embed_video"></iframe>',$video);
	$embed = apply_filters( 'oembed_keezmovies', $embed, $matches, $attr, $url, $rawattr );
	return apply_filters( 'oembed_keezmovies', $embed, $url, '' );
}

wp_embed_register_handler('xhamster', '#http://xhamster.com/*#i', 'wp_xhamster_embed_handler');

function wp_xhamster_embed_handler( $matches, $attr, $url, $rawattr ) {
	$video  = preg_split( '!/!u', $url );
	$embed = sprintf('<iframe width="'. AVO_WIDTH . '" height="'. AVO_HEIGHT . '" src="http://xhamster.com/xembed.php?video=%1$s" frameborder="0" scrolling="no"></iframe>',$video[4]);
	$embed = apply_filters( 'oembed_xhamster', $embed, $matches, $attr, $url, $rawattr );
	return apply_filters( 'oembed_xhamster', $embed, $url, '' );
}

wp_embed_register_handler('spankwire', '#http://(www\.)?spankwire.com/*#i', 'wp_spankwire_embed_handler');

function wp_spankwire_embed_handler( $matches, $attr, $url, $rawattr ) {
	$videoid  = preg_split( '!/!u', $url );
	$video = str_replace('video','',$videoid[4]);
	$embed = sprintf('<iframe src="http://www.spankwire.com/EmbedPlayer.aspx?ArticleId=%1$s" frameborder="0" height="'. AVO_HEIGHT . '" width="'. AVO_WIDTH . '" scrolling="no" name="spankwire_embed_video"></iframe>',$video);
	$embed = apply_filters( 'oembed_spankwire', $embed, $matches, $attr, $url, $rawattr );
	return apply_filters( 'oembed_spankwire', $embed, $url, '' );
}

wp_embed_register_handler('youjizz', '#http://(www\.)?youjizz.com/*#i', 'wp_youjizz_embed_handler');

function wp_youjizz_embed_handler( $matches, $attr, $url, $rawattr ) {
	preg_match('!\d+!', $url, $video);
	$embed = sprintf('<iframe src="http://www.youjizz.com/videos/embed/%1$s" frameborder="0" width="'. AVO_WIDTH . '" height="'. AVO_HEIGHT . '" scrolling="no" allowtransparency="true"></iframe>',$video[0]);
	$embed = apply_filters( 'oembed_youjizz', $embed, $matches, $attr, $url, $rawattr );
	return apply_filters( 'oembed_youjizz', $embed, $url, '' );
}

wp_embed_register_handler('mofosex', '#http://(www\.)?mofosex.com/*#i', 'wp_mofosex_embed_handler');

function wp_mofosex_embed_handler( $matches, $attr, $url, $rawattr ) {
	$video = preg_split( '!/!u', $url );
	$embed = sprintf('<iframe src="http://www.mofosex.com/embed?videoid=%1$s" frameborder="0" height="'. AVO_HEIGHT . '" width="'. AVO_WIDTH . '" scrolling="no" name="mofosex_embed_video"></iframe>',$video[4]);
	$embed = apply_filters( 'oembed_mofosex', $embed, $matches, $attr, $url, $rawattr );
	return apply_filters( 'oembed_mofosex', $embed, $url, '' );
}

wp_embed_register_handler('sexbot', '#http://(www\.)?sexbot.com/*#i', 'wp_sexbot_embed_handler');

function wp_sexbot_embed_handler( $matches, $attr, $url, $rawattr ) {
	$video = preg_split( '!/!u', $url );
	$embed = sprintf('<iframe src="http://www.sexbot.com/embed/%1$s" width="'. AVO_WIDTH . '" height="'. AVO_HEIGHT . '" style="overflow: hidden" frameborder="0" scrolling="no"></iframe>',$video[4]);	
	$embed = apply_filters( 'oembed_sexbot', $embed, $matches, $attr, $url, $rawattr );
	return apply_filters( 'oembed_sexbot', $embed, $url, '' );
}

wp_embed_register_handler('drtuber', '#http://(www\.)?drtuber.com/*#i', 'wp_drtuber_embed_handler');

function wp_drtuber_embed_handler( $matches, $attr, $url, $rawattr ) {
	$video = preg_split( '!/!u', $url );
	$embed = sprintf('<iframe src="http://www.drtuber.com/embed/%1$s" width="'. AVO_WIDTH . '" height="'. AVO_HEIGHT . '" frameborder="0" scrolling="no"></iframe>',$video[4]);
	$embed = apply_filters( 'oembed_drtuber', $embed, $matches, $attr, $url, $rawattr );
	return apply_filters( 'oembed_drtuber', $embed, $url, '' );
}

wp_embed_register_handler('hardsextube', '#http://(www\.)?hardsextube.com/*#i', 'wp_hardsextube_embed_handler');

function wp_hardsextube_embed_handler( $matches, $attr, $url, $rawattr ) {
	$video = preg_split( '!/!u', $url );
	$embed = sprintf('<object width="'. AVO_WIDTH . '" height="'. AVO_HEIGHT . '"> <param name="movie" value="http://www.hardsextube.com/embed/%1$s/"></param><param name="allowFullScreen" value="true"></param><param name="AllowScriptAccess" value="always"></param><param name="wmode" value="transparent"></param><embed src="http://www.hardsextube.com/embed/%1$s/" type="application/x-shockwave-flash" wmode="transparent" AllowScriptAccess="always" allowFullScreen="true" width="'. AVO_WIDTH . '" height="'. AVO_HEIGHT . '"></embed></object>',$video[4]);
	$embed = apply_filters( 'oembed_hardsextube', $embed, $matches, $attr, $url, $rawattr );
	return apply_filters( 'oembed_hardsextube', $embed, $url, '' );
}

wp_embed_register_handler('submityourflicks', '#http://(www\.)?submityourflicks.com/*#i', 'wp_submityourflicks_embed_handler');

function wp_submityourflicks_embed_handler( $matches, $attr, $url, $rawattr ) {
	$video = preg_split( '!/!u', $url );
	$embed = sprintf('<object type="application/x-shockwave-flash" data="http://www.submityourflicks.com/embedded/%1$s" width="'. AVO_WIDTH . '" height="'. AVO_HEIGHT . '"><param name="AllowScriptAccess" value="always"><param name="movie" value="http://www.submityourflicks.com/embedded/%1$s"></param><param name="wmode" value="transparent"></param><param name="allowfullscreen" value="true"></param><embed src="http://www.submityourflicks.com/embedded/%1$s" AllowScriptAccess="always" wmode="transparent" allowfullscreen="true" width="'. AVO_WIDTH . '" height="'. AVO_HEIGHT . '"></embed></object>',$video[4]);	
	$embed = apply_filters( 'oembed_submityourflicks', $embed, $matches, $attr, $url, $rawattr );
	return apply_filters( 'oembed_submityourflicks', $embed, $url, '' );
}

wp_embed_register_handler('cliphunter', '#http://(www\.)?cliphunter.com/*#i', 'wp_cliphunter_embed_handler');

function wp_cliphunter_embed_handler( $matches, $attr, $url, $rawattr ) {
	$video = preg_split( '!/!u', $url );
	$embed = sprintf('<iframe id="helpframe" src="http://www.cliphunter.com/embed/?id=%1$s" frameborder="0" scrolling="no" height="'. AVO_HEIGHT . '" width="'. AVO_WIDTH . '" frameborder="0"></iframe>',$video[4]);
	$embed = apply_filters( 'oembed_cliphunter', $embed, $matches, $attr, $url, $rawattr );
	return apply_filters( 'oembed_cliphunter', $embed, $url, '' );
}

wp_embed_register_handler('boysfood', '#http://(www\.)?boysfood.com/*#i', 'wp_boysfood_embed_handler');

function wp_boysfood_embed_handler( $matches, $attr, $url, $rawattr ) {
	$video = preg_split( '!/!u', $url );
	$embed = sprintf('<iframe src="http://www.boysfood.com/embed/%1$s/" width="'. AVO_WIDTH . '" height="'. AVO_HEIGHT . '" style="overflow: hidden" frameborder="0" scrolling="no"></iframe>',$video[4]);
	$embed = apply_filters( 'oembed_boysfood', $embed, $matches, $attr, $url, $rawattr );
	return apply_filters( 'oembed_boysfood', $embed, $url, '' );
}

wp_embed_register_handler('yobt', '#http://(www\.)?yobt.tv/*#i', 'wp_yobt_embed_handler');

function wp_yobt_embed_handler( $matches, $attr, $url, $rawattr ) {
	$video = preg_split( '!/!u', $url );
	$embed = sprintf('<iframe src="http://www.yobt.tv/embed/%1$s.html" width="'. AVO_WIDTH . '" height="'. AVO_HEIGHT . '" scrolling="no" frameborder="0" allowtransparency="true" marginheight="0" marginwidth="0"></iframe>',$video[4]);
	$embed = apply_filters( 'oembed_yobt', $embed, $matches, $attr, $url, $rawattr );
	return apply_filters( 'oembed_yobt', $embed, $url, '' );
}

wp_embed_register_handler('pornrabbit', '#http://(www\.)?pornrabbit.com/*#i', 'wp_pornrabbit_embed_handler');

function wp_pornrabbit_embed_handler( $matches, $attr, $url, $rawattr ) {
	$video = preg_split( '!/!u', $url );
	$embed = sprintf('<iframe src="http://www.pornrabbit.com/embed/%1$s/" width="'. AVO_WIDTH . '" height="'. AVO_HEIGHT . '" style="overflow: hidden" frameborder="0" scrolling="no"></iframe>',$video[4]);
	$embed = apply_filters( 'oembed_pornrabbit', $embed, $matches, $attr, $url, $rawattr );
	return apply_filters( 'oembed_pornrabbit', $embed, $url, '' );
}

wp_embed_register_handler('yobtcom', '#http://(www\.)?yobt.com/*#i', 'wp_yobtcom_embed_handler');

function wp_yobtcom_embed_handler( $matches, $attr, $url, $rawattr ) {
	$video = preg_split( '!/!u', $url );
	$embed = sprintf('<iframe src="http://www.yobt.com/embed/%1$s.html" width="'. AVO_WIDTH . '" height="'. AVO_HEIGHT . '" scrolling="no" frameborder="0" allowtransparency="true" marginheight="0" marginwidth="0"></iframe>',$video[4]);
	$embed = apply_filters( 'oembed_yobtcom', $embed, $matches, $attr, $url, $rawattr );
	return apply_filters( 'oembed_yobtcom', $embed, $url, '' );
}

wp_embed_register_handler('slutload', '#http://(www\.)?slutload.com/*#i', 'wp_slutload_embed_handler');

function wp_slutload_embed_handler( $matches, $attr, $url, $rawattr ) {
	$video = preg_split( '!/!u', $url );
	$embed = sprintf('<object type="application/x-shockwave-flash" data="http://emb.slutload.com/%1$s" width="'. AVO_WIDTH . '" height="'. AVO_HEIGHT . '"><param name="AllowScriptAccess" value="always"><param name="movie" value="http://emb.slutload.com/%1$s"></param><param name="allowfullscreen" value="true"></param><embed src="http://emb.slutload.com/%1$s" AllowScriptAccess="always" allowfullscreen="true" width="'. AVO_WIDTH . '" height="'. AVO_HEIGHT . '"></embed></object>',$video[4]);
	$embed = apply_filters( 'oembed_slutload', $embed, $matches, $attr, $url, $rawattr );
	return apply_filters( 'oembed_slutload', $embed, $url, '' );
}

wp_embed_register_handler('vporn', '#http://(www\.)?vporn.com/*#i', 'wp_vporn_embed_handler');

function wp_vporn_embed_handler( $matches, $attr, $url, $rawattr ) {
	$video = preg_split( '!/!u', $url );
	$embed = sprintf('<object width="'. AVO_WIDTH . '" height="'. AVO_HEIGHT . '"><param name="movie" value="http://www.vporn.com/swf/player_embed.swf"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><param name="flashvars" value="videoID=%1$s"></param><embed src="http://www.vporn.com/swf/player_embed.swf" type="application/x-shockwave-flash" width="'. AVO_WIDTH . '" height="'. AVO_HEIGHT . '" allowscriptaccess="always" allowfullscreen="true" flashvars="videoID=%1$s"></embed></object>',$video[5]);
	$embed = apply_filters( 'oembed_vporn', $embed, $matches, $attr, $url, $rawattr );
	return apply_filters( 'oembed_vporn', $embed, $url, '' );
}

wp_embed_register_handler('jizzbo', '#http://(www\.)?jizzbo.com/*#i', 'wp_jizzbo_embed_handler');

function wp_jizzbo_embed_handler( $matches, $attr, $url, $rawattr ) {
	preg_match('!\d+!', $url, $video);
	$embed = sprintf('<iframe src="http://www.jizzbo.com/videos/embed/%1$s" frameborder="0" width="'. AVO_WIDTH . '" height="'. AVO_HEIGHT . '" scrolling="no" allowtransparency="true"></iframe>',$video[0]);
	$embed = apply_filters( 'oembed_jizzbo', $embed, $matches, $attr, $url, $rawattr );
	return apply_filters( 'oembed_jizzbo', $embed, $url, '' );
}

wp_embed_register_handler('empflix', '#http://(www\.)?empflix.com/*#i', 'wp_empflix_embed_handler');

function wp_empflix_embed_handler( $matches, $attr, $url, $rawattr ) {
	preg_match('!\d+!', $url, $video);
	$embed = sprintf('<iframe src="http://player.empflix.com/video/%1$s" width="'. AVO_WIDTH . '" height="'. AVO_HEIGHT . '" frameborder="0"></iframe>',$video[0]);
	$embed = apply_filters( 'oembed_empflix', $embed, $matches, $attr, $url, $rawattr );
	return apply_filters( 'oembed_empflix', $embed, $url, '' );
}

wp_embed_register_handler('moviesguy', '#http://(www\.)?moviesguy.com/*#i', 'wp_moviesguy_embed_handler');

function wp_moviesguy_embed_handler( $matches, $attr, $url, $rawattr ) {
	preg_match('!\d+!', $url, $video);
	$embed = sprintf('<iframe src="http://www.moviesguy.com/videos/embed/%1$s" frameborder="0" width="'. AVO_WIDTH . '" height="'. AVO_HEIGHT . '" scrolling="no" allowtransparency="true"></iframe>',$video[0]);
	$embed = apply_filters( 'oembed_moviesguy', $embed, $matches, $attr, $url, $rawattr );
	return apply_filters( 'oembed_moviesguy', $embed, $url, '' );
}

wp_embed_register_handler('porn', '#http://(www\.)?porn.com/*#i', 'wp_porn_embed_handler');

function wp_porn_embed_handler( $matches, $attr, $url, $rawattr ) {
	preg_match('!\d+!', $url, $video);
	$embed = sprintf('<iframe scrolling="no" width="'. AVO_WIDTH . '" height="'. AVO_HEIGHT . '" src="http://www.porn.com/videos/embed/%1$s" frameborder="0"></iframe>',$video[0]);
	$embed = apply_filters( 'oembed_porn', $embed, $matches, $attr, $url, $rawattr );
	return apply_filters( 'oembed_porn', $embed, $url, '' );
}

wp_embed_register_handler('nuvid', '#http://(www\.)?nuvid.com/*#i', 'wp_nuvid_embed_handler');

function wp_nuvid_embed_handler( $matches, $attr, $url, $rawattr ) {
	$video = preg_split( '!/!u', $url );
	$embed = sprintf('<iframe src="http://nuvid.com/embed/%1$s" width="'. AVO_WIDTH . '" height="'. AVO_HEIGHT . '" frameborder="0" scrolling="no"></iframe>',$video[4]);
	$embed = apply_filters( 'oembed_nuvid', $embed, $matches, $attr, $url, $rawattr );
	return apply_filters( 'oembed_nuvid', $embed, $url, '' );
}

wp_embed_register_handler('xvideos', '#http://(www\.)?xvideos.com/*#i', 'wp_xvideos_embed_handler');

function wp_xvideos_embed_handler( $matches, $attr, $url, $rawattr ) {
	$videoid = preg_split( '!/!u', $url );
	$video = str_replace('video','',$videoid[3]);
	$embed = sprintf('<iframe src="http://flashservice.xvideos.com/embedframe/%1$s" frameborder=0 width="'. AVO_WIDTH . '" height="'. AVO_HEIGHT . '" scrolling="no"></iframe>',$video);
	$embed = apply_filters( 'oembed_xvideos', $embed, $matches, $attr, $url, $rawattr );
	return apply_filters( 'oembed_xvideos', $embed, $url, '' );
}

wp_embed_register_handler('tube8', '#http://(www\.)?tube8.com/*#i', 'wp_tube8_embed_handler');

function wp_tube8_embed_handler( $matches, $attr, $url, $rawattr ) {
	$parts = parse_url($url);
	$video = $parts[scheme] . '://' . $parts[host] . '/embed' . $parts[path];
	$embed = sprintf('<iframe src="%1$s" frameborder="0" height="'. AVO_HEIGHT . '" width="'. AVO_WIDTH . '" scrolling="no" name="t8_embed_video"></iframe>',$video);
	$embed = apply_filters( 'oembed_tube8', $embed, $matches, $attr, $url, $rawattr );
	return apply_filters( 'oembed_tube8', $embed, $url, '' );
}

wp_embed_register_handler('youporn', '#http://(www\.)?youporn.com/*#i', 'wp_youporn_embed_handler');

function wp_youporn_embed_handler( $matches, $attr, $url, $rawattr ) {
	$video = str_replace('/watch/','/embed/',$url);
	$embed = sprintf('<iframe src="%1$s" frameborder="0" height="'. AVO_HEIGHT . '" width="'. AVO_WIDTH . '" scrolling="no" name="yp_embed_video"></iframe>',$video);
	$embed = apply_filters( 'oembed_youporn', $embed, $matches, $attr, $url, $rawattr );
	return apply_filters( 'oembed_youporn', $embed, $url, '' );
}

wp_embed_register_handler('sunporno', '#http://(www\.)?sunporno.com/*#i', 'wp_sunporno_embed_handler');

function wp_sunporno_embed_handler( $matches, $attr, $url, $rawattr ) {
	$video = preg_split( '!/!u', $url );
	$embed = sprintf('<iframe src="http://embeds.sunporno.com/embed/%1$s" frameborder=0 width="'. AVO_WIDTH . '" height="'. AVO_HEIGHT . '" scrolling="no"></iframe>',$video[4]);
	$embed = apply_filters( 'oembed_sunporno', $embed, $matches, $attr, $url, $rawattr );
	return apply_filters( 'oembed_sunporno', $embed, $url, '' );
}

wp_embed_register_handler('freeporn', '#http://(www\.)?freeporn.com/*#i', 'wp_freeporn_embed_handler');

function wp_freeporn_embed_handler( $matches, $attr, $url, $rawattr ) {
	preg_match('!\d+!', $url, $video);
	$embed = sprintf('<iframe src="http://www.freeporn.com/embed/%1$s/" width="'. AVO_WIDTH . '" height="'. AVO_HEIGHT . '" style="overflow: hidden" frameborder="0" scrolling="no"></iframe>',$video[0]);
	$embed = apply_filters( 'oembed_freeporn', $embed, $matches, $attr, $url, $rawattr );
	return apply_filters( 'oembed_freeporn', $embed, $url, '' );
}

wp_embed_register_handler('tnaflix', '#http://(www\.)?tnaflix.com/*#i', 'wp_tnaflix_embed_handler');

function wp_tnaflix_embed_handler( $matches, $attr, $url, $rawattr ) {
	$video = str_replace('video','', preg_split( '!/!u', $url ));
	$embed = sprintf('<iframe src="http://player.tnaflix.com/video/%1$s" frameborder="0" width="'. AVO_WIDTH . '" height="'. AVO_HEIGHT . '"></iframe>',$video[5]);
	$embed = apply_filters( 'oembed_tnaflix', $embed, $matches, $attr, $url, $rawattr );
	return apply_filters( 'oembed_tnaflix', $embed, $url, '' );
}

wp_embed_register_handler('madthumbs', '#http://(www\.)?madthumbs.com/*#i', 'wp_madthumbs_embed_handler');

function wp_madthumbs_embed_handler( $matches, $attr, $url, $rawattr ) {
	$video = preg_split( '!/!u', $url );
	$videourl = 'config=http://www.madthumbs.com/videos/embed_config?id='. $video[6];
	$embed = '<object type="application/x-shockwave-flash" data="http://cache.tgpsitecentral.com/madthumbs/js/flowplayer/flowplayer.embed-3.2.6-dev.swf" width="'. AVO_WIDTH . '" height="'. AVO_HEIGHT . '"><param name="movie" value="http://cache.tgpsitecentral.com/madthumbs/js/flowplayer/flowplayer.embed-3.2.6-dev.swf"><param value="true" name="allowfullscreen"><param value="always" name="allowscriptaccess"><param value="high" name="quality"><param value="#000000" name="bgcolor"><param value="'.$videourl.'" name="flashvars"></object>';
	$embed = apply_filters( 'oembed_madthumbs', $embed, $matches, $attr, $url, $rawattr );
	return apply_filters( 'oembed_madthumbs', $embed, $url, '' );
}

wp_embed_register_handler('bigtits', '#http://(www\.)?bigtits.com/*#i', 'wp_bigtits_embed_handler');

function wp_bigtits_embed_handler( $matches, $attr, $url, $rawattr ) {
	$video = preg_split( '!/!u', $url );
	$videourl = 'config=http://www.bigtits.com/videos/embed_config?id='. $video[6];
	$embed = '<object id="BigTitsPlayer" width="'. AVO_WIDTH . '" height="'. AVO_HEIGHT . '" type="application/x-shockwave-flash" data="http://www.bigtits.com/js/flowplayer/flowplayer.embed-3.2.6-dev.swf"><param value="true" name="allowfullscreen"/><param value="always" name="allowscriptaccess"/><param value="high" name="quality"/><param value="#000000" name="bgcolor"/><param name="movie" value="http://www.bigtits.com/js/flowplayer/flowplayer.embed-3.2.6-dev.swf" /><param value="'.$videourl.'" name="flashvars"/></object>';
	$embed = apply_filters( 'oembed_bigtits', $embed, $matches, $attr, $url, $rawattr );
	return apply_filters( 'oembed_bigtits', $embed, $url, '' );
}

