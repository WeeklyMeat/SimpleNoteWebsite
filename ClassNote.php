<?php

    class Note {

        // Member Variables

        protected $DateOfChange;
        protected $NameOfFile;
        protected $Note;

        // Member Functions

        public function InsertDataset() {       // Inserts data of current object into a TXT file.

            $NewDataset = fopen("Notes/$this->NameOfFile.txt", "w");
            fwrite($NewDataset, $this->DateOfChange."\n".$this->Note);
            fclose($NewDataset);
        }

        public function DeleteDataset() {       // Deletes the TXT file with the name that was given to the object.

            unlink("Notes/$this->NameOfFile.txt");
        }

        public function OutputNoteToChange() {  // Outputs textarea with old note.

            $NoteToChange = $this->Note;
            echo "<textarea>".$NoteToChange."</textarea>";
        }

        public function ChangeDataset($NewNote) {   // TOOOOOOOOOOODOOOOOOOOOOOOOOOOOOOOOOO

            $this->Note = $NewNote;
            $this->DateOfChange = $this->GetCurrentDate();

            $this->DeleteDataset();
            $this->InsertDataset();
        }

            // Protected Functions

            protected function GetCurrentDate() {   // Gets current date and returns it in format dd/MM//yyyy.

                $Date = getdate();
                $CurrentDate = $Date["mday"] . "/" . $Date["mon"] . "/" . $Date["year"];
                return $CurrentDate;
            }

            protected function GetNote() {          // Gets content of file with the name of the object.

                $Note = file_get_contents("Notes/$this->NameOfFile.txt");
                return $Note;
            }

        // Constructors

        public function __construct($NameOfFile, $Note) {

            $this->DateOfChange = $this->GetCurrentDate();
            $this->NameOfFile = $NameOfFile;

            if(!empty($Note)) {     // If a second Parameter was given, he inserts the value of it to this.Note.

                $this->Note = $Note;
            }
            else {                  // If it doesn't have a second parameter given with it, we assume the note already exists.

                $this->Note = GetNote();
            }
        }
    }
?>