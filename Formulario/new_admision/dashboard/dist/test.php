<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
</head>
<body>
<p>First Paragraph</p>
<p>Second Paragraph</p>
<p>Yet one more Paragraph</p>
 

<script src="js/jquery-3.5.1.min.js"></script>
<script>
$( document ).ready(function() {
    console.log( "ready!" );
    $( "p" ).click(function() {
        $( this ).slideUp();
    });
});
</script>

    
</body>
</html>