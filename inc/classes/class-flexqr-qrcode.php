<?php

declare(strict_types=1);

use chillerlan\QRCode\{QRCode, QROptions};
use chillerlan\QRCode\Common\EccLevel;
use chillerlan\QRCode\Data\QRMatrix;
use chillerlan\QRCode\Output\{QRMarkupSVG, QRGdImage, QRGdImagePNG, QRCodeOutputException, QRInterventionImage, QRMarkupXML};
use chillerlan\QRCode\Output\QRGdImageJPEG;
use chillerlan\QRCode\Output\QREps;

if (!class_exists('FlexQr_QRCode')) {

    class FlexQr_QRCode {
    private $qr_text;
    public $eye_color;
    public $dot_color;
  public $version;
//   public $qr_code_bg_color;
    private $dot_background_color;
    private $qr_style;
    private $size;
    private $margin;
    public $qrCodeSize;
//   private $format;
    private $logo_path;
    private $draw_circular_modules;
    private $circleRadius;
    public $qr_code_logo;

      public function __construct($data=[]) {
        if (empty($data)) {
            $data = $_POST;
        }
        //  print_r($data);
         $this->qr_text = $data['qr_code_text'] ?? 'Flex Qr Code Generagor By devsbrain';
         $this->eye_color = $data['eye_color'] ?? '#000000';
         $this->dot_color = $data['dot_color'] ?? '#000000';
         $this->version = (int)$data['version'] ?? 7;
         // $this->qrStyle = $data['qr_style'] ?? 'square';
        $this->qrCodeSize = (int) ($data['qr_code_size'] ?? 150);
         $this->margin = (int) ($data['margin'] ?? 10);
        //  $this->format = $data['format'] ?? 'png';
         // $this->inputLogo = $data['input_logo'] ?? null;
        // $this->qr_code_bg_color = $data['qr_code_bg_color'] ?? '#f0f0f0';
        
        //  $this->qr_style  = $this->validateStyle($data['qr_style'] ?? 'square');
        //  $this->size     = absint($size);
        //  $this->margin   = absint($margin);
        //  $this->margin   = absint($margin);
        //  $this->format   = $this->validateFormat($_POST['format'] ?? 'svg');
        //  $this->logo_path = $_POST['input_logo'] ? $this->validateLogo('input_logo') : null;
         $this->circleRadius = (float) $data['circleRadius'] ?? 0.5;
         $this->draw_circular_modules = $data['drawCircularModules'] == 1 ? true : false;
         $this->qr_code_logo = $data['qr_code_logo'] ?? null;        
     }
 
    //  private function validateColor(string $color): array {
    //      if (!preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $color)) {
    //          throw new InvalidArgumentException('Invalid color format');
    //      }
    //      return $this->hexToRgb($color);
    //  }

//      private function getOutputType(): string {
//       switch($this->format){
//           case 'png': return QRCode::OUTPUT_IMAGE_PNG;
//           case 'jpg': return QRCode::OUTPUT_IMAGE_JPG;
//           case 'svg': return QRCode::OUTPUT_MARKUP_SVG;
//           default: throw new InvalidArgumentException('Invalid output type');
//          }
//    }
 
    //  private function hexToRgb(string $hex): array {
    //     // echo 'cxvxc'.$this->dataLight;
    //      $hex = str_replace('#', '', $hex);
    //      $length = strlen($hex);
    //      $r = hexdec($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : substr($hex, 0, 2));
    //      $g = hexdec($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : substr($hex, 2, 2));
    //      $b = hexdec($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : substr($hex, 4, 2));
         
    //     //  echo 'ytjtyj'.$r;
    //      return [$r, $g, $b];
    //  }
     
 
    //  private function validateStyle(string $style): string {
    //      $allowed_styles = ['square', 'circle', 'rounded'];
    //      if (!in_array($style, $allowed_styles)) {
    //          throw new InvalidArgumentException('Invalid QR style');
    //      }
    //      return $style;
    //  }
 
    //  private function validateFormat(string $format): string {
    //      $allowed_formats = ['png', 'jpg', 'svg', 'pdf', 'eps'];
    //      $format = strtolower($format);
    //      if (!in_array($format, $allowed_formats)) {
    //          throw new InvalidArgumentException('Invalid file format');
    //      }
    //      return $format;
    //  }
 
    //  private function validateLogo(string $path): string {
    //      if (!file_exists($path)) {
    //          throw new InvalidArgumentException('Logo file not found');
    //      }
         
    //      $mime = mime_content_type($path);
    //      if (!in_array($mime, ['image/png', 'image/jpeg'])) {
    //          throw new InvalidArgumentException('Invalid logo format. Only PNG and JPG allowed');
    //      }
         
    //      return $path;
    //  }
 
     public function generate() {      
        $colors = [
            // finder
            QRMatrix::M_FINDER_DARK    => $this->eye_color, // dark (true)//eye color
            QRMatrix::M_FINDER_DOT     => $this->eye_color, // finder dot, dark (true) eye color
            // QRMatrix::M_FINDER         => $this->eye_color, // light (false), eye color
            // // alignment
            QRMatrix::M_ALIGNMENT_DARK => $this->dot_color, //center eye color
            // QRMatrix::M_ALIGNMENT      => $this->eye_color,//center eye inner color 
            // // timing
             QRMatrix::M_TIMING_DARK    => $this->dot_color, //center line dot color    
            QRMatrix::M_TIMING         => $this->dot_color,
            // // format
            // // QRMatrix::M_FORMAT_DARK    => $dot_background_color,
            // QRMatrix::M_FORMAT         => $this->dot_color, //enable this scan code is not working
            // version
            // QRMatrix::M_VERSION_DARK   => $this->dot_color,
            // QRMatrix::M_VERSION        => $this->dot_color,
            // data
           QRMatrix::M_DATA_DARK      => $this->dot_color, //dot_color
            // QRMatrix::M_DATA           => $this->dot_color, //dot background color
            // darkmodule
            QRMatrix::M_DARKMODULE     => $this->dot_color,
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
        $options->version             = $this->version;
        // ecc level H is required for logo space
        $options->eccLevel            = EccLevel::H;
        // $options->imageBase64          = true;
        $options->scale               = 6;
        $options->outputBase64        = true;
        // $options->outputInterface = QRGdImagePNG::class;
        // $options->readerUseImagickIfAvailable = true;
        // $options->readerIncreaseContrast      = true;
        // $options->readerGrayscale             = true;
        $options->drawCircularModules = $this->draw_circular_modules;
        $options->drawLightModules    = true;
        $options->circleRadius        = $this->circleRadius; //works only when draw_circular_modules is true
        // $options->outputType          = QRCode::OUTPUT_MARKUP_SVG;
        // $options->keepAsSquare        = [
        //     QRMatrix::M_FINDER_DARK,
        //     QRMatrix::M_FINDER_DOT,
        //     QRMatrix::M_ALIGNMENT_DARK,
        // ];
        $options->connectPaths        = false; // eye color is not working if we set this to true
        // $options->svgOpacity          = 1.0;
        // $options->svgDefs             = '
        //     <linearGradient id="gradient" x1="0" y1="0" x2="1" y2="1">
        //         <stop offset="0%" style="stop-color:#39FFFF;stop-opacity:1" />
        //         <stop offset="100%" style="stop-color:#F3FFFF;stop-opacity:1" />
        //     </linearGradient>
        // ';
        // $options->svgClass            = 'my-qr-code';
        // $options->svgViewBox          = null;
        $options->moduleValues        = $colors;        

                //Determine the output interface based on the selected format
                // switch ($this->format) {
                //     case 'svg':
                //         $outputInterface = QRMarkupSVG::class;
                //         $contentType = 'image/svg+xml';
                //         break;
                //     case 'png':
                //         $outputInterface = QRGdImagePNG::class;
                //         $contentType = 'image/png';
                //         break;
                //     case 'jpeg':
                //         $outputInterface = QRGdImageJPEG::class;
                //         $contentType = 'image/jpeg';
                //         break;
                //     case 'eps':
                //         $outputInterface = QREps::class;
                //         $contentType = 'application/postscript';
                //         break;
                    // case 'xml':
                    //     $outputInterface = QRMarkupXML::class;
                    //     $contentType = 'application/xml';
                    //     break;
                
                // }
                // $options->outputInterface     = $outputInterface;
                // $options->contentType = $contentType;

                if (isset($_FILES['qr_code_logo']) && $_FILES['qr_code_logo']['error'] === UPLOAD_ERR_OK) {
                    $logoPath = $this->saveUploadedLogo($_FILES['qr_code_logo']);
                    
                    if ($logoPath) {
                        $options->addLogoSpace        = true;
                        $options->logoSpaceWidth      = 15; // Adjust logo width
                        $options->logoSpaceHeight     = 15; // Adjust logo height
                        $qrImage = (new QRCode($options));
                        $qrImage->addByteSegment($this->qr_text);

                        $qrOutputInterface = new QRImageWithLogo($options, $qrImage->getQRMatrix());
                        
                        // the logo could also be supplied via the options, see the svgWithLogo example
                        $out = $qrOutputInterface->dump(null, $logoPath);
                        
                        unlink($logoPath); // Remove temporary file
                        header('Content-type: image/png');
                        return $out;
                    }
                } 
                // Generate the QR Code
                $qrImage = (new QRCode($options))->render($this->qr_text);
            
                header('Content-type: image/png');

                return $qrImage;
            }

            /**
             * Saves the uploaded logo file temporarily and returns its path.
             */
            private function saveUploadedLogo($file) {
                $allowedTypes = ['image/png', 'image/jpeg', 'image/jpg']; // Allowed file types

                if (!in_array($file['type'], $allowedTypes)) {
                    return null; // Invalid file type
                }
                $upload_dir = wp_upload_dir();
                $uploads_path = $upload_dir['path'];
                $tempPath = $uploads_path . '/' . uniqid('logo_', true) . '.png';
                move_uploaded_file($file['tmp_name'], $tempPath);
                return $tempPath;
            }
        }     
    }

    class QRImageWithLogo extends QRGdImagePNG{

        /**
         * @throws \chillerlan\QRCode\Output\QRCodeOutputException
         */
        public function dump(string|null $file = null, string|null $logo = null):string{
            $logo ??= '';
    
            // set returnResource to true to skip further processing for now
            $this->options->returnResource = true;
    
            // of course, you could accept other formats too (such as resource or Imagick)
            // I'm not checking for the file type either for simplicity reasons (assuming PNG)
            if(!is_file($logo) || !is_readable($logo)){
                throw new QRCodeOutputException('invalid logo');
            }
    
            // there's no need to save the result of dump() into $this->image here
            parent::dump($file);
    
            $im = imagecreatefrompng($logo);
    
            if($im === false){
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
    
            if($this->options->outputBase64){
                $imageData = $this->toBase64DataURI($imageData);
            }
    
            return $imageData;
        }
    
    }