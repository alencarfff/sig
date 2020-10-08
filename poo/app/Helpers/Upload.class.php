<?php

/**
 * Upload.class [ HELPER ]
 * class responsável em fazer a gestão de upload do sistema. 
 * @copyright (c) 2014, Fabio Augusto CASA DOS SITES
 */
class Upload {

    private $File;
    private $Name;
    private $Send;

    /** IAMGEM UPLOAD */
    private $Width;
    private $Image;

    /** RESULTADOS */
    private $Result;
    private $Error;

    /** DIRETORIOS */
    private $Folder;
    private static $BaseDir;

    function __construct($BaseDir = null) {
        self::$BaseDir = ( (string) $BaseDir ? $BaseDir : 'imagens_site/');
        if (!file_exists(self::$BaseDir) && !is_dir(self::$BaseDir)):
            mkdir(self::$BaseDir, 0777);
        endif;
    }

    public function Image(array $Image, $Name = null, $Width = null, $Folder = null) {
        $this->File = $Image;
        $this->Name = ( (string) $Name ? $Name : substr($Image['name'], 0, strrpos($Image['name'], '.')) );
        $this->Width = ( (int) $Width ? $Width : 1024 );
        $this->Folder = ( (string) $Folder ? $Folder : 'images');

        $this->CheckFolder($this->Folder);
        $this->setFileName();
        $this->UploadImage();
    }

    public function File(array $File, $Name = null, $Folder = null, $MaxFileSize = null) {
        $this->File = $File;
        $this->Name = ( (string) $Name ? $Name : substr($File['name'], 0, strrpos($File['name'], '.')) );
        $this->Folder = ( (string) $Folder ? $Folder : 'arquivos');
        $MaxFileSize = ((int) $MaxFileSize ? $MaxFileSize : 40);

        $FileAccept = [
            'application/pdf', //PDF
            'application/octet-stream', // ZIP
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document', //DOC
            'application/msword', //DOC
            'application/msword', //DOC
            'application/vnd.openxmlformats-officedocument.wordprocessingml.template', //DOC
            'application/vnd.ms-word.document.macroEnabled.12', //DOC
            'application/vnd.ms-word.template.macroEnabled.12', //DOC
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document', //DOC
            'application/vnd.ms-excel', //EXCEL
            'application/vnd.ms-excel', //EXCEL
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', //EXCEL
            'application/vnd.openxmlformats-officedocument.spreadsheetml.template', //EXCEL
            'application/vnd.ms-excel.sheet.macroEnabled.12', //EXCEL
            'application/vnd.ms-excel.addin.macroEnabled.12', //EXCEL
            'application/vnd.ms-excel.sheet.binary.macroEnabled.12', //pOWER PONT
            'application/vnd.ms-powerpoint', //pOWER PONT
            'application/vnd.ms-powerpoint', //pOWER PONT
            'application/vnd.ms-powerpoint', //pOWER PONT
            'application/vnd.openxmlformats-officedocument.presentationml.presentation', //pOWER PONT
            'application/vnd.openxmlformats-officedocument.presentationml.template', //pOWER PONT
            'application/vnd.openxmlformats-officedocument.presentationml.slideshow', //pOWER PONT
            'application/vnd.ms-powerpoint.addin.macroEnabled.12', //pOWER PONT
            'application/vnd.ms-powerpoint.presentation.macroEnabled.12', //pOWER PONT
            'application/vnd.ms-powerpoint.template.macroEnabled.12', //pOWER PONT
            'application/vnd.ms-powerpoint.slideshow.macroEnabled.12', //pOWER PONT
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', //EXE
            'application/vnd.ms-powerpoint', //POWERPONT
            'application/gzip', //Gzip
            'audio/mp3', //MP3
            'audio/wav', // WAV
            'video/mp4' //MP4
        ];

        if ($this->File['size'] > ($MaxFileSize * (1024 * 1024))):
            $this->Result = false;
            $this->Error = "Arquivo muito grande, tamanho máximo permitido de {$MaxFileSize}mb";
        elseif (!in_array($this->File['type'], $FileAccept)):
            $this->Result = false;
            $this->Error = 'Tipo de arquivo invalido, por favor envie .PDF, .ZIP, .DOC ou .DOCX, .xlsx(Excel)!';
        else:
            $this->CheckFolder($this->Folder);
            $this->setFileName();
            $this->MoveFile();
        endif;
    }

