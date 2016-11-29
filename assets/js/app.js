$('#showFiltres').click(function(event) {
  $(this).next('form').slideToggle("slow");
});
$(function(){                   // Start when document ready
  $('#star-rating').rating(function(vote, event){
          // we have vote and event variables now, lets send vote to server.
      $.ajax({
          url: "includes/Note.php",
          type: "POST",
          data: {note: vote,id:$(this).attr('id')},
      });
  });

});


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
                .data('rating').callback(rate, e);
        }
    });

})(jQuery);
