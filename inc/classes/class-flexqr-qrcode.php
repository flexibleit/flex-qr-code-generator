<?php

declare(strict_types=1);

use chillerlan\QRCode\{QRCode, QROptions};
use chillerlan\QRCode\Common\EccLevel;
use chillerlan\QRCode\Data\QRMatrix;
use chillerlan\QRCode\Output\{QRMarkupSVG, QRGdImage, QRGdImagePNG, QRCodeOutputException, QRInterventionImage, QRMarkupXML};
use chillerlan\QRCode\Output\QRGdImageJPEG;
use chillerlan\QRCode\Output\QREps;

if (!class_exists('FlexQr_QRCode')) {

    class FlexQr_QRCode
    {
        private $qr_text;
        public $eye_color;
        public $dot_color;
        public $version;
        private $qr_style;
        private $size;
        public $margin;
        public $qrCodeSize;
        //   private $format;
        private $logo_path;
        private $draw_circular_modules;
        private $circleRadius;
        public $qr_code_logo;

        public function __construct($data = [])
        {
            if (empty($data)) {
                $data = $_POST;
            }
            $this->qr_text = $data['qr_code_text'] ?? 'Flex Qr Code Generagor By devsbrain';
            $this->eye_color = $data['eye_color'] ?? '#000000';
            $this->dot_color = $data['dot_color'] ?? '#000000';
            $this->version = (int) $data['version'] ?? 7;
            $this->qrCodeSize = (int) ($data['qr_code_size'] ?? 150);
            $this->margin = (int) ($data['qr_code_margin'] ?? 10);

            $this->circleRadius = (float) $data['circleRadius'] ?? 0.5;
            $this->draw_circular_modules = $data['drawCircularModules'] == 1 ? true : false;
            $this->qr_code_logo = $data['qr_code_logo'] ?? null;
        }



        public function generate()
        {
            $colors = [
                    // finder
                QRMatrix::M_FINDER_DARK => $this->eye_color, // dark (true)//eye color
                QRMatrix::M_FINDER_DOT => $this->eye_color, // finder dot, dark (true) eye color
                    // QRMatrix::M_FINDER         => $this->eye_color, // light (false), eye color
                    // // alignment
                QRMatrix::M_ALIGNMENT_DARK => $this->dot_color, //center eye color
                    // QRMatrix::M_ALIGNMENT      => $this->eye_color,//center eye inner color 
                    // // timing
                QRMatrix::M_TIMING_DARK => $this->dot_color, //center line dot color    
                QRMatrix::M_TIMING => $this->dot_color,
                    // // format
                    // // QRMatrix::M_FORMAT_DARK    => $dot_background_color,
                    // QRMatrix::M_FORMAT         => $this->dot_color, //enable this scan code is not working
                    // version
                    // QRMatrix::M_VERSION_DARK   => $this->dot_color,
                    // QRMatrix::M_VERSION        => $this->dot_color,
                    // data
                QRMatrix::M_DATA_DARK => $this->dot_color, //dot_color
                    // QRMatrix::M_DATA           => $this->dot_color, //dot background color
                    // darkmodule
                QRMatrix::M_DARKMODULE => $this->dot_color,
                // separator
                // QRMatrix::M_SEPARATOR      => $this->dot_color,
                // quietzone
                // QRMatrix::M_QUIETZONE      => $this->qr_code_bg_color, //background_color
                // logo (requires a call to QRMatrix::setLogoSpace()), see QRImageWithLogo
                // QRMatrix::M_LOGO           => '#b105f0',

                // 1536 => 'url(#gradient)', // finder
                // 6    => '#39FFFF', // dark (data)
                // 8    => 'url(#gradient)', // alignment
                // 2560 => '#c91414', // format
                // 10   => 'url(#gradient)', // version
            ];
            $options = new QROptions;
            $options->version = $this->version;
            // ecc level H is required for logo space
            $options->eccLevel = EccLevel::H;
            // $options->imageBase64          = true;
            $options->scale = 6;
            $options->outputBase64 = true;

            $options->drawCircularModules = $this->draw_circular_modules;
            $options->drawLightModules = true;
            $options->circleRadius = $this->circleRadius; //works only when 
            $options->connectPaths = false;

            $options->moduleValues = $colors;

            $options->quietzoneSize = $this->margin;

            if (isset($_FILES['qr_code_logo']) && $_FILES['qr_code_logo']['error'] === UPLOAD_ERR_OK) {
                $logoPath = $this->saveUploadedLogo($_FILES['qr_code_logo']);
                // print_r($_FILES);exit;
                // print_r('LogoPath:' . $logoPath);
                // exit;

                if ($logoPath) {
                    $options->addLogoSpace = true;
                    $options->logoSpaceWidth = 15; // Adjust logo width
                    $options->logoSpaceHeight = 15; // Adjust logo height
                    $qrImage = (new QRCode($options));
                    $qrImage->addByteSegment($this->qr_text);

                    $qrOutputInterface = new QRImageWithLogo($options, $qrImage->getQRMatrix());

                    // the logo could also be supplied via the options, see the svgWithLogo example
                    $out = $qrOutputInterface->dump(null, $logoPath);


                    // unlink($logoPath); // Remove temporary file
                    header('Content-type: image/png');

                    return [$out, $logoPath];
                }
            }
            // Generate the QR Code
            $qrImage = (new QRCode($options))->render($this->qr_text);

            header('Content-type: image/png');

            return [$qrImage, null];

        }

        /**
         * Saves the uploaded logo file temporarily and returns its path.
         */
        private function saveUploadedLogo($file)
        {
            $allowedTypes = ['image/png', 'image/jpeg', 'image/jpg'];

            if (!in_array($file['type'], $allowedTypes)) {
                throw new QRCodeOutputException('Invalid file type. Only PNG and JPEG are allowed.');
            }

            $filename = 'logo_' . uniqid() . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = preg_replace(['/[^a-zA-Z0-9_\.]/', '/\.+/'], ['', '.'], $filename);
            $filename = str_replace(' ', '_', $filename);

            $full_path = WP_CONTENT_DIR . '/uploads/' . $filename;

            if (!move_uploaded_file($file['tmp_name'], $full_path)) {
                throw new QRCodeOutputException('Failed to move the uploaded file.');
            }

            return $full_path;
        }

    }
}

