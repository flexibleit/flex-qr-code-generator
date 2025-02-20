<?php

use chillerlan\QRCode\{QRCode, QROptions};
use chillerlan\QRCode\Common\EccLevel;
use chillerlan\QRCode\Data\QRMatrix;
use chillerlan\QRCode\Output\{QRMarkupSVG, QRGdImage, QRInterventionImage, QRMarkupXML};
use chillerlan\QRCode\Output\QRGdImageJPEG;
use chillerlan\QRCode\Output\QREps;

if (!class_exists('FlexQr_QRCode')) {

   class FlexQr_QRCode {
      private $qr_text;
      private $eye_color;
      private $dot_color;
      private $qr_style;
      private $size;
      private $margin;
      private $format;
      private $logo_path;

      public function __construct($data) {
        //  print_r($data);
         // $this->qrText = $data['qr_text'] ?? 'Hello World';
         // $this->eyeColor = $data['eye_color'] ?? '#000000';
         // $this->dotColor = $data['dot_color'] ?? '#000000';
         // $this->qrStyle = $data['qr_style'] ?? 'square';
         $this->size = (int) ($data['size'] ?? 300);
         $this->margin = (int) ($data['margin'] ?? 10);
         // $this->format = $data['format'] ?? 'png';
         // $this->inputLogo = $data['input_logo'] ?? null;
         $this->qr_text   = sanitize_text_field($data['qr_text'] ?? 'Hello World');
         $this->eye_color = $this->validateColor($data['eye_color'] ?? '#000000');
         $this->dot_color = $this->validateColor($data['dot_color'] ?? '#000000');
         $this->qr_style  = $this->validateStyle($data['qr_style'] ?? 'square');
         // $this->size     = absint($size);
         // $this->margin   = absint($margin);
         $this->format   = $this->validateFormat($data['format'] ?? 'png');
         $this->logo_path = $data['input_logo'] ? $this->validateLogo($data['input_logo']) : null;
     }
 
     private function validateColor(string $color): array {
         if (!preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $color)) {
             throw new InvalidArgumentException('Invalid color format');
         }
         return $this->hexToRgb($color);
     }

     private function getOutputType(): string {
      switch($this->format){
          case 'png': return QRCode::OUTPUT_IMAGE_PNG;
          case 'jpg': return QRCode::OUTPUT_IMAGE_JPG;
          case 'svg': return QRCode::OUTPUT_MARKUP_SVG;
          default: throw new InvalidArgumentException('Invalid output type');
         }
   }
 
     private function hexToRgb(string $hex): array {
         $hex = str_replace('#', '', $hex);
         $length = strlen($hex);
         $r = hexdec($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : substr($hex, 0, 2));
         $g = hexdec($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : substr($hex, 2, 2));
         $b = hexdec($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : substr($hex, 4, 2));
         
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

        // Custom colors for different parts of the QR code
        $dotColors = [
            QRMatrix::M_FINDER_DARK => $_POST['finderDark'],
            QRMatrix::M_FINDER_DOT  => $_POST['finderDot'],
            QRMatrix::M_ALIGNMENT_DARK => $_POST['alignmentDark'],
            QRMatrix::M_DATA_DARK   => $_POST['dataDark'],
            QRMatrix::M_DATA        => $_POST['dataLight'],
        ];

// Get the selected version from the form
$version = (int)$_POST['version'];

// Get the selected circleRadius from the form
$circleRadius = (float)$_POST['circleRadius'];

// Get the selected drawCircularModules option from the form
$drawCircularModules = isset($_POST['drawCircularModules']) ? true : false;

// Function to prepare options for different formats
function prepareOptions($outputInterface, $dotColors, $version, $circleRadius, $drawCircularModules) {
    $options = new QROptions([
        'version'             => $version,
        'eccLevel'            => EccLevel::H,
        'addQuietzone'        => true,
        'outputBase64'        => true,
        'drawLightModules'    => false,
        'connectPaths'        => true,
        'drawCircularModules' => $drawCircularModules !== 'none',
        'circleRadius'        => $circleRadius,
        'outputInterface'     => $outputInterface,
        'moduleValues'        => $dotColors,        
    ]);

    return $options;
}

// Function to overlay a logo on the QR code
// function overlayLogo($qrImage, $logoPath, $outputPath) {
//     $qr = imagecreatefromstring($qrImage);
//     $logo = imagecreatefromstring(file_get_contents($logoPath));

//     // Get dimensions
//     // $qrWidth = imagesx($qr);
//     // $qrHeight = imagesy($qr);
//     // $logoWidth = imagesx($logo);
//     // $logoHeight = imagesy($logo);

//     // Calculate logo placement
//     // $logoQRWidth = $qrWidth / 5;
//     // $scale = $logoWidth / $logoQRWidth;
//     // $logoQRHeight = $logoHeight / $scale;

//     // Overlay logo
//     // imagecopyresampled($qr, $logo, $qrWidth / 2.5, $qrHeight / 2.5, 0, 0, $logoQRWidth, $logoQRHeight, $logoWidth, $logoHeight);

//     // Save the image
//     // imagepng($qr, $outputPath);
//     // imagedestroy($qr);
//     // imagedestroy($logo);
// }

// // Prepare the options for SVG output
// $svgOptions = prepareOptions(QRMarkupSVG::class, $dotColors);

// // Prepare the options for PNG output
// $pngOptions = prepareOptions(QRGdImage::class, $dotColors);

// // Prepare the options for JPEG output
// $jpegOptions = prepareOptions(QRGdImageJPEG::class, $dotColors);

// // Prepare the options for EPS output
// $epsOptions = prepareOptions(QREps::class, $dotColors);

// // Prepare the options for XML output
// $xmlOptions = prepareOptions(QRMarkupXML::class, $dotColors);

// // Data to encode
// $data = 'https://www.youtube.com/watch?v=dQw4w9WgXcQ';

// // Generate the QR Code for SVG
// $svgOut = (new QRCode($svgOptions))->render($data);

// // Generate the QR Code for PNG
// $pngOut = (new QRCode($pngOptions))->render($data);

// // Generate the QR Code for JPEG
// $jpegOut = (new QRCode($jpegOptions))->render($data);

// // Generate the QR Code for EPS
// $epsOut = (new QRCode($epsOptions))->render($data);

// // Generate the QR Code for XML
// $xmlOut = (new QRCode($xmlOptions))->render($data);

// // Path to the logo
// $logoPath = __DIR__ . '/logo.png';

// // Path to save the final image with logo
// $outputPath = __DIR__ . '/qrcode_with_logo.png';

// // Overlay the logo on the PNG QR Code
// overlayLogo($pngOut, $logoPath, $outputPath);

// // Output the SVG QR Code
// if (PHP_SAPI !== 'cli') {
//     header('content-type: image/svg+xml');
// }
// echo $svgOut;

// // Output the PNG QR Code
// if (PHP_SAPI !== 'cli') {
//     header('content-type: image/png');
// }
// echo $pngOut;

// // Output the JPEG QR Code
// if (PHP_SAPI !== 'cli') {
//     header('content-type: image/jpeg');
// }
// echo $jpegOut;

// // Output the EPS QR Code
// if (PHP_SAPI !== 'cli') {
//     header('content-type: application/postscript');
// }
// echo $epsOut;

// // Output the XML QR Code
// if (PHP_SAPI !== 'cli') {
//     header('content-type: application/xml');
// }
// echo $xmlOut;

        // Get the selected output format from the form
        $qr_code_format = $_POST['qr_code_format'];

        // Determine the output interface based on the selected format
        switch ($qr_code_format) {
            case 'svg':
                $outputInterface = QRMarkupSVG::class;
                $contentType = 'image/svg+xml';
                break;
            case 'png':
                $outputInterface = QRGdImage::class;
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
            default:
                $outputInterface = QRMarkupSVG::class;
                $contentType = 'image/svg+xml';
        }

        // Prepare the options for the selected output format
        $options = prepareOptions($outputInterface, $dotColors, $version, $circleRadius, $drawCircularModules);

        // Data to encode
        // $data = 'https://www.youtube.com/watch?v=dQw4w9WgXcQ';

        // Generate the QR Code
        $qrOut = (new QRCode($options))->render($this->qr_text);

        // Path to save the final image with logo
        $outputPath = __DIR__ . '/qrcode_with_logo.png';

        // Overlay the logo on the PNG QR Code if a logo is uploaded and the format is PNG
        if ($qr_code_format === 'png' && isset($_FILES['logo']) && $_FILES['logo']['error'] == UPLOAD_ERR_OK) {
            $logoPath = $_FILES['logo']['tmp_name'];
            overlayLogo($qrOut, $logoPath, $outputPath);
            $qrOut = file_get_contents($outputPath);
        }

        // Function to overlay circular modules with an image
    function overlayCircularModules($qrImage, $moduleImage, $outputPath) {
        $qr = imagecreatefromstring($qrImage);
        $module = imagecreatefromstring(file_get_contents($moduleImage));

        // Get dimensions
        $qrWidth = imagesx($qr);
        $qrHeight = imagesy($qr);
        $moduleWidth = imagesx($module);
        $moduleHeight = imagesy($module);

        // Overlay circular modules
        for ($x = 0; $x < $qrWidth; $x += $moduleWidth) {
            for ($y = 0; $y < $qrHeight; $y += $moduleHeight) {
                imagecopyresampled($qr, $module, $x, $y, 0, 0, $moduleWidth, $moduleHeight, $moduleWidth, $moduleHeight);
            }
        }        

        // Output the QR Code
        if (PHP_SAPI !== 'cli') {
            header('content-type: ' . $contentType);
        }

        // echo $qrOut;
        // echo "<img src='".$qrOut . "' />";
        return $qrOut;

        // Overlay circular modules with an image if selected
     if ($drawCircularModules === 'image1') {
        // print_r($drawCircularModules);
        $moduleImage = plugin_dir_path(__FILE__) . 'images/circle1.png';
        overlayCircularModules($qrOut, $moduleImage, $outputPath);
        $qrOut = file_get_contents($outputPath);
    } elseif ($drawCircularModules === 'image2') {
        $moduleImage = plugin_dir_path(__FILE__) . 'images/circle2.png';
        overlayCircularModules($qrOut, $moduleImage, $outputPath);
        $qrOut = file_get_contents($outputPath);
       
     }

            
 
    //  private function calculateScale(): int {
         // Let the library handle scaling automatically
         return max(5, (int)round($this->size / 100));
      }
 
    //   private function addLogoOverlay(string $qrData): string {
         $qrImage = imagecreatefromstring($qrData);
         $logo = imagecreatefromstring(file_get_contents($this->logo_path));
 
         // ... [Keep previous logo merging code] ...
 
         ob_start();
         if($this->format === 'jpg'){
             imagejpeg($qrImage, null, 100);
         } else {
             imagepng($qrImage);
         }
         $combined = ob_get_clean();
 
         // ... [Keep cleanup code] ...
 
         return $combined;
     }
 
     public function saveToFile(string $path): string {
         $data = $this->generate($this->qr_text);
         $ext = $this->format === 'jpg' ? 'jpeg' : $this->format;
         $filename = sanitize_file_name(md5(uniqid().$this->qr_text).'.'.$ext);
         $fullpath = trailingslashit($path).$filename;
 
         file_put_contents($fullpath, $data);
 
         return $fullpath;
     }

     
    }

     
   }
