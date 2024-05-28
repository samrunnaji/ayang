<?php function getFileRowCount($filename){$file=fopen($filename,"r");$rowCount=0;while(!feof($file)){fgets($file);$rowCount++;}fclose($file);return $rowCount;}if($_SERVER['REQUEST_METHOD']==='POST'){$listFile=isset($_POST['listFile'])?trim($_POST['listFile']):'';$urlsPerSitemap=isset($_POST['urlsPerSitemap'])?(int)$_POST['urlsPerSitemap']:0;if($listFile&&$urlsPerSitemap>0){$protocol=isset($_SERVER['HTTPS'])&&$_SERVER['HTTPS']==='on'?'https':'http';$fullUrl=$protocol."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];$parsedUrl=parse_url($fullUrl);$scheme=isset($parsedUrl['scheme'])?$parsedUrl['scheme']:'';$host=isset($parsedUrl['host'])?$parsedUrl['host']:'';$path=isset($parsedUrl['path'])?$parsedUrl['path']:'';$baseUrl=$scheme."://".$host.$path;$urlAsli=str_replace("genset.php","",$baseUrl);$judulFile=$listFile;$fileLines=file($judulFile,FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES);$totalCount=count($fileLines);$totalSitemaps=ceil($totalCount/$urlsPerSitemap);for($sitemapIndex=1;$sitemapIndex<=$totalSitemaps;$sitemapIndex++){$start=($sitemapIndex-1)*$urlsPerSitemap;$end=min($start+$urlsPerSitemap,$totalCount);$currentSitemap=fopen("sitemap{$sitemapIndex}.xml","w");fwrite($currentSitemap,'<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL);fwrite($currentSitemap,'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.PHP_EOL);for($index=$start;$index<$end;$index++){$judul=$fileLines[$index];$sitemapLink=$urlAsli.'?products='.urlencode($judul);fwrite($currentSitemap,'  <url>'.PHP_EOL);fwrite($currentSitemap,'    <loc>'.$sitemapLink.'</loc>'.PHP_EOL);fwrite($currentSitemap,'  </url>'.PHP_EOL);}fwrite($currentSitemap,'</urlset>'.PHP_EOL);fclose($currentSitemap);echo"Sitemap {$sitemapIndex} generated successfully.<br>";}}else{echo "Invalid input. Please provide a valid list file name and a positive number of URLs per sitemap.";}}else{ ?>

<!doctype html>
<html lang=en>
<head>
<meta charset=UTF-8>
<meta name=viewport content="width=device-width,initial-scale=1">
<title>Sitemap Generator</title>
<style>body{font-family:Arial,sans-serif;background-color:#f4f4f4;color:#333;margin:0;padding:0;box-sizing:border-box}.container{max-width:600px;margin:50px auto;padding:20px;background-color:#fff;box-shadow:0 0 10px rgba(0,0,0,.1);border-radius:5px}h2{text-align:center;color:#333}form{display:flex;flex-direction:column}label{margin-top:10px;font-size:16px;color:#333}input{padding:10px;margin-top:5px;border:1px solid #ccc;border-radius:4px;box-sizing:border-box;width:100%;font-size:14px}button{background-color:#007bff;color:#fff;padding:10px;border:none;border-radius:4px;cursor:pointer;font-size:16px;margin-top:10px}button:hover{background-color:#0056b3}</style>
</head>
<body>
<div class=container>
<h2>Sitemap Generator</h2>
<form method=post action=genset.php>
<label for=listFile>List File Name:</label>
<input id=listFile name=listFile required>
<br>
<label for=urlsPerSitemap>Number of URLs per Sitemap:</label>
<input type=number id=urlsPerSitemap name=urlsPerSitemap required min=1>
<br>
<button type=submit>Generate Sitemaps</button>
</form>
</div>
</body>
</html>


<?php } ?>
