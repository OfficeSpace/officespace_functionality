(function($){
  $(document).ready(function(){
    $('div.pie_chart_partial').each(function(){
      var svg = "<svg class='pie-chart' viewBox='0 0 32.0 32.0'>"+
                  "<circle = cx='16' cy='16' r='16' stroke-dasharray='86 100' stroke-width='32'></circle>"
                "</svg>";
      $(this).html(svg);

    });
    $('div.pie_chart_half').each(function(){
      var svg = "<svg class='pie-chart' viewBox='0 0 32.0 32.0'>"+
                  "<circle = cx='16' cy='16' r='16' stroke-dasharray='52 100' stroke-width='32' transform='rotate(-90)''></circle>"
                "</svg>";
      $(this).html(svg);

    });
  })
})(jQuery)
