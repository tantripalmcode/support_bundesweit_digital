 jQuery(document).ready(function ($) {
				$('.wpcf7-special-radio-container-thema input').addClass('wpcf7-special-radio-thema');
				$('.wpcf7-special-radio-thema').each(function (index, el) {
					var label = $('<label>').attr('for', 'special_radio_thema_'+index).addClass('thema').addClass('special_radio_card_thema_'+index);
					$(this).attr('id', 'special_radio_thema_'+index);
				$(this).after(label);
				});
		});


 jQuery(document).ready(function ($) {
				$('.wpcf7-special-radio-container-plattform input').addClass('wpcf7-special-radio-plattform');
				$('.wpcf7-special-radio-plattform').each(function (index, el) {
					var label = $('<label>').attr('for', 'special_radio_plattform_'+index).addClass('plattform').addClass('special_radio_card_plattform_'+index);
					$(this).attr('id', 'special_radio_plattform_'+index);
				$(this).after(label);
				});
		});


jQuery(document).ready(function (){

    jQuery(".wpforms-field-container div").each(function(){

      if( jQuery(this).hasClass("grid-left")){

        jQuery(this).appendTo(".wpforms-grid-item-left")
      }

      if( jQuery(this).hasClass("grid-right")){

        jQuery(this).appendTo(".wpforms-grid-item-right")
      }
	
		if( jQuery(this).hasClass("grid-center")){
          
        jQuery(this).appendTo(".wpforms-grid-item-center")
      }

  });

});

jQuery(document).ready(function (){

    jQuery(".wpforms-submit-container").appendTo(".wpforms-grid-item-right");
});
