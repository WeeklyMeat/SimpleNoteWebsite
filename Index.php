<!DOCTYPE html>

<html lang="de">

    <!-- Head -->
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" type="text/css" href="cancer.css">
        <title>Happy Notes</title>
    </head>

    <!-- Body -->
    <body>

        <!-- PHP -->
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

        <!-- Actual Content -->
        <div class="Content">
            <!--Notes to Output come here-->
            <div class="Note">a</div>
            <div class="Note">a</div>
        </div>

        <!-- Footer -->
        <footer class="Footer">
            <form action="NoteCreate.php" method="post">
                <textarea name="NewNote" class="InputNewNote" placeholder="Make a Note :D" rows="2"></textarea>
                <input type="submit" class="Submit" value="Erstellen">
            </form>
        </footer>
    </body>
</html>