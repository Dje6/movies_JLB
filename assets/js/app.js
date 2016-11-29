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
