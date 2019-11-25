<!DOCTYPE html>

<html lang="de">

    <!-- Head -->
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Creating new note</title>
        <style>body { background-color: #2E4053; color: white; }</style>
    </head>

    <!-- Body -->
    <body>
        <form action="Index.php" method="post">
            
            Titel: <br><input type="text" name="Title" value="" required><br>
            Autor: <br><input type="text" name="Author" value="" required><br>
            Notiz: <br><textarea name="Note" rows="5" cols="35" required></textarea><br><br>
            <input type="submit">
        </form>
        <?php
            require_once 'ClassNote.php';

            if(!empty($_POST["Title"])) {

                $NewNote = new Note($_POST["Title"], $_POST["Note"], $_POST["Author"]);
                
                
                if(!empty($_POST["Note"]) && !empty($_POST["Author"])) {

                    $NewNote->InsertDataset();
                }
            }
        ?>
    </body>
</html>