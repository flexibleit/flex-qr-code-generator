jQuery(document).ready(function($){
   $(".qr-code-design").on("click", function(){
      $(".qr-code-design").removeClass('active');
      $(this).addClass('active');
   });
   $(".qr-code-eye-style").on("click", function(){
      $(".qr-code-eye-style").removeClass('active');
      $(this).addClass('active');
   });
});