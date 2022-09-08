<?php

// type - способ масштабирования
// q - качество сжатия
// src - исходное изображение
// dest - результирующее изображение
// w - ширниа изображения
// ratio - коэффициент пропорциональности
// copy - текстовая строка

class Imageresize
{

    private $type;
    private $q = 100;
    private $src;
    private $dest;
    private $w = 160;
    private $h = 200;
    private $copy;

    public function init($config = array())
    {
        if (count($config) < 1)
            return false;
        foreach ($config as $prorerty => $value)
        {
            $this->$prorerty = $value;
        }
    }

    private function set_copy()
    {
        $size = 2; // размер шрифта
        $x_text = $w_dest - imagefontwidth($size) * strlen($this->copy) - 3;
        $y_text = $h_dest - imagefontheight($size) - 3;

        // определяем каким цветом на каком фоне выводить текст
        $white = imagecolorallocate($this->dest, 255, 255, 255);
        $black = imagecolorallocate($this->dest, 0, 0, 0);
        $gray = imagecolorallocate($this->dest, 127, 127, 127);
        if (imagecolorat($this->dest, $x_text, $y_text) > $gray)
            $color = $black;
        if (imagecolorat($this->dest, $x_text, $y_text) < $gray)
            $color = $white;

        // выводим текст
        imagestring($this->dest, $size, $x_text - 1, $y_text - 1, $this->copy, $white - $color);
        imagestring($this->dest, $size, $x_text + 1, $y_text + 1, $this->copy, $white - $color);
        imagestring($this->dest, $size, $x_text + 1, $y_text - 1, $this->copy, $white - $color);
        imagestring($this->dest, $size, $x_text - 1, $y_text + 1, $this->copy, $white - $color);

        imagestring($this->dest, $size, $x_text - 1, $y_text, $this->copy, $white - $color);
        imagestring($this->dest, $size, $x_text + 1, $y_text, $this->copy, $white - $color);
        imagestring($this->dest, $size, $x_text, $y_text - 1, $this->copy, $white - $color);
        imagestring($this->dest, $size, $x_text, $y_text + 1, $this->copy, $white - $color);

        imagestring($this->dest, $size, $x_text, $y_text, $this->copy, $color);
    }

    public function resize($src_path)
    {
        $this->src = $this->getImgSource($src_path);
        $w_src = imagesx($this->src);
        $h_src = imagesy($this->src);
        if ($w_src <= 1024 && $h_src <= 768)
        {
//            if ($w_src != $this->w) {

            switch ($this->type)
            {
                case 1:
                    $this->dest = imagecreatetruecolor($this->w, $this->w);

                    if ($w_src > $h_src)
                        imagecopyresized($this->dest, $this->src, 0, 0, round((max($w_src, $h_src) - min($w_src, $h_src)) / 2), 0, $this->w, $this->w, min($w_src, $h_src), min($w_src, $h_src));

                    if ($w_src < $h_src)
                        imagecopyresized($this->dest, $this->src, 0, 0, 0, 0, $this->w, $this->w, min($w_src, $h_src), min($w_src, $h_src));

                    if ($w_src == $h_src)
                        imagecopyresized($this->dest, $this->src, 0, 0, 0, 0, $this->w, $this->w, $w_src, $w_src);
                    break;
                case 2:
                    $ratio = $w_src / $this->w;
                    $w_dest = round($w_src / $ratio);
                    $h_dest = round($h_src / $ratio);

                    $this->dest = imagecreatetruecolor($w_dest, $h_dest);
                    imagecopyresized($this->dest, $this->src, 0, 0, 0, 0, $w_dest, $h_dest, $w_src, $h_src);

                    if (!empty($this->copy))
                        $this->set_copy();
                    break;
                case 3:
                    if ($w_src < $h_src)
                    {
                        $ratio = $w_src / $this->w;
                        $w_dest = round($w_src / $ratio);
                        $h_dest = round($h_src / $ratio);
                        $this->dest = imagecreatetruecolor($this->w, $this->h);
                        imagecopyresampled($this->dest, $this->src, 0, 0, 0, 0, $w_dest, $h_dest, $w_src, $h_src);
                    } elseif ($w_src > $h_src)
                    {
                        $ratio = $h_src / $this->h;
                        $w_dest = round($w_src / $ratio);
                        $h_dest = round($h_src / $ratio);
                        $delta = ($w_dest - 160) / 2;
                        $this->dest = imagecreatetruecolor($this->w, $this->h);
                        imagecopyresampled($this->dest, $this->src, -$delta, 0, 0, 0, $w_dest, $h_dest, $w_src, $h_src);
                    } elseif ($w_src == $h_src)
                    {
                        $ratio = $h_src / $this->h;
                        $w_dest = round($w_src / $ratio);
                        $h_dest = round($h_src / $ratio);
                        $w_delta = ($w_dest - $this->w) / 2;
                        $h_delta = ($h_dest - $this->h) / 2;
                        $this->dest = imagecreatetruecolor($this->w, $this->h);
                        imagecopyresampled($this->dest, $this->src, -$w_delta, -$h_delta, 0, 0, $w_dest, $h_dest, $w_src, $h_src);
                    }
                    break;
            }
//            }
            return true;
        }
        else
            return false;
    }

    function show()
    {
        header("Content-type: image/jpeg");
        imagejpeg($this->dest, '', $this->q);
        imagedestroy($this->dest);
        imagedestroy($this->src);
    }

    function save($dest_path)
    {
        // вывод картинки и очистка памяти
        if (empty($dest_path))
            header("Content-type: image/jpeg");

        imagejpeg($this->dest, $dest_path, $this->q);
        imagedestroy($this->dest);
        imagedestroy($this->src);
    }

    private function getImgSource($f)
    {
        switch ($this->getExtension($f))
        {
            case 'png':
                return imagecreatefrompng($f);
                break;
            case 'jpg':
                return imagecreatefromjpeg($f);
                break;
            case 'gif':
                imagecreatefromgif($f);
                break;
        }
    }

    private function getExtension($f)
    {
        return strtolower(end(explode(".", $f)));
    }

}

//$conf = array(
//    'type' => 2,
//    'q' => 100,
//    'w' => 160,
//    'copy' => 'teatrkaluga.ru'
//);
//$imgrsze = new imageresize();
//$imgrsze->init($conf);
//
//# $src = [ png | gif | jpg ] - only
//$imgrsze->resize('0_385a4_83ee032_L.jpg');
////$imgrsze->save('test.jpg');
//$imgrsze->show();

