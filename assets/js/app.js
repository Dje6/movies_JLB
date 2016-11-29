//toggle filtre recherche
$('#showFiltres').click(function(event) {
  $(this).next('form').slideToggle("slow");
});
//demarag de la fonction pour le vote etoile
$(function(){                   // Start when document ready
  $('#star-rating').rating(function(vote,id_mov, event){
          // we have vote and event variables now, lets send vote to server.
          $this = $(this);
      $.ajax({
          url: "includes/Note.php",
          type: "POST",
          data: {note: vote,
                id: id_mov
              },
          dataType:"Json",
          beforeSend: function(){
          },
          success: function(response){
            if(response.success === true){
              $('#star-rating').html('<br/>'+response.message);
            }else{
              $('#star-rating').html('<br/>'+response.message);
            }
          },
          error: function(response){
            console.log(response);
          }

      });
  });
});

//ajout du film a voir
$(".addList").on("click",function(e) {
  e.preventDefault();
  $this = $(this);

  $.ajax({
    type:'POST',
    url: 'includes/addList.php',
    data: {id:$(this).attr('id')},
    dataType:"Json",
    beforeSend: function(){
    },
    success: function(response){
      if(response.success === true){
        $this.html(response.message);
        $this.removeClass('btn-warning');
        $this.off('click');
        $this.removeClass('addList');
        $this.addClass('btn-success');
        $this.attr("href", "avoir.php")
      }else{
        $this.off('click');
        $this.html(response.message);
        $this.attr("href", "avoir.php")
      }
    },
    error: function(response){
      console.log(response);
    }
  });
});
//systeme de vote des etoiles
;(function($){
    $.fn.rating = function(callback){

        callback = callback || function(){};

        // each for all item
        this.each(function(i, v){

            $(v).data('rating', {callback:callback})
                .bind('init.rating', $.fn.rating.init)
                .bind('set.rating', $.fn.rating.set)
                .bind('hover.rating', $.fn.rating.hover)
                .trigger('init.rating');
        });
    };

    $.extend($.fn.rating, {
        init: function(e){
            var el = $(this),
                list = '',
                isChecked = null,
                childs = el.children(),
                i = 0,
                l = childs.length;

            for (; i < l; i++) {
                list = list + '<a class="star" title="' + $(childs[i]).val() + '" id="' + $(childs[i]).attr('id') + '" />';
                if ($(childs[i]).is(':checked')) {
                    isChecked = $(childs[i]).val();
                };
            };

            childs.hide();

            el
                .append('<div class="stars">' + list + '</div>')
                .trigger('set.rating', isChecked);

            $('a', el).bind('click', $.fn.rating.click);
            el.trigger('hover.rating');
        },
        set: function(e, val) {
            var el = $(this),
                item = $('a', el),
                input = undefined;

            if (val) {
                item.removeClass('fullStar');

                input = item.filter(function(i){
                    if ($(this).attr('title') == val)
                        return $(this);
                    else
                        return false;
                });

                input
                    .addClass('fullStar')
                    .prevAll()
                    .addClass('fullStar');
            }

            return;
        },
        hover: function(e){
            var el = $(this),
                stars = $('a', el);

            stars.bind('mouseenter', function(e){
                // add tmp class when mouse enter
                $(this)
                    .addClass('tmp_fs')
                    .prevAll()
                    .addClass('tmp_fs');

                $(this).nextAll()
                    .addClass('tmp_es');
            });

            stars.bind('mouseleave', function(e){
                // remove all tmp class when mouse leave
                $(this)
                    .removeClass('tmp_fs')
                    .prevAll()
                    .removeClass('tmp_fs');

                $(this).nextAll()
                    .removeClass('tmp_es');
            });
        },
        click: function(e){
            e.preventDefault();
            var el = $(e.target),
                container = el.parent().parent(),
                inputs = container.children('input'),
                rate = el.attr('title');
                id_mov = el.attr('id');

            matchInput = inputs.filter(function(i){
                if ($(this).val() == rate)
                    return true;
                else
                    return false;
            });

            matchInput
                .prop('checked', true)
				.siblings('input').prop('checked', false);

            container
                .trigger('set.rating', matchInput.val())
                .data('rating').callback(rate,id_mov, e);
        }
    });

})(jQuery);
//retirer un film de la liste a voir
$(".removeList").on("click", function(event) {
  event.preventDefault();
  $this = $(this);
  $.ajax({
    type: 'POST',
    url: 'includes/removeList.php',
    data: {id:$(this).attr('id')},
    dataType: "Json",

    success: function(response){
      if(response.success === true){
        $('#'+$this.attr('id')).remove();
        console.log(response.message);
        location.reload();
      } else {
        console.log(response.message);
      }
    },
    error: function(){
      console.error('ERROR');
    }
  })
})
