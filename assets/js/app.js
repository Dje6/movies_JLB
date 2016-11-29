$('#showFiltres').click(function(event) {
  $(this).next('form').slideToggle("slow");
});


$(".addList").on("click",function(e) {
  e.preventDefault();
  $.ajax({
    type:'POST',
    url: 'includes/addList.php',
    data: {id:$(this).attr('id')},
    dataType:"Json",
    beforeSend: function(){
    },
    success: function(response){
      if(response.success === true){
console.log('ok');
      }else{
console.log('pas ok');
      }
    },
    error: function(response){
      console.log(response);
    }
  });
});

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
