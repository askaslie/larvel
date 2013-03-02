<html>
    <body>
        <h1>Chegerap<h1>
            <p>When this baby hits 88 miles per hour,
                you gonna see some serious shit</p>
            <?
                foreach($test as $number) {
                    $number ++;
                    echo "<h{$number}>Тест</h{$number}>";
                }
            ?>
    </body>
</html>