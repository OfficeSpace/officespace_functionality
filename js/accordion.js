(function($){

  $(document).ready(function(){

    $(document).on('click','.expand', function(){
      $(this).next('.collapse').toggleClass('open');
    })
  })

})(jQuery)
