<?php

declare(strict_types=1);

use chillerlan\QRCode\{QRCode, QROptions};
use chillerlan\QRCode\Common\EccLevel;
use chillerlan\QRCode\Data\QRMatrix;
use chillerlan\QRCode\Output\{QRMarkupSVG, QRGdImage, QRGdImagePNG, QRInterventionImage, QRMarkupXML};
use chillerlan\QRCode\Output\QRGdImageJPEG;
use chillerlan\QRCode\Output\QREps;

if (!class_exists('FlexQr_QRCode')) {

   class FlexQr_QRCode {
      private $qr_text;
      public $eye_color;
      public $dot_color;
      public $version;
      public $qr_code_bg_color;
      private $dot_background_color;
      private $qr_style;
      private $size;
      private $margin;
      private $format;
      private $logo_path;
      private $draw_circular_modules;
      private $circleRadius;
    //   private $background_color;

      public function __construct($data=[]) {
        if (empty($data)) {
            $data = $_POST;
        }
        //  print_r($data);
         $this->qr_text = $data['qr_code_text'] ?? 'Flex Qr Code Generagor By devsbrain';
         $this->eye_color = $data['eye_color'] ?? '#000000';
         $this->dot_color = $data['dot_color'] ?? '#000000';
         $this->version = $data['version'] ?? 5;
         // $this->qrStyle = $data['qr_style'] ?? 'square';
        //  $this->size = (int) ($data['size'] ?? 300);
        //  $this->margin = (int) ($data['margin'] ?? 10);
         $this->format = $data['format'] ?? 'png';
         // $this->inputLogo = $data['input_logo'] ?? null;
        $this->qr_code_bg_color = $data['qr_code_bg_color'] ?? '#f0f0f0';
        
        //  $this->qr_style  = $this->validateStyle($data['qr_style'] ?? 'square');
         // $this->size     = absint($size);
         // $this->margin   = absint($margin);
        //  $this->format   = $this->validateFormat($_POST['format'] ?? 'svg');
         $this->logo_path = $_POST['input_logo'] ? $this->validateLogo('input_logo') : null;
         $this->circleRadius = (float) $_POST['circleRadius'] ?? 0.5;
         $this->draw_circular_modules = $_POST['drawCircularModules'] == 1 ? true : false;
        //  echo 'dataLight'.$data['dataLight'];
        //  print_r($this->hexToRgb($data['dataLight']));
        //  $this->background_color = $this->validateColor($data['background_color'] ?? '#000000');
        // $this->background_color = $this->$_POST['background_color']; 
     }
 
     private function validateColor(string $color): array {
         if (!preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $color)) {
             throw new InvalidArgumentException('Invalid color format');
         }
         return $this->hexToRgb($color);
     }

//      private function getOutputType(): string {
//       switch($this->format){
//           case 'png': return QRCode::OUTPUT_IMAGE_PNG;
//           case 'jpg': return QRCode::OUTPUT_IMAGE_JPG;
//           case 'svg': return QRCode::OUTPUT_MARKUP_SVG;
//           default: throw new InvalidArgumentException('Invalid output type');
//          }
//    }
 
     private function hexToRgb(string $hex): array {
        // echo 'cxvxc'.$this->dataLight;
         $hex = str_replace('#', '', $hex);
         $length = strlen($hex);
         $r = hexdec($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : substr($hex, 0, 2));
         $g = hexdec($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : substr($hex, 2, 2));
         $b = hexdec($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : substr($hex, 4, 2));
         
        //  echo 'ytjtyj'.$r;
         return [$r, $g, $b];
     }
     
 
     private function validateStyle(string $style): string {
         $allowed_styles = ['square', 'circle', 'rounded'];
         if (!in_array($style, $allowed_styles)) {
             throw new InvalidArgumentException('Invalid QR style');
         }
         return $style;
     }
 
     private function validateFormat(string $format): string {
         $allowed_formats = ['png', 'jpg', 'svg', 'pdf', 'eps'];
         $format = strtolower($format);
         if (!in_array($format, $allowed_formats)) {
             throw new InvalidArgumentException('Invalid file format');
         }
         return $format;
     }
 
     private function validateLogo(string $path): string {
         if (!file_exists($path)) {
             throw new InvalidArgumentException('Logo file not found');
         }
         
         $mime = mime_content_type($path);
         if (!in_array($mime, ['image/png', 'image/jpeg'])) {
             throw new InvalidArgumentException('Invalid logo format. Only PNG and JPG allowed');
         }
         
         return $path;
     }
 
     public function generate() {      
        // Function to prepare options for different formats
        // function prepareOptions($outputInterface, $dotColors, $version, $circleRadius, $drawCircularModules) {
        // echo $this->eye_color;
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
            QRMatrix::M_QUIETZONE      => $this->qr_code_bg_color, //background_color
            // logo (requires a call to QRMatrix::setLogoSpace()), see QRImageWithLogo
            // QRMatrix::M_LOGO           => '#b105f0',

            // 1536 => 'url(#gradient)', // finder
            // 6    => '#39FFFF', // dark (data)
            // 8    => 'url(#gradient)', // alignment
            // 2560 => '#c91414', // format
            // 10   => 'url(#gradient)', // version
            ];
            // print_r($colors);

        $options = new QROptions;

        $options->version             = 7;
        $options->eccLevel            = EccLevel::L;
        // $options->imageBase64          = true;
        // $options->addLogoSpace          = true;
        // $options->logoSpaceHeight      = 17;
        // $options->logoSpaceWidth        = 17;
       
        $options->scale               = 10;
        $options->outputBase64        = true;
        // $options->readerUseImagickIfAvailable = true;
        // $options->readerIncreaseContrast      = true;
        // $options->readerGrayscale             = true;
        // $options->bgColor             = [232, 201, 0];
        // $options->imageTransparent    = true;
        #$options->transparencyColor   = [233, 233, 233];
        $options->drawCircularModules = $this->draw_circular_modules;
        $options->drawLightModules    = true;
        $options->circleRadius        = $this->circleRadius;
        // $options->outputType          = QRCode::OUTPUT_MARKUP_SVG;
        // $options->keepAsSquare        = [
        //     QRMatrix::M_FINDER_DARK,
        //     QRMatrix::M_FINDER_DOT,
        //     QRMatrix::M_ALIGNMENT_DARK,
        // ];
        $options->connectPaths        = false; // color is not working if we set this to false
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
        switch ($this->format) {
            case 'svg':
                $outputInterface = QRMarkupSVG::class;
                $contentType = 'image/svg+xml';
                break;
            case 'png':
                $outputInterface = QRGdImagePNG::class;
                $contentType = 'image/png';
                break;
            case 'jpeg':
                $outputInterface = QRGdImageJPEG::class;
                $contentType = 'image/jpeg';
                break;
            case 'eps':
                $outputInterface = QREps::class;
                $contentType = 'application/postscript';
                break;
            case 'xml':
                $outputInterface = QRMarkupXML::class;
                $contentType = 'application/xml';
                break;
          
        }
        $options->outputInterface     = $outputInterface;
        $options->contentType = $contentType;
        
        // Generate the QR Code
        $qrOut = (new QRCode($options))->render($this->qr_text);
        // header('Content-type: image/png');

        // if(PHP_SAPI !== 'cli'){
        //     // if viewed in the browser, we should push it as file download as EPS isn't usually supported
        //     header('Content-type: application/postscript');
        //     header('Content-Disposition: filename="qrcode-2.eps"');
        // }        

        // echo $qrOut;

        return $qrOut;

        // Path to save the final image with logo
        $outputPath = __DIR__ . '/qrcode_with_logo.png';

        // Overlay the logo on the PNG QR Code if a logo is uploaded and the format is PNG
        if ($qr_code_format === 'png' && isset($_FILES['logo']) && $_FILES['logo']['error'] == UPLOAD_ERR_OK) {
            $logoPath = $_FILES['logo']['tmp_name'];
            overlayLogo($qrOut, $logoPath, $outputPath);
            $qrOut = file_get_contents($outputPath);
        }

        
        //   private function addLogoOverlay(string $qrData): string {
        //  $qrImage = imagecreatefromstring($qrData);
        //  $logo = imagecreatefromstring(file_get_contents($this->logo_path));
 
         // ... [Keep previous logo merging code] ...
 
        //  ob_start();
        //  if($this->format === 'jpg'){
        //      imagejpeg($qrImage, null, 100);
        //  } else {
        //      imagepng($qrImage);
        //  }
        //  $combined = ob_get_clean();
 
        //  // ... [Keep cleanup code] ...
 
        //  return $combined;
     }

    //  echo $qrOut;
 
     public function saveToFile(string $path): string {
         $data = $this->generate($this->qr_text);
         $ext = $this->format === 'jpg' ? 'jpeg' : $this->format;
         $filename = sanitize_file_name(md5(uniqid().$this->qr_text).'.'.$ext);
         $fullpath = trailingslashit($path).$filename;
 
         file_put_contents($fullpath, $data);
 
         return $fullpath;
     }

     
    public function generate_qr_code($qr_only=false) {
          global $wpdb;         
          
            // $qrCodeGenerator = new FlexQr_QRCode([
            //     'qr_text' => $qr_code_text,
            //     // 'eye_color' => $_POST['eye_color'],
            //     'dot_color' => $qr_code_color,
            //     // 'qr_style' => $_POST['qr_style'],
            //     'size' => $qr_code_size,
            //     'margin' => $qr_code_margin,
            //     'format' => $qr_code_format,
            //     'input_logo' => $uploaded_logo['url'] ?? null
            // ]);
      
          if ($qr_only){
            // return  $data = $this->generate($this->qr_text);
            return $this->generate();
          }
          
          $filepath = $qrCodeGenerator->saveToFile($uploads['path']);
          $url = $uploads['url'] . '/' . basename($filepath);
          echo "<img src='".$url . "' />";
            // default output is a base64 encoded data URI
            // printf('<img src="%s" alt="QR Code" />', $qrcode);
            
            // echo '<svg width="300px" src="' . $GLOBALS["out"] . '" alt="QR code" >';
      
            // header('Content-type: image/svg+xml'); // the image type is SVG by default
      
            // echo '<svg width="300px" src="' . (new QRCode($options))->render($data) . '" alt="QR code" >';
      
            // Store the QR code in the database
            // $result = $wpdb->insert(
            //   $wpdb->prefix . 'qr_codes',
            //   array(
            //     'text' => $qr_code_text,
            //     // 'qr_code_url' => $qr_code_url
            //     'qr_data' => $qr_code_data
            //   ),
            //   array(
            //     '%s',
            //     '%s'
            //   )
            // );
            if ($result == 1 && $qr_code_format != 'eps') {
             echo '<p>'.esc_html_e("Your QR code has been generated:", "flex-qr-code-generator").'</p>';
             echo '<img src="' . esc_url($qr_code_url) . '" alt="QR code">';
            } else if ($result == 1 && $qr_code_format == 'eps') {
              echo '<p>'.esc_html_e("Your QR code has been generated:", "flex-qr-code-generator").'</p>';
              echo '<p>'.esc_html_e("No Preview for eps file. Please download it from the below table.", "flex-qr-code-generator").'</p>';
            }
          }
        }     
    }