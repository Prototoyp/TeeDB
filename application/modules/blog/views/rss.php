<?php echo '<?xml version="1.0" encoding="utf-8" ?>'."\n"; ?>
<rss version="2.0"
    xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
    xmlns:admin="http://webns.net/mvcb/"
    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
    xmlns:content="http://purl.org/rss/1.0/modules/content/">

    <channel>
    
	    <title><?php echo $feed_name; ?></title>
	
	    <link><?php echo $feed_url; ?></link>
	    <description><?php echo $page_description; ?></description>
	    <dc:language><?php echo $page_language; ?></dc:language>
	
	    <dc:rights>Copyright <?php echo gmdate("Y", time()); ?></dc:rights>
	    <admin:generatorAgent rdf:resource="http://www.codeigniter.com/" />
	
	    <?php foreach($news as $entry): ?>
			<item>
				<title><?php echo xml_convert($entry->title); ?></title>
	          	<link><?php echo site_url('blog/news/title/' . $entry->url_title) ?></link>
	          	<guid><?php echo site_url('blog/news/title/' . $entry->url_title) ?></guid>
	
	          	<description><![CDATA[
	      			<?php echo $entry->content; ?>
	      		]]></description>
	      		<pubDate><?php echo date ('r', human_to_unix($entry->create));?></pubDate>
	        </item> 
	    <?php endforeach; ?>
    
    </channel>
</rss>  