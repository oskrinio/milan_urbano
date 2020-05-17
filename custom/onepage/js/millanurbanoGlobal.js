
var HOME = {
	init:function(){
	if (document.body.id === 'onepage-form') {
      this.sliderFull();
      this.tabs();
      this.gallery();
    }	
  },
  tabs: function () {
    var el = $("#box-tabs");
    if ($(el).find('.header-tabs ul li').hasClass('tab-active')){
      $(el).find('.panel').hide().eq(0).show();   
    }
    $(el).find('.header-tabs ul li').click(function(e){
      e.preventDefault();
      $(el).find('.content-tabs .panel').stop(true,true).slideUp('fast');  
      $(el).find('.header-tabs ul li').removeClass("tab-active");
      var id = $(el).find(this).find('a').attr("href");
      jQuery(id).slideDown('2000'); 
      $(el).find(this).addClass("tab-active");      
    });  
  },
  sliderFull: function () {
    $('.lb-slides').slick({
      arrows: false,
    });
  },
  gallery: function () {
    $('.slider-gallery').slick({
      arrows: true,
    });
  }
} 

jQuery(document).ready(function(){
  HOME.init(); 
  console.log('sasd');
 
}); 








