<?php

    class Note {

        // Member Variables

        protected $DateOfChange;
        protected $Author;
        protected $NameOfFile;
        protected $Note;

        // Member Functions

        public function InsertDataset() {           // Inserts data of current object into a TXT file.

            $NewDataset = fopen("Notes/$this->NameOfFile.txt", "w");
            fwrite($NewDataset, $this->DateOfChange."\n".$this->Author."\n".$this->Note);
            fclose($NewDataset);
        }

        public function DeleteDataset() {           // Deletes the TXT file with the name that was given to the object.

            if(file_exists("Notes\\$this->NameOfFile.txt")) {
                unlink("Notes\\$this->NameOfFile.txt");
            }
        }

        public function DeletePicture() {

            if(file_exists("Pictures\\$this->NameOfFile.jpg")) {
                unlink("Pictures\\$this->NameOfFile.jpg");
            }
        }

        public function OutputDataset() {           // Outputs a div with the contents of the object.

            echo '<div class="Note">';
            echo "<p class='NoteTitle'>$this->NameOfFile</p><p class='NoteAuthor'>Verfasst von: $this->Author</p><br>";
            echo "<p class='NoteText'>$this->Note</p><br>";
            if(file_exists("Pictures\\$this->NameOfFile.jpg")) {

                echo "<img src='Pictures\\$this->NameOfFile.jpg'><br><br>";
            }
            
            echo '<a class="LinkToEdit" href="NoteCreate.php?NoteToChange='.$this->NameOfFile.'">Bearbeiten</a>';
            echo '<a class="LinkToDelete" href="Index.php?NoteToDelete='.$this->NameOfFile.'">Löschen</a>';
            echo '</div>';
        }

            // Getter

            public function GetNote() {     // Returns Note.

                return $this->Note;
            }

            public function GetTitle() {    // Returns Title.

                return $this->NameOfFile;
            }

            public function GetAuthor() {   // Returns Author.

                return $this->Author;
            }

            // Protected Functions

            protected function GetCurrentDate() {   // Gets current date and returns it in format dd/MM//yyyy.

                $Date = getdate();
                $CurrentDate = $Date["mday"]."/".$Date["mon"]."/".$Date["year"] . " " . $Date["hours"].":".$Date["minutes"];
                return $CurrentDate;
            }

        // Constructor

        public function __construct($NameOfFile, $Author, $Note) {

            $this->NameOfFile = $NameOfFile;

            if(!empty($Note)) {     // If a second Parameter was given, he inserts the value of it to this.Note.

                $this->Note = $Note;
                $this->Author = $Author;
                $this->DateOfChange = $this->GetCurrentDate();
            }
            elseif(file_exists("Notes/$NameOfFile.txt")) {                  // If it doesn't have a second parameter given with it, we assume the note already exists.

                $FileRows = file("Notes/$NameOfFile.txt");
                
                $this->DateOfChange = trim(array_shift($FileRows));
                $this->Author = trim(array_shift($FileRows));
                $this->Note = trim(implode($FileRows));
            }
        }
    }
?>