<!DOCTYPE html>

<html lang="de">

    <!-- Head -->
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" type="text/css" href="cancer.css">
        <title>Change your Note! :D</title>
    </head>

    <!-- Body -->
    <body>
        <?php
            require_once 'ClassNote.php';

            if(!empty($_GET["Title"])) {

                $NoteToChange = new Note($_GET["Title"], "", "");

                session_start();
                $_SESSION["NoteObject"] = $NoteToChange;

                $Title = $NoteToChange->GetTitle();
                $Author = $NoteToChange->GetAuthor();

                echo "Titel: $Title<br>";
                echo "Autor: $Author<br><br>";
            }
        ?>
        <form action="Index.php" method="post">
            Notiz: <br><textarea name="ChangedNote" rows="5" cols="35"><?php 
                    $Note = $NoteToChange->GetNote();
                    echo "$Note";
                    ?></textarea><br><br>
            <input type="submit" >
        </form>
    </body>
</html>