jQuery(document).ready(function($){
   $(".qr-code-design").on("click", function(){
      $(".qr-code-design").removeClass('active');
      $(this).addClass('active');
   });
   $(".qr-code-eye-style").on("click", function(){
      $(".qr-code-eye-style").removeClass('active');
      $(this).addClass('active');
   });

   $('#flexqrcode_input_page').hide();
   $('#flexqrcode_input_post').hide();
   $('#flexqrcode_input_product').hide();

   $('#flexqrcode_select_page_option').on('change', function() {
      var selectedValue = $('#flexqrcode_select_page_option').val();

      if (selectedValue === 'page') {
         $('#flexqrcode_input_page').show();
         $('#flexqrcode_input_post').hide();
         $('#flexqrcode_input_product').hide();
      } else if(selectedValue === 'post') {
         $('#flexqrcode_input_post').show();
         $('#flexqrcode_input_page').hide();
         $('#flexqrcode_input_product').hide();
      }else if(selectedValue === 'product') {
         $('#flexqrcode_input_product').show();
         $('#flexqrcode_input_post').hide();
         $('#flexqrcode_input_page').hide();
      } 
  

   var currentContent = $("#qr_code_input_page").val();
   var currentContent = $("#qr_code_input_post").val();
   var currentContent = $("#qr_code_input_product").val();
   
   if (selectedValue !== "") {
       var newContent = currentContent + " " + selectedValue;
       $("#qr_code_text").val(newContent);
   }
   });
   $("#flexqrcode_input_page select,#flexqrcode_input_post select ,#flexqrcode_input_product select").on("change", function(){
      var inputVal = $(this).val();
      $("#flexqrcode_code_text").val(inputVal);
   })
});

jQuery(document).ready(function($) {
   $('#qrForm').on('submit', function(event) {
       event.preventDefault();
       var formData = new FormData(this);
       $.ajax({
           url: ajaxurl,
           type: 'POST',
           data: formData,
           processData: false,
           contentType: false,
           success: function(response) {
               $('#qrCodeOutput').html('<img src="' + response.qrCode + '" alt="QR Code">');
               // $('#qrCodeOutput_1').html(response.qrCode);
           },
           error: function(xhr, status, error) {
               console.error('AJAX Error: ' + status + error);
           }
       });
   });
});