/**
 *  Authors: Valery Bogdanov
*/
$(document).ready(function () {
  searchBox();
  fancyboxInit();

  if ($('html').hasClass('-device_desktop')) {

  }
});
$(window).resize(function () {

});
$(window).load(function () {

});


function searchBox() {
  $('.js-searchShow, .js-searchHide').on('click', function(e){
    e.preventDefault();
    $('.js-searchForm').fadeToggle('fast', 'linear');
    if ($(this).hasClass('js-searchShow')) {
      $('.js-searchForm').find('input[name="s"]').trigger('focus');
    }
  });
}

function fancyboxInit() {
  $('.b-text a[href$=".jpg"], .b-text a[href$=".jpeg"], .b-text a[href$=".png"]').fancybox({
    openEffect	: 'none',
    closeEffect	: 'none',
    beforeShow : function() {
      var alt = this.element.find('img').attr('alt');
      this.inner.find('img').attr('alt', alt);
      this.title = alt;
    }
  });
  $('.js-fancybox').fancybox({
    type : 'iframe'
  });
}
