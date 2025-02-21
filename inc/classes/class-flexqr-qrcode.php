<?php

use chillerlan\QRCode\{QRCode, QROptions};
use chillerlan\QRCode\Common\EccLevel;
use chillerlan\QRCode\Data\QRMatrix;
use chillerlan\QRCode\Output\{QRMarkupSVG, QRGdImage, QRGdImagePNG, QRInterventionImage, QRMarkupXML};
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
      private $drawCircularModules;
      private $circleRadius;
      public $dataLight;

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
         $this->circleRadius = (float) $data['circleRadius'] ?? 0.4;
         $this->drawCircularModules = $data['drawCircularModules'] == 1 ? true : false;
        //  echo 'dataLight'.$data['dataLight'];
         $this->dataLight = $this->hexToRgb($data['dataLight']);
        //  print_r($this->dataLight);         
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

        // Custom colors for different parts of the QR code
        // $dotColors = [
        //     QRMatrix::M_FINDER_DARK => $_POST['finderDark'],
        //     QRMatrix::M_FINDER_DOT  => $_POST['finderDot'],
        //     // QRMatrix::M_ALIGNMENT_DARK => $_POST['alignmentDark'],
        //     QRMatrix::M_DATA_DARK   => $_POST['dataDark'],
        //     QRMatrix::M_FINDER       => $_POST['dataLight'],
        // ];

        // Get the selected version from the form
        $version = (int)$_POST['version'];
       
        // Function to prepare options for different formats
        // function prepareOptions($outputInterface, $dotColors, $version, $circleRadius, $drawCircularModules) {
           
        $options = new QROptions([
                'version'             => $version,
                'eccLevel'            => EccLevel::H,
                'addQuietzone'        => true,
                'outputBase64'        => true,
                'drawLightModules'    => true,
                'connectPaths'        => true,
                'drawCircularModules' => $this->drawCircularModules,
                'circleRadius'        => $this->circleRadius,
                'outputInterface'     => QRGdImagePNG::class,
                'moduleValues'        => [
                    /// finder
                    QRMatrix::M_FINDER_DARK    => [0, 63, 255], // dark (true)
                    QRMatrix::M_FINDER_DOT     => [0, 63, 255], // finder dot, dark (true)
                    QRMatrix::M_FINDER         => $this->dataLight, // light (false), white is the transparency color and is enabled by default
                    // alignment
                    QRMatrix::M_ALIGNMENT_DARK => [255, 0, 255],
                    QRMatrix::M_ALIGNMENT      => [233, 233, 233],
                    // timing
                    QRMatrix::M_TIMING_DARK    => [255, 0, 0],
                    QRMatrix::M_TIMING         => [233, 233, 233],
                    // format
                    QRMatrix::M_FORMAT_DARK    => [67, 159, 84],
                    QRMatrix::M_FORMAT         => [233, 233, 233],
                    // version
                    QRMatrix::M_VERSION_DARK   => [62, 174, 190],
                    QRMatrix::M_VERSION        => [233, 233, 233],
                    // data
                    QRMatrix::M_DATA_DARK      => [0, 0, 0],
                    QRMatrix::M_DATA           => [233, 233, 233],
                    // darkmodule
                    QRMatrix::M_DARKMODULE     => [0, 0, 0],
                    // separator
                    QRMatrix::M_SEPARATOR      => [233, 233, 233],
                    // quietzone
                    QRMatrix::M_QUIETZONE      => [233, 233, 233],
                    // logo (requires a call to QRMatrix::setLogoSpace()), see QRImageWithLogo
                    QRMatrix::M_LOGO           => [233, 233, 233],        
                    ]]);

        //     return $options;
        // }

        // Get the selected output format from the form
        $qr_code_format = $this->format;

        // Determine the output interface based on the selected format
        switch ($qr_code_format) {
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
            // default:
            //     $outputInterface = QRMarkupSVG::class;
            //     $contentType = 'image/svg+xml';
        }

        // Prepare the options for the selected output format
        // $options = prepareOptions($outputInterface, $dotColors, $version, $this->circleRadius, $this->drawCircularModules);

        // Data to encode
        // $data = 'https://www.youtube.com/watch?v=dQw4w9WgXcQ';

        // Generate the QR Code
        $qrOut = (new QRCode($options))->render($this->qr_text);
//  echo 'rtyrt'.$this->dataLight;
        // header('Content-type: image/png');

        // if(PHP_SAPI !== 'cli'){
        //     // if viewed in the browser, we should push it as file download as EPS isn't usually supported
        //     header('Content-type: application/postscript');
        //     header('Content-Disposition: filename="qrcode-2.eps"');
        // }        

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