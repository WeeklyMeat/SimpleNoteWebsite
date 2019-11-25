<!DOCTYPE html>

<html lang="de">

    <!-- Head -->
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Main site</title>
        <style>body { background-color: #2E4053; color: white; }</style>
    </head>
    <body>
        <?php
            require_once 'ClassNote.php';

            if(!empty($_POST["ChangedNote"])) {

                $NewNote = trim($_POST["ChangedNote"]);

                session_start();
                $NoteToChange = $_SESSION["NoteObject"];
                session_destroy();

                $NoteToChange->ChangeDataset($NewNote);
            }
        ?>
    </body>
</html>