    public function Media(array $Media, $Name = null, $Folder = null, $MaxFileSize = null) {
        $this->File = $Media;
        $this->Name = ( (string) $Name ? $Name : substr($Media['name'], 0, strrpos($Media['name'], '.')) );
        $this->Folder = ( (string) $Folder ? $Folder : 'medias' );
        $MaxFileSize = ( (int) $MaxFileSize ? $MaxFileSize : 40 );

        $FileAccept = [
            'audio/mp3',
            'video/mp4'
        ];

        if ($this->File['size'] > ($MaxFileSize * (1024 * 1024))):
            $this->Result = false;
            $this->Error = "Arquivo muito grande, tamanho máximo permitido de {$MaxFileSize}mb";
        elseif (!in_array($this->File['type'], $FileAccept)):
            $this->Result = false;
            $this->Error = 'Tipo de arquivo não suportado. Envie audio MP3 ou vídeo MP4!';
        else:
            $this->CheckFolder($this->Folder);
            $this->setFileName();
            $this->MoveFile();
        endif;
    }

    function getResult() {
        return $this->Result;
    }

    function getError() {
        return $this->Error;
    }

    //PRIVATE
    private function CheckFolder($Folder) {
        list($y, $m) = explode('/', date('Y/m'));
        $this->CreateFolder("{$Folder}");
        $this->CreateFolder("{$Folder}/{$y}");
        $this->CreateFolder("{$Folder}/{$y}/{$m}/");
        $this->Send = "{$Folder}/{$y}/{$m}/";
    }

    private function CreateFolder($Folder) {
        if (!file_exists(self::$BaseDir . $Folder) && !is_dir(self::$BaseDir . $Folder)):
            mkdir(self::$BaseDir . $Folder, 0777);
        endif;
    }

    private function setFileName() {
        $FileName = Check::Name($this->Name) . strrchr($this->File['name'], '.');
        if (file_exists(self::$BaseDir . $this->Send . $FileName)):
            $FileName = Check::Name($this->Name) . '-' . time() . strrchr($this->File['name'], '.');
        endif;
        $this->Name = $FileName;
    }

    private function UploadImage() {

        switch ($this->File['type']):
            case 'image/jpg':
            case 'image/jpeg':
            case 'image/pjpeg':
                $this->Image = imagecreatefromjpeg($this->File['tmp_name']);
                break;
            case 'image/png':
            case 'image/PNG':
            case 'image/x-png':
                $this->Image = imagecreatefrompng($this->File['tmp_name']);
                break;
        endswitch;

        if (!$this->Image):
            $this->Result = false;
            $this->Error = 'Tipo de arquivo inválido, envie imagens JPG ou PNG!';
        else:
            $x = imagesx($this->Image);
            $y = imagesy($this->Image);
            $ImageX = ($this->Width < $x ? $this->Width : $x);
            $imageH = ($ImageX * $y) / $x;

            $NewImage = imagecreatetruecolor($ImageX, $imageH);
            imagealphablending($NewImage, false);
            imagesavealpha($NewImage, true);
            imagecopyresampled($NewImage, $this->Image, 0, 0, 0, 0, $ImageX, $imageH, $x, $y);

            switch ($this->File['type']):
                case 'image/jpg':
                case 'image/jpeg':
                case 'image/pjpeg':
                    imagejpeg($NewImage, self::$BaseDir . $this->Send . $this->Name);
                    break;
                case 'image/png':
                case 'image/PNG':
                case 'image/x-png':
                    imagepng($NewImage, self::$BaseDir . $this->Send . $this->Name);
                    break;
            endswitch;

            if (!$NewImage):
                $this->Result = false;
                $this->Error = 'Tipo de arquivo inválido, envie imagens JPG ou PNG!';
            else:
                $this->Result = $this->Send . $this->Name;
                $this->Error = null;
            endif;

            imagedestroy($this->Image);
            imagedestroy($NewImage);

        endif;
    }

    //envia arquivo e midias
    private function MoveFile() {
        if (move_uploaded_file($this->File['tmp_name'], self::$BaseDir . $this->Send . $this->Name)):
            $this->Result = $this->Send . $this->Name;
            $this->Error = null;
        else:
            $this->Result = false;
            $this->Error = 'Erro ao mover o arquivo. Favor tente mais tarde!';
        endif;
    }

}
