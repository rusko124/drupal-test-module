  (function ($) {
      'use strict';

      Drupal.behaviors.status_messager_behavior = {
        attach: function (context) {
          function close(){
            $('.system-modal-window').remove();
            $('.system-modal-overlay').remove();
          }

          if(!($('.system-modal-window.invisible').length)){
            $('.system-modal-overlay').click(close);
            $('.close-button').click(close);

            // // draggable
            $('body').on('mousedown', '.modal-title', function() {
              $('.system-modal-window').addClass('draggable').parents().on('mousemove', function(e) {
                $('.draggable').offset({
                  top: e.pageY - 15,
                  left: e.pageX - $('.modal-title').outerWidth() / 2
                }).on('mouseup', function() {
                    $('.system-modal-window').removeClass('draggable');
                });
              });
            }).on('mouseup', function() {
              $('.draggable').removeClass('draggable');
            });

            // settings
            $('.system-modal-window').css({'width': drupalSettings.status_messager.width,
              'height': drupalSettings.status_messager.height,
              'left':'calc((100% - '+drupalSettings.status_messager.width+'px)/2)',
              'top':'calc((100% - '+drupalSettings.status_messager.height+'px)/2)'
            });
            $(".system-modal-window-body").css({'background-color': drupalSettings.status_messager.color});

          }
        }
      }
  }(jQuery));
