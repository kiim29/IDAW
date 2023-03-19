<html>
<?php
setcookie('css',$_GET['css']);

function generateHTMLHeadWithCSS($styl) {
    echo ('<head>
            <link rel="stylesheet" href="css/'.$styl.'.css">
        </head>');
}

if (isset($_COOKIE['css'])) {
    if ($_COOKIE['css']=='style2') {
        // echo 'style222';
        generateHTMLHeadWithCSS('style2');
    }
    else {
        // echo 'style111';
        generateHTMLHeadWithCSS('style1');
    }
}
else {
    // echo 'styledefault';
    generateHTMLHeadWithCSS('style1');
}
?>

<form id="style_form" action="index.php" method="GET">
    <select name="css">
        <option value="style1">style1</option>
        <option value="style2">style2</option>
    </select>
    <input type="submit" value="Appliquer" />
</form>
<p>Ceci est un paragraphe</p>
</html>