class QRImageWithLogo extends QRGdImagePNG
{

    /**
     * @throws \chillerlan\QRCode\Output\QRCodeOutputException
     */
    public function dump(string|null $file = null, string|null $logo = null): string
    {
        $logo ??= '';

        // var_dump($logo);

        // set returnResource to true to skip further processing for now
        $this->options->returnResource = true;

        // of course, you could accept other formats too (such as resource or Imagick)
        // I'm not checking for the file type either for simplicity reasons (assuming PNG)
        if (!is_file($logo) || !is_readable($logo)) {
            throw new QRCodeOutputException('invalid logo');
        }

        // there's no need to save the result of dump() into $this->image here
        parent::dump($file);

        $im = imagecreatefrompng($logo);

        if ($im === false) {
            throw new QRCodeOutputException('imagecreatefrompng() error');
        }

        // get logo image size
        $w = imagesx($im);
        $h = imagesy($im);

        // set new logo size, leave a border of 1 module (no proportional resize/centering)
        $lw = (($this->options->logoSpaceWidth - 2) * $this->options->scale);
        $lh = (($this->options->logoSpaceHeight - 2) * $this->options->scale);

        // get the qrcode size
        $ql = ($this->matrix->getSize() * $this->options->scale);

        // scale the logo and copy it over. done!
        imagecopyresampled($this->image, $im, (($ql - $lw) / 2), (($ql - $lh) / 2), 0, 0, $lw, $lh, $w, $h);

        $imageData = $this->dumpImage();

        $this->saveToFile($imageData, $file);

        if ($this->options->outputBase64) {
            $imageData = $this->toBase64DataURI($imageData);
        }

        return $imageData;
    }

}