<?php  


namespace App\Libraries;


class FileLibrary {

	private $path;
	private $size;
	private $mimeType;
	private $extension;
	private $name;
	private $randomName;
    private $folderName;
    private $file;
    private $bytes;

    private $year;
    private $month;



	public function getPath() {
        return $this->path;
    }

    public function setPath($path) {
        $this->path = $path;
    }

    public function getSize() {
        return $this->size;
    }

    public function setSize($size) {
        $this->size = $size;
    }

    public function getMimeType() {
        return $this->mimeType;
    }

    public function setMimeType($mimeType) {
        $this->mimeType = $mimeType;
    }

    public function getExtension() {
        return $this->extension;
    }

    public function setExtension($extension) {
        $this->extension = $extension;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getRandomName() {
        return $this->randomName;
    }

    public function setRandomName($randomName) {
        $this->randomName = $randomName;
    }

    public function getFolderName() {
        return $this->folderName;
    }

    public function setFolderName($folderName) {
        $this->folderName = $folderName;
    }

    public function getFile() {
        return $this->file;
    }

    public function setFile($file) {
        $this->file = $file;
    }

    public function getBytes() {
        return $this->bytes;
    }

    public function setBytes($bytes) {
        $this->bytes = $bytes;
    }

    public function getYear() {
        return $this->year;
    }

    public function setYear($year) {
        $this->year = $year;
    }

    public function getMonth() {
        return $this->month;
    }

    public function setMonth($month) {
        $this->month = $month;
    }


	public function read () {
		$file = new \CodeIgniter\Files\File($this->getPath());
		if(file_exists($file)) {
			$this->setSize($file->getSize());
			$this->setExtension($file->guessExtension());
			$this->setMimeType($file->getMimeType());
			$this->setName($file->getBasename());
			$this->setRandomName($file->getRandomName());
            $this->setFile($file);

            $this->readBytes($file);
		} 
	}

    public function readBytes ($file) {
        $fileOpen = fopen($file, 'r');
        $this->setBytes(fread($fileOpen, filesize($file)));
        fclose($fileOpen);
    }

    public function createFeauturedImageFolder () {
        $year = date('Y');
        $yearDir = 'FeaturedImage/' . $year;

        $month = date('m');
        $monthDir = $yearDir . '/' . $month;

        $unique = uniqid(true);
        $uniqueDir = $monthDir . '/' . $unique;

        $this->setFolderName($unique);
        $this->setYear($year);
        $this->setMonth($month);
        $this->setPath($uniqueDir . '/');
    }

    public function createProfilePictureFolder () {
        $year = date('Y');
        $yearDir = 'ProfilePicture/' . $year;

        $month = date('m');
        $monthDir = $yearDir . '/' . $month;

        $this->setFolderName($month);
        $this->setYear($year);
        $this->setMonth($month);
        $this->setPath($monthDir . '/');
    }

}









