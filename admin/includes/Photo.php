<?php


class Photo extends Db_object
{
    // Aanmaken van de variabelen
    protected static $db_table = "photo";
    protected static $db_table_fields = array('tittle', 'description', 'filename', 'type', 'size');
    public $id;
    public $tittle;
    public $caption;
    public $description;
    public $filename;
    public $alternate_text;
    public $type;
    public $size;

    //Locatie properties om een afbeelding in te laden
    // Nodig om een foto even op te slaan in een temporary pad
    public $tmp_path;
    public $upload_directory = 'img';

    // Methode die de error zal opvangen
    public function set_file($file){
        if (empty($file) || !$file || !is_array($file)){
            $this->errors[] = "No file uploaded";
            return false;
        }elseif ($file['error'] != 0){
            $this->errors[]= $this->$this->upload_errors_array[$file['error']];
            return false;
        }  else{
            $this->filename = basename($file['name']);
            $this->tmp_path = $file['tmp_path'];
            $this->type = $file['type'];
            $this->size = $file['size'];
        }
    }
    // Save methode om de foto's op te laden naar de database
    public function save(){
        if($this->id){
            $this->update();
        }else{
            if (!empty($this->errors)){
                return false;
            }
            if (!empty($this->filename) || empty($this->tmp_path)){
                $this->errors[] = "File not available";
                return false;
            }
            $target_path = SITE_ROOT . DS . 'admin'. DS . $this->upload_directory . DS . $this->filename;
            if (file_exists($target_path)){
                $this->errors[] = "File {$this->filename} exists";
                return false;
            }
            if (move_uploaded_file($this->tmp_path, $target_path)){
                if ($this->create()){
                    unset($this->tmp_path);
                }
            }else{
                $this->errors[] = "This folder has no write rights";
                return false;
            }
        }
    }

    //Functie schrijven waar we een path maken om de locatie waar onze bestanden zijn opgeladen samen met de bestandsnaam weer te geven
    public function picture_path(){
        return $this->upload_directory . DS . $this->filename;
    }

    // delete foto function
    public function delete_photo(){
        if ($this->delete()){
            $target_path = SITE_ROOT . DS . 'admin' . DS . $this->picture_path();
            return unlink($target_path) ? true : false;
        }else{
            return false;
        }
    }
}