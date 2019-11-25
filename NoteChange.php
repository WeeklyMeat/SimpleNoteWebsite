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
            
            Titel: <br><input type="text" name="Title" value=""><br>
            Autor: <br><input type="text" name="Author" value=""><br>
            Notiz: <br><textarea name="Note" rows="5" cols="35"></textarea><br><br>
            <input type="submit">
        </form>

        <?php
            require_once 'ClassNote.php';

            if(!empty($_GET["Title"])) {

                $NoteToChange = new Note($_GET["Title"], "", "");

                echo "Titel: $NoteToChange->NameOfFile<br>";
                echo "Autor: $NoteToChange->Author<br>";
                
            }
        ?>
    </body>
</html>