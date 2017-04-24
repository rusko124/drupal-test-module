(function ($) {
  'use strict';

  Drupal.behaviors.status_messager_behavior = {
    attach: function (context,settings) {
      function close(){
        $(context).find('.system-modal-window').remove();
        $(context).find('.system-modal-overlay').remove();
      }

      if(!($(context).find('.system-modal-window.invisible').length)){
        $(context).find('.system-modal-overlay').click(close);
        $(context).find('.close-button').click(close);

            // // draggable
        $(context).find('body').on('mousedown', '.system-modal-window-title', function() {
          $(context).find('.system-modal-window').addClass('draggable').parents().on('mousemove', function(e) {
            $(context).find('.draggable').css({'-webkit-user-select':'none'})
            $(context).find('.draggable').offset({
              top: e.pageY - 15,
              left: e.pageX - $('.system-modal-window-title').outerWidth() / 2
            }).on('mouseup', function() {
              $(context).find('.system-modal-window').removeClass('draggable');
            });
          });
        }).on('mouseup', function() {
          $(context).find('.draggable').css({'-webkit-user-select':'auto'})
          $(context).find('.draggable').removeClass('draggable');
        });

            // settings
        $(context).find('.system-modal-window').css({'width': settings.status_messager.width,
          'height': settings.status_messager.height,
          'left':'calc((100% - '+settings.status_messager.width+'px)/2)',
          'top':'calc((100% - '+settings.status_messager.height+'px)/2)'
        });
        $(context).find('#status-messager').css({'background-color': settings.status_messager.color});
      }
    }
  }
}(jQuery));
