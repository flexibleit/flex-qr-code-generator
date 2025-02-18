<?php
   use chillerlan\QRCode\QRCode;
   use chillerlan\QRCode\QROptions;
   use chillerlan\QRCode\Output\QROutputInterface;
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
         print_r($data);
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
         $options = new QROptions([
             'version'          => 5,
             'outputType'       => $this->format,
             'scale'            => $this->calculateScale(),
             'margin'           => $this->margin,
             'moduleValues'     => [
                 1536 => $this->dot_color, // dot color
                 6     => $this->eye_color, // eye color
             ],
         ]);
 
         $qrcode = new QRCode($options);
         $qrData = $qrcode->render($this->qr_text);
         // echo "<img src='data:image/png;base64," . $qrData . "' />";
         if ($this->logo_path) {
             $qrData = $this->addLogoOverlay($qrData);
         }
 
         return $qrData;
     }
 
     private function calculateScale(): int {
         // Calculate scale based on size and margin
         $baseSize = 21 + ($this->margin * 2);
         return max(1, floor($this->size / $baseSize));
     }
 
     private function addLogoOverlay(string $qrData): string {
         $qrImage = imagecreatefromstring($qrData);
         $logo = imagecreatefromstring(file_get_contents($this->logo_path));
         
         $qrWidth = imagesx($qrImage);
         $qrHeight = imagesy($qrImage);
         $logoWidth = imagesx($logo);
         $logoHeight = imagesy($logo);
         
         // Calculate logo size (20% of QR code size)
         $newLogoWidth = $qrWidth * 0.2;
         $newLogoHeight = $logoHeight * ($newLogoWidth / $logoWidth);
         
         // Resize logo
         $resizedLogo = imagescale($logo, $newLogoWidth, $newLogoHeight);
         
         // Calculate position
         $x = ($qrWidth - $newLogoWidth) / 2;
         $y = ($qrHeight - $newLogoHeight) / 2;
         
         // Merge images
         imagecopymerge(
             $qrImage,
             $resizedLogo,
             $x,
             $y,
             0,
             0,
             $newLogoWidth,
             $newLogoHeight,
             100
         );
 
         ob_start();
         imagepng($qrImage);
         $combined = ob_get_clean();
         
         imagedestroy($qrImage);
         imagedestroy($logo);
         imagedestroy($resizedLogo);
 
         return $combined;
     }
 
     public function saveToFile(string $path): string {
         $data = $this->generate();
         $ext = $this->format === 'jpg' ? 'jpeg' : $this->format;
         $filename = md5(uniqid()) . '.' . $ext;
         $fullpath = trailingslashit($path) . $filename;
         
         file_put_contents($fullpath, $data);
         
         return $fullpath;
     }
   }
}