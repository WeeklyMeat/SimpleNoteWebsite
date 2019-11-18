<!DOCTYPE html>

<html lang="de">

    <!-- Head -->
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Lehrer Registration</title>
        <style>body { background-color: #2E4053; color: white; }</style>
    </head>

    <!-- Body -->
    <body>

        <form action="Index.php" method="post">
            
            Titel: <br><input type="text" name="Title" value=""><br>
            Notiz: <br><textarea name="Note" rows="5" cols="35"></textarea><br><br>
            <input type="submit">
        </form>

        <?php
            require_once 'ClassNote.php';

            if(!empty(!empty($_POST["Title"]) && $_POST["Note"])) {

                $NewNote = new Note($_POST["Title"], $_POST["Note"]);
                $NewNote->InsertDataset();
            }
        ?>
    </body>
</html>